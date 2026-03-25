<?php
session_start();

if (!isset($_SESSION['super_admin_id'])) {
    header("Location: login.php");
    exit;
}
