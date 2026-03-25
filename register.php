<?php
include("includes/db.php");

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (name, email, password)
                  VALUES ('$name', '$email', '$hashed')";

        if (mysqli_query($conn, $query)) {
            header("Location: login.php");
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>

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
        .register-box {
            width: 380px;
            padding: 30px;
            border-radius: 15px;

            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);

            text-align: center;
        }

        /* TITLE */
        .register-box h2 {
            margin-bottom: 20px;
            font-size: 26px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            color: transparent;
        }

        /* INPUTS */
        .register-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: none;
            outline: none;

            background: #1F2937;
            color: white;
        }

        .register-box input:focus {
            border: 1px solid #3B82F6;
        }

        /* BUTTON */
        .register-box button {
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

        .register-box button:hover {
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

    <div class="register-box">

        <h2>Create Account 🚀</h2>

        <?php if (isset($error)) {
            echo "<p class='error'>$error</p>";
        } ?>

        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>

            <div class="password-box">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-pass" onclick="togglePassword()">👁️</span>
            </div>

            <div class="password-box">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                <span class="toggle-pass" onclick="toggleConfirmPassword()">👁️</span>
            </div>

            <button name="register">Register</button>
        </form>

        <p class="link">Already have an account? <a href="login.php">Login</a></p>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script>
        gsap.from(".register-box", {
            y: 30,
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

    <script>
        function toggleConfirmPassword() {
            const pass = document.getElementById("confirm_password");

            if (pass.type === "password") {
                pass.type = "text";
            } else {
                pass.type = "password";
            }
        }
    </script>
</body>

</html>