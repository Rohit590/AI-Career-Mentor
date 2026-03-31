<?php
include("../includes/db.php");

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


    if (!preg_match("/^[A-Za-z\s]/", $name)) {
        $error = "Name should contain only letters";
    }
    // check existing
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {
        $error = "Email already exists";
    } else {

        mysqli_query($conn, "
INSERT INTO users (name,email,password,role,admin_status,status)
VALUES ('$name','$email','$password','admin','pending','active')
");

        $success = "Request sent to Super Admin for approval";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Registration</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: var(--bg-color);
        }

        /* background glow */
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

        .card {
            width: 400px;
            padding: 30px;
            background: var(--card-bg);
            border-radius: 16px;
            backdrop-filter: blur(12px);
            transition: .3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 92, 246, .2);
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background: var(--input-bg);
            border: none;
            border-radius: 8px;
            color: var(--text-color);
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            border: none;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            transition: .3s;
        }

        button:hover {
            transform: scale(1.03);
        }

        .link {
            margin-top: 15px;
            text-align: center;
            color: #9CA3AF;
        }

        .link a {
            color: #3B82F6;
            text-decoration: none;
            font-weight: 500;
        }

        .super-admin-btn {
            position: absolute;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
        }

        .super-admin-btn a {
            padding: 10px 20px;
            border-radius: 8px;
            background: linear-gradient(90deg, #F59E0B, #EF4444);
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .error {
            color: #f87171;
            margin-bottom: 10px;
        }

        .success {
            color: #34d399;
            margin-bottom: 10px;
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
            width: 90%;
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
    <a href="../index.php" class="back-btn">← Back</a>
    <div class="super-admin-btn">
        <a href="super admin/login.php">Super Admin Login</a>
    </div>

    <div class="card">

        <h2>Admin Registration</h2>

        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <?php if (isset($success)) echo "<div class='success'>$success</div>"; ?>

        <form method="POST">
            <input
                type="text"
                name="name"
                placeholder="Full Name"
                pattern="[A-Za-z\s]+"
                title="Only letters allowed"
                required>
            <input type="email" name="email" placeholder="Email" required>

            <div class="password-box">
                <input type="password" name="password" id="password" placeholder="Password" minlength="6" required>
                <span class="toggle-pass" onclick="togglePassword()">👁️</span>
            </div>

            <button name="register">Request Admin Access</button>
        </form>

        <div class="link">
            Already have an account? <a href="login.php">Login</a>
        </div>

    </div>

    <script>
        document.querySelector("form").addEventListener("submit", function(e) {

            const name = document.querySelector("input[name='name']").value;
            const password = document.getElementById("password").value;

            // Name validation
            const nameRegex = /^[A-Za-z\s]/;
            if (!nameRegex.test(name)) {
                alert("Full name must contain only letters");
                e.preventDefault();
                return;
            }

            // Password length
            if (password.length < 6) {
                alert("Password must be at least 6 characters");
                e.preventDefault();
                return;
            }

        });
    </script>
    <script>
        gsap.from(".super-admin-btn", {
            y: -30,
            duration: 1
        });

        gsap.from(".card", {
            y: 60,
            duration: 1,
            delay: .2
        });

        gsap.from(".card h2", {
            y: 20,
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