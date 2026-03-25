<?php
include("auth.php");
include("../includes/db.php");

$users = mysqli_query($conn, "
SELECT * FROM users 
WHERE role='student'
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        body {
            background: var(--bg-color);
            color: var(--text-color);
            font-family: Inter, sans-serif;
            margin: 0;
        }

        /* glow background */
        body::before {
            content: "";
            position: fixed;
            top: -200px;
            left: -200px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(139, 92, 246, .3), transparent);
            filter: blur(100px);
        }

        body::after {
            content: "";
            position: fixed;
            bottom: -200px;
            right: -200px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59, 130, 246, .3), transparent);
            filter: blur(100px);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .nav-actions a {
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            color: white;
            font-size: 14px;
            margin-left: 10px;
            transition: .3s;
        }

        .nav-actions a:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(139, 92, 246, .3);
        }

        .container {
            width: 90%;
            margin: auto;
            margin-top: 80px;
        }

        .card {
            background: var(--card-bg);
            padding: 25px;
            border-radius: 16px;
            backdrop-filter: blur(12px);
            margin-top: 20px;
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 92, 246, .2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        th {
            color: #9CA3AF;
        }

        .badge {
            background: rgba(139, 92, 246, .2);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="navbar">
            <h2>Admin Panel</h2>

            <div class="nav-actions">
                <a href="users.php">👥 Manage Users</a>
                <a href="contact_messages.php">💬View Contact Messages</a>
                <a href="logout.php">🚪 Logout</a>
            </div>
        </div>

        <div class="card">
            <h2>👨‍💼 Admin Dashboard</h2>
            <p>Manage and track student progress</p>
        </div>

        <div class="card">
            <h3>Students Overview</h3>

            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>XP</th>
                    <th>Active Goal</th>
                </tr>

                <?php
                while ($row = mysqli_fetch_assoc($users)) {

                    $goal = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT g.name 
FROM user_goals ug
JOIN goals g ON g.id=ug.goal_id
WHERE ug.user_id='{$row['id']}' 
AND ug.status='active'
"));

                ?>

                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['xp']; ?></td>
                        <td>
                            <span class="badge">
                                <?php echo $goal['name'] ?? 'None'; ?>
                            </span>
                        </td>
                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>

    <script>
        gsap.from(".card", {
            y: 40,
            duration: 1,
            stagger: .2,
            ease: "power3.out"
        });

        gsap.from(".navbar", {
            y: -30,
            duration: 1
        });

        gsap.from(".card", {
            y: 40,
            duration: 1,
            stagger: .2,
            delay: .2,
            ease: "power3.out"
        });
    </script>

</body>

</html>