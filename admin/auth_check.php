<?php
// ✅ Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Include config for DB and helper functions
require_once '../config.php';

/**
 * ✅ Redirects to login if admin is not logged in.
 */
function requireAdminLogin() {
    if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit;
    }
}

/**
 * ✅ Returns currently logged-in admin information.
 */
function getAdminInfo() {
    return [
        'id' => $_SESSION['admin_id'] ?? null,
        'username' => $_SESSION['admin_username'] ?? null,
        'email' => $_SESSION['admin_email'] ?? null
    ];
}

/**
 * ✅ Logs out the admin, clears session + cookie, and redirects to login.
 */
function adminLogout() {
    // Clear session data
    $_SESSION = [];

    // Remove session cookie for extra security
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

    // Start a new session to show logout message
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['logout_message'] = "You have been successfully logged out.";

    // Redirect to login page
    header('Location: login.php');
    exit;
}

/**
 * ✅ Optional: Check if admin is logged in (for UI purposes)
 */
function isAdminLoggedIn() {
    return !empty($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// ✅ Logout triggered via URL (e.g., auth_check.php?logout)
if (isset($_GET['logout'])) {
    adminLogout();
}
?>
