<?php
include("auth.php");
include("../includes/db.php");

$msgs = mysqli_query($conn, "
SELECT * FROM contact_messages
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Contact Messages</title>

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
            filter: blur(120px);
            z-index: -1;
        }

        body::after {
            content: "";
            position: fixed;
            bottom: -200px;
            right: -200px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59, 130, 246, .3), transparent);
            filter: blur(120px);
            z-index: -1;
        }

        .container {
            width: 90%;
            margin: auto;
            margin-top: 80px;
        }

        .card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            padding: 25px;
            border-radius: 18px;
            margin-top: 20px;
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(139, 92, 246, .2);
        }

        h2 {
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            -webkit-background-clip: text;
            color: transparent;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        th {
            color: #9CA3AF;
            font-weight: 500;
        }

        tr:hover {
            background: rgba(139, 92, 246, .05);
        }

        .badge {
            background: rgba(139, 92, 246, .2);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .message-box {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
    </style>
</head>

<body>
    <a href="../admin/dashboard.php" class="back-btn">← Back</a>

    <div class="container">

        <div class="card">
            <h2>📩 Contact Messages</h2>
            <p>Messages submitted from website contact form</p>
        </div>

        <div class="card">

            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($msgs)) { ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td class="message-box"><?php echo $row['message']; ?></td>
                        <td>
                            <span class="badge">
                                <?php echo $row['created_at']; ?>
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
    </script>

</body>

</html>