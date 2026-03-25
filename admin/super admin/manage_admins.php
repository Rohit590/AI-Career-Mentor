<?php
include("auth.php");
include("../../includes/db.php");

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    mysqli_query($conn, "
    DELETE FROM users 
    WHERE id='$id' 
    AND role='admin'
    ");
}

$admins = mysqli_query($conn, "
SELECT * FROM users 
WHERE role='admin' 
AND admin_status='approved'
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Admins</title>

    <link rel="stylesheet" href="../../assets/css/theme.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        body {
            margin: 0;
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

        .container {
            width: 85%;
            margin: auto;
            margin-top: 60px;
        }

        .header h2 {
            background: linear-gradient(90deg, #F59E0B, #EF4444);
            -webkit-background-clip: text;
            color: transparent;
        }

        .card {
            background: rgba(17, 24, 39, .7);
            padding: 25px;
            border-radius: 16px;
            margin-top: 20px;
            backdrop-filter: blur(12px);
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(245, 158, 11, .25);
        }

        .admin {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, .05);
        }

        .admin:last-child {
            border-bottom: none;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            background: linear-gradient(90deg, #EF4444, #DC2626);
            color: white;
            font-size: 14px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #9CA3AF;
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
    </style>
</head>

<body>
    <a href="../super admin/dashboard.php" class="back-btn">← Back</a>
    <div class="container">

        <div class="header">
            <h2>👨‍💼 Manage Admins</h2>
            <p>Remove or manage approved admins</p>
        </div>

        <div class="card">

            <?php if (mysqli_num_rows($admins) == 0) { ?>

                <div class="empty">
                    No admins available
                </div>

            <?php } ?>

            <?php while ($row = mysqli_fetch_assoc($admins)) { ?>

                <div class="admin">

                    <div>
                        <b><?php echo $row['name']; ?></b><br>
                        <span style="color:#9CA3AF;"><?php echo $row['email']; ?></span>
                    </div>

                    <a class="btn" href="?delete=<?php echo $row['id']; ?>">
                        Remove
                    </a>

                </div>

            <?php } ?>

        </div>

    </div>

    <script>
        gsap.from(".header", {
            y: 0,
            duration: 1
        });

        gsap.from(".card", {
            y: 40,
            duration: 1,
            delay: .2
        });

        gsap.from(".admin", {
            y: 20,
            duration: .6,
            stagger: .1,
            delay: .4
        });
    </script>

</body>

</html>