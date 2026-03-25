<?php
include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    mysqli_query($conn, "
    INSERT INTO contact_messages (name,email,phone,message)
    VALUES ('$name','$email','$phone','$message')
    ");

    header("Location:index.php?sent=1");
    exit;
}
