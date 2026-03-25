<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

    <style>
        /* ================= NAVBAR ================= */
        .navbar {
            width: 100%;
            height: 70px;
            background: rgba(17, 24, 39, 0.6);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);

            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;

            display: flex;
            justify-content: center;
        }

        /* INNER */
        .navbar-inner {
            width: 100%;
            max-width: 1200px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 20px;
            box-sizing: border-box;
        }

        /* LOGO */
        .logo {
            font-size: 20px;
            font-weight: bold;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            color: transparent;
        }

        /* LINKS */
        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: #9CA3AF;
            text-decoration: none;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: white;
        }

        /* RIGHT */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* PROFILE */
        .profile {
            position: relative;
            cursor: pointer;
        }

        /* DROPDOWN */
        .dropdown {
            position: absolute;
            top: 40px;
            right: 0;
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 10px;
            display: none;
        }

        .dropdown a {
            display: block;
            padding: 8px;
            color: white;
            text-decoration: none;
        }

        .dropdown a:hover {
            background: #1F2937;
        }

        /* BUTTON */
        #themeToggle {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: white;
        }

        /* MOBILE */
        .menu-toggle {
            display: none;
            font-size: 22px;
            cursor: pointer;
        }

        @media (max-width: 768px) {

            .nav-links {
                position: absolute;
                top: 70px;
                left: 0;
                width: 100%;
                background: #111827;
                flex-direction: column;
                display: none;
                padding: 20px;
            }

            .nav-links a {
                margin: 10px 0;
            }

            .menu-toggle {
                display: block;
            }
        }

        /* BODY SPACING FIX */
        body {
            margin-top: 80px;
        }

        .nav-links a {
            color: #9CA3AF;
            text-decoration: none;
            transition: 0.3s;
            position: relative;
        }

        .nav-links a:hover {
            color: white;
        }

        /* ACTIVE LINK */
        .nav-links a.active {
            color: white;
        }

        .nav-links a.active::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -6px;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            border-radius: 2px;
        }
    </style>
    <script>
        // 🔥 APPLY SAVED THEME BEFORE PAGE LOAD
        (function() {
            const savedTheme = localStorage.getItem("theme");

            if (savedTheme === "light") {
                document.documentElement.classList.add("light-mode");
            } else {
                document.documentElement.classList.remove("light-mode");
            }
        })();
    </script>

</head>

<body>
    <div class="navbar">
        <div class="navbar-inner">

            <!-- LOGO -->
            <div class="logo">🚀 AI Career Mentor</div>

            <!-- LINKS -->
            <div class="nav-links" id="navLinks">
                <a href="dashboard.php" class="<?php if ($current_page == 'dashboard.php') echo 'active'; ?>">Dashboard</a>

                <a href="roadmap.php" class="<?php if ($current_page == 'roadmap.php') echo 'active'; ?>">Roadmaps</a>

                <a href="../pages/core_subjects.php" class="<?php if ($current_page == 'core_subjects.php') echo 'active'; ?>">Core Subjects</a>

                <a href="ai_chat.php" class="<?php if ($current_page == 'ai_chat.php') echo 'active'; ?>">Ask AI Mentor</a>
            </div>

            <!-- RIGHT -->
            <div class="nav-right">

                <!-- THEME -->
                <button id="themeToggle">🌙</button>

                <!-- PROFILE -->
                <div class="profile" onclick="toggleDropdown()">
                    👤 <?php echo $_SESSION['user_name'] ?? 'User'; ?>
                    <div class="dropdown" id="dropdownMenu">
                        <a href="../pages/profile.php">Profile</a>
                        <a href="../pages/settings.php">Settings</a>
                        <a href="../logout.php">Logout</a>
                    </div>
                </div>

                <!-- MOBILE -->
                <div class="menu-toggle" onclick="toggleMenu()">☰</div>

            </div>

        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const toggleBtn = document.getElementById("themeToggle");

            // Set correct icon on load
            if (localStorage.getItem("theme") === "light") {
                document.documentElement.classList.add("light-mode");
                toggleBtn.innerText = "☀️";
            } else {
                toggleBtn.innerText = "🌙";
            }

            // Toggle theme
            toggleBtn.addEventListener("click", () => {

                document.documentElement.classList.toggle("light-mode");

                if (document.documentElement.classList.contains("light-mode")) {
                    localStorage.setItem("theme", "light");
                    toggleBtn.innerText = "☀️";
                } else {
                    localStorage.setItem("theme", "dark");
                    toggleBtn.innerText = "🌙";
                }
            });

        });

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


</body>

</html>