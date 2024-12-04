<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete the username cookie if it exists
if (isset($_COOKIE['username'])) {
    setcookie('username', '', time() - 3600, '/');
}

// Redirect to login page
header("Location: index.php");
exit;
?>