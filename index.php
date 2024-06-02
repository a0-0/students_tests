<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: php/main.php');
    exit();
} else {
    header('Location: php/login.php');
    exit();
}
?>
