<?php
$conn = mysqli_connect("localhost", "root", "", "ai_platform",3307);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>