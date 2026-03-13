<?php
// File: admin/logout.php

// 1. Start the session (essential to access session variables)
session_start();

// 2. Unset all of the session variables
$_SESSION = array();

// 3. Destroy the session cookie
// Note: This effectively deletes the session file on the server.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Finally, destroy the session
session_destroy();

// 5. Redirect the user to the login page
// Assuming login.php is in the same directory (admin/)
header("Location: login.php");
exit;
?>