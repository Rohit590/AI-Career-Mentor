<?php
include("../includes/auth.php");
include("../includes/db.php");

$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'"));

// Active roadmap
$active = mysqli_query($conn, "
SELECT g.name 
FROM user_goals ug
JOIN goals g ON ug.goal_id = g.id
WHERE ug.user_id='$user_id' AND ug.status='active'
");

// Completed roadmaps
$completed = mysqli_query($conn, "
SELECT g.name 
FROM user_goals ug
JOIN goals g ON ug.goal_id = g.id
WHERE ug.user_id='$user_id' AND ug.status='completed'
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        .container {
            width: 60%;
            margin: auto;
            margin-top: 100px;
        }

        .card {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 16px;
            backdrop-filter: blur(12px);
        }

        .profile-item {
            margin: 15px 0;
            font-size: 16px;
        }

        
    </style>
</head>

<body>

    <?php include("../includes/navbar.php"); ?>

    <div class="container">
        <div class="card">
            <h2>👤 Profile</h2>

            <div class="profile-item"><b>Name:</b> <?php echo $user['name']; ?></div>
            <div class="profile-item"><b>Email:</b> <?php echo $user['email']; ?></div>
            <div class="profile-item"><b>XP:</b> <?php echo $user['xp']; ?></div>

            <?php
            $level = floor($user['xp'] / 100) + 1;
            ?>
            <div class="profile-item"><b>Level:</b> <?php echo $level; ?></div>

            <hr style="margin:25px 0; opacity:.2">

            <h3>🟢 Active Roadmap</h3>

            <?php
            if (mysqli_num_rows($active) > 0) {
                while ($row = mysqli_fetch_assoc($active)) {
                    echo "<div class='profile-item'>🚀 " . $row['name'] . "</div>";
                }
            } else {
                echo "<div class='profile-item'>No active roadmap</div>";
            }
            ?>

            
        </div>
    </div>

    <script>
        gsap.from(".card", {
            y: 50,
            opacity: 0,
            duration: 1
        });
    </script>

</body>

</html>