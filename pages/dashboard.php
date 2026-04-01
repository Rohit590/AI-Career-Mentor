<?php
include("../includes/auth.php");
include("../includes/db.php");
set_time_limit(120);
$user_id = $_SESSION['user_id'];

if (isset($_POST['search'])) {

    $goal_input = mysqli_real_escape_string($conn, $_POST['search_goal']);

    // 1. CHECK / INSERT GOAL
    $check_goal = mysqli_query($conn, "SELECT * FROM goals WHERE name='$goal_input'");

    if (mysqli_num_rows($check_goal) > 0) {
        $goal_data = mysqli_fetch_assoc($check_goal);
        $goal_id = $goal_data['id'];
    } else {
        mysqli_query($conn, "INSERT INTO goals (name) VALUES ('$goal_input')");
        $goal_id = mysqli_insert_id($conn);
    }

    // 2. CHECK ROADMAP
    $existing = mysqli_query($conn, "SELECT * FROM roadmaps WHERE goal_id='$goal_id'");

    // ALWAYS regenerate roadmap
    mysqli_query($conn, "DELETE FROM roadmaps WHERE goal_id='$goal_id'");

    $response = file_get_contents(
        "http://localhost/ai-career-mentor/api/ai_handler.php",
        false,
        stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded",
                'content' => http_build_query(['goal' => $goal_input])
            ]
        ])
    );

    $steps = preg_split('/\r\n|\r|\n/', $response);

    $step_number = 1;

    foreach ($steps as $step) {

        $step = trim($step);
        if (empty($step)) continue;

        if (preg_match('/\[(.*?)\]\s*(.*)/', $step, $matches)) {
            $type = $matches[1];
            $title = $matches[2];
        } else {
            $type = "Learning";
            $title = $step;
        }

        mysqli_query(
            $conn,
            "INSERT INTO roadmaps (goal_id, step_title, source, type, step_order)
            VALUES ('$goal_id', '$title', 'ai', '$type', '$step_number')"
        );

        $step_number++;
    }

    // deactivate old goals
    mysqli_query(
        $conn,
        "UPDATE user_goals 
        SET status='completed'
        WHERE user_id='$user_id' AND status='active'"
    );

    // set new goal
    mysqli_query(
        $conn,
        "INSERT INTO user_goals (user_id, goal_id, status)
        VALUES ('$user_id', '$goal_id', 'active')"
    );

    // refresh goal immediately
    $current_goal = mysqli_fetch_assoc(mysqli_query(
        $conn,
        "SELECT g.id as goal_id, g.name 
     FROM user_goals ug
     JOIN goals g ON ug.goal_id = g.id
     WHERE ug.user_id='$user_id' AND ug.status='active'
     ORDER BY ug.id DESC LIMIT 1"
    ));

    $goal = $current_goal['name'] ?? null;
    $goal_id = $current_goal['goal_id'] ?? null;
}
$percent = 0;

// ALWAYS LOAD ACTIVE GOAL 
$current_goal = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT g.id as goal_id, g.name 
     FROM user_goals ug
     JOIN goals g ON ug.goal_id = g.id
     WHERE ug.user_id='$user_id' AND ug.status='active'
     ORDER BY ug.id DESC LIMIT 1"
));

$goal = $current_goal['name'] ?? null;
$goal_id = $current_goal['goal_id'] ?? null;;


if (isset($_POST['complete_task'])) {

    $rid = $_POST['task_id'];

    // Check if already completed
    $check = mysqli_query(
        $conn,
        "SELECT * FROM user_progress 
         WHERE user_id='$user_id' AND roadmap_id='$rid'"
    );

    if (mysqli_num_rows($check) == 0) {

        // Save task completion
        mysqli_query(
            $conn,
            "INSERT INTO user_progress (user_id, roadmap_id)
             VALUES ('$user_id', '$rid')"
        );

        // ✅ Add XP (10 per task)
        mysqli_query(
            $conn,
            "UPDATE users SET xp = xp + 10 WHERE id='$user_id'"
        );
    }
}




