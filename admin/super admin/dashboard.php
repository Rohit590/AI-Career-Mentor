<?php
include("auth.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Super Admin Dashboard</title>

    <link rel="stylesheet" href="../../assets/css/theme.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        body {
            margin: 0;
            background: #0B0F19;
            color: white;
            font-family: Inter, sans-serif;
        }

        /* glow */
        body::before {
            content: "";
            position: fixed;
            top: -200px;
            left: -200px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(245, 158, 11, .35), transparent);
            filter: blur(120px);
        }

        body::after {
            content: "";
            position: fixed;
            bottom: -200px;
            right: -200px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(239, 68, 68, .25), transparent);
            filter: blur(120px);
        }

        .container {
            width: 90%;
            margin: auto;
            margin-top: 60px;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h2 {
            background: linear-gradient(90deg, #F59E0B, #EF4444);
            -webkit-background-clip: text;
            color: transparent;
            font-size: 28px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: rgba(17, 24, 39, .7);
            padding: 30px;
            border-radius: 18px;
            backdrop-filter: blur(12px);
            transition: .3s;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(245, 158, 11, .25);
        }

        .card h3 {
            margin-top: 10px;
        }

        .icon {
            font-size: 28px;
            background: linear-gradient(90deg, #F59E0B, #EF4444);
            -webkit-background-clip: text;
            color: transparent;
        }

        .logout {
            background: rgba(239, 68, 68, .2);
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="header">
            <h2>🛡️ Super Admin Dashboard</h2>
            <p>Manage admins and system control</p>
        </div>

        <div class="grid">

            <a href="admin_requests.php" class="card">
                <div class="icon">📥</div>
                <h3>Admin Requests</h3>
                <p>Approve or reject admin registrations</p>
            </a>

            <a href="manage_admins.php" class="card">
                <div class="icon">👨‍💼</div>
                <h3>Manage Admins</h3>
                <p>View and control admin accounts</p>
            </a>

            <a href="logout.php" class="card logout">
                <div class="icon">🚪</div>
                <h3>Logout</h3>
                <p>Exit super admin panel</p>
            </a>

        </div>

    </div>

    <script>
        gsap.from(".header", {
            y: -40,
            duration: 1
        });

        gsap.from(".card", {
            y: 50,
            duration: 1,
            stagger: .2,
            delay: .3,
            ease: "power3.out"
        });
    </script>

</body>

</html>