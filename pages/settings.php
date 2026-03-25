<?php
include("../includes/auth.php");
include("../includes/db.php");

$user_id = $_SESSION['user_id'];

if (isset($_POST['update'])) {
    $name = $_POST['name'];

    mysqli_query($conn, "UPDATE users SET name='$name' WHERE id='$user_id'");
    $_SESSION['user_name'] = $name;
}
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'"));
?>

<!DOCTYPE html>
<html>

<head>
    <title>Settings</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        .container {
            width: 60%;
            margin: auto;
            margin-top: 100px;
        }

        .card {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 16px;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: var(--input-bg);
            color: var(--text-color);
            margin-top: 10px;
        }

        button {
            margin-top: 15px;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            color: white;
        }
    </style>
</head>

<body>

    <?php include("../includes/navbar.php"); ?>

    <div class="container">
        <div class="card">
            <h2>⚙️ Settings</h2>

            <form method="POST">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

                <button name="update">Update Profile</button>
            </form>
        </div>
    </div>

    <script>
        gsap.from(".card", {
            y: 50,
            opacity: 0,
            duration: 1
        });
    </script>

</body>

</html>