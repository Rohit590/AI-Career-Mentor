<?php
include("auth.php");
include("../includes/db.php");

// DELETE USER
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
}

// BLOCK USER
if (isset($_GET['block'])) {
    $id = $_GET['block'];
    mysqli_query($conn, "UPDATE users SET status='blocked' WHERE id='$id'");
}

// UNBLOCK USER
if (isset($_GET['unblock'])) {
    $id = $_GET['unblock'];
    mysqli_query($conn, "UPDATE users SET status='active' WHERE id='$id'");
}

$users = mysqli_query($conn, "SELECT * FROM users WHERE role='student'");
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Management</title>

    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        body {
            margin: 0;
            background: var(--bg-color);
            color: var(--text-color);
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

        .container {
            width: 90%;
            margin: auto;
            margin-top: 70px;
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
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        th {
            color: #9CA3AF;
        }

        .badge-active {
            background: rgba(16, 185, 129, .2);
            color: #10B981;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-blocked {
            background: rgba(239, 68, 68, .2);
            color: #EF4444;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            margin-right: 5px;
            display: inline-block;
        }

        .delete {
            background: #EF4444;
            color: white;
        }

        .block {
            background: #F59E0B;
            color: white;
        }

        .unblock {
            background: #10B981;
            color: white;
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
            <h2>👥 User Management</h2>
            <p>Block, unblock or delete student accounts</p>
        </div>

        <div class="card">

            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($users)) { ?>

                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>

                        <td>
                            <?php if ($row['status'] == 'active') { ?>
                                <span class="badge-active">Active</span>
                            <?php } else { ?>
                                <span class="badge-blocked">Blocked</span>
                            <?php } ?>
                        </td>

                        <td>

                            <a class="btn delete" href="?delete=<?php echo $row['id']; ?>">
                                Delete
                            </a>

                            <?php if ($row['status'] == 'active') { ?>
                                <a class="btn block" href="?block=<?php echo $row['id']; ?>">
                                    Block
                                </a>
                            <?php } else { ?>
                                <a class="btn unblock" href="?unblock=<?php echo $row['id']; ?>">
                                    Unblock
                                </a>
                            <?php } ?>

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