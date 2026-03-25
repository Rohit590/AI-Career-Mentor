<?php
include("../includes/auth.php");
include("../includes/db.php");

$user_id = $_SESSION['user_id'];

// Handle completion
if (isset($_POST['complete_id'])) {

    $rid = $_POST['complete_id'];

    mysqli_query(
        $conn,
        "INSERT INTO user_progress (user_id, roadmap_id, status)
                VALUES ('$user_id', '$rid', 'completed')"
    );

    header("Location: roadmap.php");
}

if (isset($_POST['generate'])) {

    $goal = $_POST['ai_goal'];

    $response = file_get_contents("http://localhost/ai-career-platform/api/ai_handler.php", false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-type: application/x-www-form-urlencoded",
            'content' => http_build_query(['goal' => $goal])
        ]
    ]));

    $steps = explode("\n", $response);

    // Insert goal
    $goal = mysqli_real_escape_string($conn, $goal);

    // check if goal exists
    $check_goal = mysqli_query($conn, "SELECT * FROM goals WHERE name='$goal'");

    if (mysqli_num_rows($check_goal) > 0) {
        $goal_data = mysqli_fetch_assoc($check_goal);
        $goal_id = $goal_data['id'];
    } else {
        mysqli_query($conn, "INSERT INTO goals (name) VALUES ('$goal')");
        $goal_id = mysqli_insert_id($conn);
    }

    foreach ($steps as $step) {
        $step = trim($step);
        if (!empty($step)) {
            mysqli_query(
                $conn,
                "INSERT INTO roadmaps (goal_id, step_title, source)
                 VALUES ('$goal_id', '$step', 'ai')"
            );
        }
    }

    echo "<script>alert('Roadmap Generated Successfully!');</script>";
    $_POST['show'] = true;
    $_POST['goal_id'] = $goal_id;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Roadmap</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link rel="stylesheet" href="../assets/css/theme.css">

    <style>
        /* BODY */
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
        }

        :root {
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
        }

        /* MAIN CONTAINER */
        .container {
            margin-top: 80px;
            padding: 40px;
        }

        /* CENTER HERO */
        .goal-center {
            min-height: 45vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* CENTER CARD */
        .goal-card {
            width: 500px;
            text-align: center;
        }

        /* CARD */
        .card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 30px;
            border-radius: 16px;
            margin-top: 20px;
            transition: .3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 92, 246, .2);
        }

        /* INPUT */
        select {
            padding: 14px;
            border-radius: 10px;
            border: none;
            outline: none;
            background: var(--input-bg);
            color: var(--text-color);
            width: 100%;
            margin-top: 15px;
        }

        /* BUTTON */
        button {
            padding: 12px 20px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            color: white;
            cursor: pointer;
            margin-top: 15px;
        }

        /* ROADMAP AREA */
        .roadmap-section {
            margin-top: 40px;
        }

        /* TASK */
        .task {
            background: rgba(17, 24, 39, 0.6);
            padding: 16px;
            border-radius: 12px;
            margin-top: 12px;
            transition: .3s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .task:hover {
            transform: translateX(5px);
            background: rgba(31, 41, 55, .8);
        }

        /* PROGRESS */
        .progress-bar {
            width: 100%;
            background: #1F2937;
            border-radius: 10px;
            margin-top: 25px;
        }

        .progress-fill {
            height: 20px;
            width: 0%;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <?php include("../includes/navbar.php"); ?>
    <div class="container">

        <div class="goal-center">
            <div class="card goal-card">
                <h2>Select Your Goal</h2>

                <form method="POST">
                    <select name="goal_id">
                        <option value="">Select Your Goal</option>
                        <?php
                        $result = mysqli_query($conn, "SELECT DISTINCT name, id FROM goals");
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                        ?>
                    </select>
                    <button name="show">Show Roadmap</button>
                </form>
            </div>
        </div>

        <!-- <hr> -->

        <?php
        if (isset($_POST['show']) || isset($_SESSION['roadmap_goal'])) {

            if (isset($_POST['goal_id'])) {
                $goal_id = $_POST['goal_id'];
                $_SESSION['roadmap_goal'] = $goal_id;
            } else {
                $goal_id = $_SESSION['roadmap_goal'];
            }

            $check_user_goal = mysqli_query(
                $conn,
                "SELECT * FROM user_goals 
                WHERE user_id='$user_id' AND goal_id='$goal_id' AND status='active'"
            );

            if (mysqli_num_rows($check_user_goal) == 0) {

                mysqli_query(
                    $conn,
                    "UPDATE user_goals 
                    SET status='completed'
                    WHERE user_id='$user_id' AND status='active'"
                );

                mysqli_query(
                    $conn,
                    "INSERT INTO user_goals (user_id, goal_id, status)
                    VALUES ('$user_id', '$goal_id', 'active')"
                );
            }

            $query = "SELECT * FROM roadmaps WHERE goal_id='$goal_id'";
            $result = mysqli_query($conn, $query);

            $total = mysqli_num_rows($result);
            $completed = 0;

            echo "<div class='roadmap-section'>";
            echo "<div class='card'>";

            $goal_name = mysqli_fetch_assoc(mysqli_query(
                $conn,
                "SELECT name FROM goals WHERE id='$goal_id'"
            ))['name'];
            echo "<h3>Roadmap Steps for '$goal_name': </h3>";
            

            while ($row = mysqli_fetch_assoc($result)) {

                $roadmap_id = $row['id'];

                // Check progress
                $check = mysqli_query(
                    $conn,
                    "SELECT * FROM user_progress 
             WHERE user_id='$user_id' AND roadmap_id='$roadmap_id'"
                );

                if (mysqli_num_rows($check) > 0) {
                    $completed++;
                    $done = "✅";
                } else {
                    $done = "";
                }

                echo "<div class='task'>";
                echo $row['step_title'] . " $done";

                if (!$done) {
                    echo "<form method='POST' style='display:inline;'>
                    <input type='hidden' name='complete_id' value='$roadmap_id'>
                    <button>Complete</button>
                  </form>";
                }

                echo "</div>";
            }

            // Calculate %
            $percent = ($total > 0) ? ($completed / $total) * 100 : 0;

            echo "
    <div class='progress-bar'>
        <div class='progress-fill' id='progress'></div>
    </div>
    <p>$percent% Completed</p>
    ";

            echo "<script>
        gsap.to('#progress', {
            width: '$percent%',
            duration: 1.5
        });
    </script>";
            echo "</div>";
            echo "</div>";
        }


        ?>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            gsap.from(".goal-center", {
                y: 20,
                opacity: 0,
                duration: 1
            });

            gsap.from(".card", {
                y: 40,
                duration: 1,
                delay: 0.2,
                stagger: 0.15
            });

        });
    </script>

    <script src="../assets/js/theme.js"></script>

</body>

</html>