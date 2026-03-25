<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['admin_status'] != 'approved') {
    die("Waiting for super admin approval");
}
