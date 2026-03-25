<?php
session_start();
include("includes/db.php");

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {

            if ($user['status'] == 'blocked') {
                die("Your account has been blocked by admin.");
            }

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];

            header("Location: pages/dashboard.php");
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            height: 100vh;
            background: #0B0F19;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* CARD */
        .login-box {
            width: 350px;
            padding: 30px;
            border-radius: 15px;

            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);

            text-align: center;
        }

        /* TITLE */
        .login-box h2 {
            margin-bottom: 20px;
            font-size: 26px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            color: transparent;
        }

        /* INPUTS */
        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
            outline: none;

            background: #1F2937;
            color: white;
        }

        .login-box input:focus {
            border: 1px solid #3B82F6;
        }

        /* BUTTON */
        .login-box button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border: none;
            border-radius: 10px;

            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-box button:hover {
            transform: scale(1.05);
        }

        /* ERROR */
        .error {
            color: #F87171;
            margin-bottom: 10px;
        }

        /* LINK */
        .link {
            margin-top: 15px;
            color: #9CA3AF;
        }

        .link a {
            color: #3B82F6;
            text-decoration: none;
        }

        .back-btn {
            position: absolute;
            top: 25px;
            left: 25px;
            padding: 10px 18px;
            border-radius: 10px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
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
            width: 100%;
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
    <a href="index.php" class="back-btn">← Back</a>

    <div class="login-box">

        <h2>Welcome Back 👋</h2>

        <?php if (isset($error)) {
            echo "<p class='error'>$error</p>";
        } ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>

            <div class="password-box">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-pass" onclick="togglePassword()">👁️</span>
            </div>

            <button name="login">Login</button>
        </form>

        <p class="link">Don't have an account? <a href="register.php">Register</a></p>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script>
        gsap.from(".login-box h2", {
            y: -20,
            opacity: 0,
            duration: 1
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