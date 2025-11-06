<?php
// ----------------------------
// DATABASE CONFIGURATION
// ----------------------------
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'networkdb');

// ----------------------------
// APPLICATION SETTINGS
// ----------------------------
define('SITE_NAME', 'UltraFiberX Network');
define('ADMIN_EMAIL', 'admin@ultrafiberx.com');

// ----------------------------
// SESSION CONFIGURATION
// ----------------------------

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ----------------------------
// DATABASE CONNECTION
// ----------------------------
function getDBConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

// ----------------------------
// ENSURE ADMIN EXISTS
// ----------------------------
function ensureAdminExists() {
    try {
        $pdo = getDBConnection();

        // Check if admin user exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin_users WHERE username = 'admin'");
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            // Create default admin
            $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admin_users (username, password, email) VALUES ('admin', ?, 'admin@ultrafiberx.com')");
            $stmt->execute([$hashedPassword]);
        }
    } catch (PDOException $e) {
        // Fail silently if table doesn't exist yet
    }
}
ensureAdminExists();

// ----------------------------
// HELPER FUNCTIONS
// ----------------------------

// Sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Validate Philippine mobile number
function isValidPhilippineMobile($phone) {
    $phone = preg_replace('/[\s\-\+]/', '', $phone);
    return preg_match('/^(09|639)\d{9}$/', $phone);
}

// ----------------------------
// CUSTOMER FUNCTIONS
// ----------------------------
function getCustomerById($id) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error fetching customer: " . $e->getMessage());
        return false;
    }
}

function updateCustomerStatus($id, $status) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE customers SET status = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$status, $id]);
    } catch (PDOException $e) {
        error_log("Error updating customer status: " . $e->getMessage());
        return false;
    }
}

function deleteCustomer($id) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("DELETE FROM customers WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        error_log("Error deleting customer: " . $e->getMessage());
        return false;
    }
}

// ----------------------------
// INQUIRY FUNCTIONS
// ----------------------------
function getInquiryById($id) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM inquiries WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error fetching inquiry: " . $e->getMessage());
        return false;
    }
}

function updateInquiryStatus($id, $status) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE inquiries SET status = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$status, $id]);
    } catch (PDOException $e) {
        error_log("Error updating inquiry status: " . $e->getMessage());
        return false;
    }
}

function deleteInquiry($id) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("DELETE FROM inquiries WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        error_log("Error deleting inquiry: " . $e->getMessage());
        return false;
    }
}

// ----------------------------
// CUSTOMER STATS
// ----------------------------
function getCustomerStats() {
    try {
        $pdo = getDBConnection();
        $stats = [];

        // Total customers
        $stmt = $pdo->query("SELECT COUNT(*) FROM customers");
        $stats['total'] = $stmt->fetchColumn();

        // Active customers
        $stmt = $pdo->query("SELECT COUNT(*) FROM customers WHERE status = 'Active'");
        $stats['active'] = $stmt->fetchColumn();

        // Pending customers
        $stmt = $pdo->query("SELECT COUNT(*) FROM customers WHERE status = 'Pending'");
        $stats['pending'] = $stmt->fetchColumn();

        // Monthly revenue (assuming average plan cost)
        $activeCustomers = $stats['active'];
        $stats['monthly_revenue'] = $activeCustomers * 1500;

        return $stats;
    } catch (PDOException $e) {
        error_log("Error getting customer stats: " . $e->getMessage());
        return ['total' => 0, 'active' => 0, 'pending' => 0, 'monthly_revenue' => 0];
    }
}
?>