?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/theme.css">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
        }

        /* ===== BACKGROUND GLOW ===== */
        body::before {
            content: "";
            position: fixed;
            top: -200px;
            left: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.3), transparent);
            filter: blur(100px);
            z-index: -1;
        }

        body::after {
            content: "";
            position: fixed;
            bottom: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.3), transparent);
            filter: blur(100px);
            z-index: -1;
        }

        /* :root {
            --bg-color: #0B0F19;
            --text-color: white;
            --card-bg: rgba(17, 24, 39, 0.6);
            --input-bg: #1F2937;
        }

        html.light-mode {
            --bg-color: #f9fafb;
            --text-color: black;
            --card-bg: white;
            --input-bg: #e5e7eb;
        } */

        /* MAIN FIX */
        .main {
            margin-top: 80px;
            /* important for navbar spacing */
        }

        /* MAIN */
        .main {
            flex: 1;
            padding: 40px;
        }

        /* HEADER */
        .main h1 {
            margin-bottom: 20px;
        }

        /* CARD */
        .card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 25px;
            border-radius: 15px;
            margin-top: 20px;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 25px rgba(139, 92, 246, 0.2);
        }

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        /* BUTTON */
        button {
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            color: white;
            cursor: pointer;
        }

        /* INPUT */
        input {
            padding: 12px;
            width: 300px;
            border-radius: 8px;
            border: none;
            outline: none;
            background: var(--input-bg);
            color: var(--text-color);
        }

        .task {
            background: var(--card-bg);
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
            transition: 0.3s;
        }

        .task:hover {
            background: rgba(31, 41, 55, 0.8);
        }

        .check-btn {
            border: none;
            background: #3B82F6;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        .done {
            color: #10B981;
            font-size: 18px;
        }

        /* ===== HERO SECTION ===== */
        .hero {
            min-height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;

            background: radial-gradient(circle at top, rgba(139, 92, 246, 0.2), transparent);
        }

        .hero h1 {
            font-size: 42px;
            margin-bottom: 10px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            color: transparent;
        }

        .hero p {
            color: #9CA3AF;
            margin-bottom: 20px;
        }

        /* SEARCH BOX */
        .search-box {
            display: flex;
            gap: 10px;
            background: rgba(17, 24, 39, 0.6);
            padding: 10px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .search-box input {
            border: none;
            outline: none;
            padding: 12px;
            width: 300px;
            border-radius: 8px;
            background: var(--input-bg);
            color: var(--text-color);
        }

        .search-box button {
            padding: 12px 20px;
            border-radius: 8px;
        }

        /* ===== CENTER MAIN CONTENT ===== */
        .main {
            padding: 0 40px 40px;
        }

        /* ===== GRID IMPROVE ===== */
        .grid {
            margin-top: 20px;
        }

        /* ===== CARD ENHANCE ===== */
        .card {
            backdrop-filter: blur(12px);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(139, 92, 246, 0.2);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 28px;
            }

            .search-box {
                flex-direction: column;
                width: 90%;
            }

            .search-box input {
                width: 100%;
                transition: 0.3s;
            }

            .search-box input:focus {
                transform: scale(1.05);
                box-shadow: 0 0 15px rgba(139, 92, 246, 0.5);
            }
        }

        body {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.98);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ===== LOADER OVERLAY ===== */
        #loader {
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(11, 15, 25, 0.9);
            backdrop-filter: blur(10px);
            top: 0;
            left: 0;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        /* LOADER BOX */
        .loader-box {
            text-align: center;
            color: white;
        }

        /* SPINNER */
        .spinner {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(255, 255, 255, 0.2);
            border-top: 5px solid #8B5CF6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: auto;
        }

        /* TEXT */
        .loader-box p {
            margin-top: 15px;
            font-size: 16px;
            color: #9CA3AF;
        }

        /* ANIMATION */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* ===== ROADMAP UI ===== */
        .roadmap-container {
            margin-top: 20px;
            margin-bottom: 60px;
            min-height: 70px;
            padding-bottom: 40px;
        }

        .roadmap-step {
            display: flex;
            align-items: center;
            background: var(--card-bg);
            padding: 18px;
            border-radius: 14px;
            margin-bottom: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            transition: 0.3s ease;
        }

        .roadmap-step:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 25px rgba(139, 92, 246, 0.2);
        }

        .step-number {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #8B5CF6, #3B82F6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }

        .step-content {
            flex: 1;
        }

        .step-title {
            font-weight: 500;
        }

        .step-type {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 20px;
            margin-left: 10px;
            background: rgba(139, 92, 246, 0.2);
            color: #C4B5FD;
        }

        .step-actions {
            margin-left: 10px;
        }

        .card+.card {
            margin-top: 25px;
        }

        .main {
            min-height: 100vh;
        }

        body {
            overflow-y: auto;
        }

        .main {
            display: block;
        }

        .hero {
            margin-bottom: 40px;
        }

        .card {
            clear: both;
        }
    </style>
</head>

<body>
    <?php include("../includes/navbar.php"); ?>

    <div id="loader">
        <div class="loader-box">
            <div class="spinner"></div>
            <p>Generating your AI roadmap... This may take few seconds⌛</p>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main">


        <div class="hero">

            <h1>Welcome, <?php echo $_SESSION['user_name']; ?> 👋</h1>
            <p>Your AI-powered career roadmap starts here</p>

            <form method="POST" onsubmit="showLoader()" class="search-box">
                <input type="text" name="search_goal" placeholder="Search your dream career..." required>
                <button name="search" id="generateBtn">🚀 Generate</button>
            </form>

        </div>


        <?php
        $user_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'"));

        $xp = $user_data['xp'];
        $level = floor($xp / 100) + 1;
        ?>

        <div class="grid">

            <div class="card">
                <h3>XP Points</h3>
                <p><?php echo $xp; ?> XP</p>
            </div>

            <div class="card">
                <h3>Level</h3>
                <p>Level <?php echo $level; ?></p>
            </div>

        </div>
        <?php
        $next_level_xp = $level * 100;
        $progress = ($xp / $next_level_xp) * 100;
        ?>

        <div class="card">
            <h3>Level Progress</h3>

            <div style="background:#1F2937; border-radius:10px;">
                <div id="level-bar" style="height:20px; width:0%; background:linear-gradient(90deg,#8B5CF6,#3B82F6); border-radius:10px;"></div>
            </div>

            <p><?php echo round($progress); ?>% to next level</p>
        </div>

        <?php if ($goal) { ?>




            <!-- MAIN DASHBOARD -->
            <div class="card">
                <h2>Your Goal: <?php echo $goal; ?></h2>
            </div>

            <div class="card">
                <h3>Your Roadmap</h3>

                <?php

                $result = mysqli_query(
                    $conn,
                    "SELECT * FROM roadmaps 
                    WHERE goal_id='$goal_id'
                    ORDER BY step_order ASC"
                );


                $total = 0;
                $completed = 0;

                $stepIndex = 1;

                echo "<div class='roadmap-container'>";

                while ($row = mysqli_fetch_assoc($result)) {

                    $total++;
                    $rid = $row['id'];

                    $check = mysqli_query(
                        $conn,
                        "SELECT * FROM user_progress 
                        WHERE user_id='$user_id' AND roadmap_id='$rid'"
                    );

                    $isDone = mysqli_num_rows($check) > 0;

                    if ($isDone) $completed++;

                    echo "<div class='roadmap-step'>";

                    echo "<div class='step-number'>$stepIndex</div>";

                    echo "<div class='step-content'>";
                    echo "<span class='step-title'>" . $row['step_title'] . "</span>";
                    echo "<span class='step-type'>" . $row['type'] . "</span>";
                    echo "</div>";

                    echo "<div class='step-actions'>";
                    echo "<form method='POST'>";

                    echo "<input type='hidden' name='task_id' value='$rid'>";

                    if ($isDone) {
                        echo "<span class='done'>✔</span>";
                    } else {
                        echo "<button class='check-btn' name='complete_task'>✔</button>";
                    }

                    echo "</form>";
                    echo "</div>";

                    echo "</div>";

                    $stepIndex++;
                }

                echo "</div>";
                ?>
            </div>
            <br>
            <?php

            $percent = ($total > 0) ? ($completed / $total) * 100 : 0;

            // ✅ ADD HERE
            if ($percent == 100 && $goal_id) {
                mysqli_query(
                    $conn,
                    "UPDATE user_goals 
                            SET status='completed'
                            WHERE user_id='$user_id' AND goal_id='$goal_id' AND status='active'"
                );
            }
            ?>


            <div class='card'>
                <h3>Progress</h3>

                <div style='background:#1F2937; border-radius:10px;'>
                    <div id='progress-bar' style='height:20px; width:0%; background:linear-gradient(90deg,#3B82F6,#8B5CF6); border-radius:10px;'></div>
                </div>

                <p><?php echo round($percent); ?>% completed</p>
            </div>

            <?php
            if ($percent == 100) {

                echo "
            <div class='card'>
                <h3>🎉 Roadmap Completed!</h3>
                <p>You can now start a new goal 🚀</p>
            </div>
            ";

                // 🔥 AI Suggestion
                $response = file_get_contents("http://localhost/ai-career-mentor/api/suggest_career.php", false, stream_context_create([
                    'http' => [
                        'method' => 'POST',
                        'header' => "Content-type: application/x-www-form-urlencoded",
                        'content' => http_build_query(['goal' => $goal])
                    ]
                ]));

                $suggestions = explode("\n", $response);

                echo "<div class='card'>";
                echo "<h3>🔥 Recommended Next Careers</h3>";

                foreach ($suggestions as $s) {
                    $s = trim($s);
                    if (!empty($s)) {
                        echo "
                <form method='POST'>
                    <input type='hidden' name='search_goal' value='$s'>
                    <button name='search'>👉 $s</button>
                </form>
                ";
                    }
                }

                echo "
            </div>";
            }
            ?>
    </div>

<?php } ?>

</div>

<script>
    gsap.from(".hero h1", {
        y: 50,
        opacity: 0,
        duration: 1,
        ease: "power3.out"
    });

    gsap.from(".hero p", {
        y: 30,
        opacity: 0,
        duration: 1,
        delay: 0.2
    });

    gsap.from(".search-box", {
        scale: 0.8,
        opacity: 0,
        duration: 1,
        delay: 0.4
    });
</script>

<script>
    gsap.from(".card", {
        y: 50,
        opacity: 0,
        duration: 1,
        stagger: 0.2,
        ease: "power3.out"
    });

    gsap.from(".sidebar", {
        x: -100,
        opacity: 0,
        duration: 1
    });

    gsap.to("#progress-bar", {
        width: "<?php echo $percent; ?>%",
        duration: 1.5,
        ease: "power3.out"
    });

    gsap.to("#level-bar", {
        width: "<?php echo $progress; ?>%",
        duration: 1.5,
        ease: "power3.out"
    });
</script>

<script>
    // MOBILE MENU
    function toggleMenu() {
        const nav = document.getElementById("navLinks");
        nav.style.display = nav.style.display === "flex" ? "none" : "flex";
    }

    // DROPDOWN
    function toggleDropdown() {
        const dropdown = document.getElementById("dropdownMenu");
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }
</script>
<script>
    const texts = [
        "Frontend Developer...",
        "AI Engineer...",
        "Full Stack Developer...",
        "Data Scientist..."
    ];

    let i = 0;
    let j = 0;
    let currentText = "";
    let isDeleting = false;

    function typeEffect() {
        let input = document.querySelector(".search-box input");

        if (!input) return;

        currentText = texts[i];

        if (!isDeleting) {
            input.setAttribute("placeholder", currentText.substring(0, j++));
        } else {
            input.setAttribute("placeholder", currentText.substring(0, j--));
        }

        if (j === currentText.length) isDeleting = true;
        if (j === 0) {
            isDeleting = false;
            i = (i + 1) % texts.length;
        }

        setTimeout(typeEffect, isDeleting ? 50 : 100);
    }

    typeEffect();
</script>

<script>
    function showLoader() {
        document.getElementById("loader").style.display = "flex";
    }
</script>
<script>
    window.addEventListener("load", function() {
        const loader = document.getElementById("loader");
        if (loader) {
            loader.style.display = "none";
        }
    });
</script>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const loader = document.getElementById("loader");
        if (loader) {
            loader.style.display = "none";
        }
    });
</script> -->

<script src="../assets/js/theme.js"></script>
</body>

</html>