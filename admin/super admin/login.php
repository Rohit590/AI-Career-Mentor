<?php
session_start();
include("../../includes/db.php");

if (isset($_POST['login'])) {

    $email = $_POST['email'];

    $user = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT * FROM users 
    WHERE email='$email' 
    AND role='super_admin'
    "));

    if ($user && password_verify($_POST['password'], $user['password'])) {

        $_SESSION['super_admin_id'] = $user['id'];
        $_SESSION['super_admin_name'] = $user['name'];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Super Admin Login</title>

    <link rel="stylesheet" href="../../assets/css/theme.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #0B0F19;
            color: white;
            font-family: Inter, sans-serif;
        }

        /* glow background */
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

        .card {
            width: 420px;
            padding: 35px;
            border-radius: 18px;
            background: rgba(17, 24, 39, .7);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, .08);
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(245, 158, 11, .25);
        }

        .title {
            text-align: center;
            margin-bottom: 25px;
        }

        .title h2 {
            margin: 0;
            background: linear-gradient(90deg, #F59E0B, #EF4444);
            -webkit-background-clip: text;
            color: transparent;
        }

        input {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border-radius: 10px;
            border: none;
            outline: none;
            background: #1F2937;
            color: white;
        }

        button {
            width: 100%;
            padding: 14px;
            margin-top: 10px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(90deg, #F59E0B, #EF4444);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        button:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 25px rgba(245, 158, 11, .4);
        }

        .error {
            color: #F87171;
            margin-bottom: 10px;
            text-align: center;
        }

        .badge {
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            padding: 8px 18px;
            border-radius: 30px;
            background: linear-gradient(90deg, #F59E0B, #EF4444);
            font-size: 13px;
            font-weight: 500;
        }

        .back-btn {
            position: absolute;
            top: 25px;
            left: 25px;
            padding: 10px 18px;
            border-radius: 10px;
            background: linear-gradient(90deg, #F59E0B, #EF4444);
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: .3s;
        }

        .back-btn:hover {
            transform: translateX(-3px);
            box-shadow: 0 10px 25px rgba(245, 158, 11, .35);
        }

        .password-box {
            position: relative;
        }

        .password-box input {
            width: 92%;
            padding-right: 45px;
        }

        .toggle-pass {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 16px;
            color: #9CA3AF;
        }

        .toggle-pass:hover {
            color: white;
        }
    </style>
</head>

<body>
    <a href="../login.php" class="back-btn">← Back</a>

    <div class="badge">SUPER ADMIN PANEL</div>

    <div class="card">

        <div class="title">
            <h2>Super Admin Login</h2>
            <p>Manage admins & approvals</p>
        </div>

        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Super Admin Email" required>

            <div class="password-box">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-pass" onclick="togglePassword()">👁️</span>
            </div>

            <button name="login">Login</button>
        </form>

    </div>

    <script>
        gsap.from(".badge", {
            y: -30,
            duration: 1
        });

        gsap.from(".card", {
            scale: .9,
            duration: 1,
            delay: .2
        });

        gsap.from(".title", {
            y: 30,
            duration: 1,
            delay: .4
        });

        gsap.from("input", {
            y: 20,
            duration: .8,
            stagger: .1,
            delay: .6
        });

        gsap.from("button", {
            scale: .8,
            duration: .6,
            delay: 1
        });
    </script>

    <script>
        function togglePassword() {
            const pass = document.getElementById("password");

            if (pass.type === "password") {
                pass.type = "text";
            } else {
                pass.type = "password";
            }
        }
    </script>

</body>

</html>