<?php
/**
 * Process Support/Contact Form
 * Handles form submission from support.html and contact.html with enhanced validation and security
 */

require_once 'config.php';

// Initialize variables
$success = false;
$error_messages = [];

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $full_name = sanitizeInput($_POST['fullName'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $subject = sanitizeInput($_POST['subject'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');
    $account_number = sanitizeInput($_POST['accountNumber'] ?? '');
    $priority = sanitizeInput($_POST['priority'] ?? 'medium');
    $inquiry_type = sanitizeInput($_POST['inquiryType'] ?? 'general'); // added inquiry type field
    $newsletter_consent = isset($_POST['newsletter']) ? 1 : 0;
    
    if (empty($full_name)) {
        $error_messages[] = "Full name is required.";
    }
    if (empty($email)) {
        $error_messages[] = "Email address is required.";
    } elseif (!isValidEmail($email)) {
        $error_messages[] = "Please enter a valid email address.";
    }
    if (!empty($phone) && !isValidPhilippineMobile($phone)) {
        $error_messages[] = "Please enter a valid Philippine mobile number (09XXXXXXXXX).";
    }
    if (empty($subject)) {
        $error_messages[] = "Subject is required.";
    }
    if (empty($message)) {
        $error_messages[] = "Message is required.";
    } elseif (strlen($message) < 10) {
        $error_messages[] = "Message must be at least 10 characters long.";
    }
    
    // Validate priority
    $valid_priorities = ['low', 'medium', 'high', 'urgent'];
    if (!in_array($priority, $valid_priorities)) {
        $priority = 'medium';
    }
    
    $valid_inquiry_types = ['general', 'technical', 'billing', 'business', 'complaint', 'feedback', 'other'];
    if (!in_array($inquiry_type, $valid_inquiry_types)) {
        $inquiry_type = 'general';
    }
    
    if (empty($error_messages)) {
        try {
            $pdo = getDBConnection();
            $sql = "INSERT INTO inquiries (name, email, subject, message, phone, account_number, priority, inquiry_type, newsletter_consent, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$full_name, $email, $subject, $message, $phone, $account_number, $priority, $inquiry_type, $newsletter_consent]);
            
            $success = true;
            $inquiry_id = $pdo->lastInsertId();
            
            header("Location: thank-you.php?type=support&id=" . $inquiry_id);
            exit;
            
        } catch (PDOException $e) {
            error_log("Database error during support request insertion: " . $e->getMessage());
            $error_messages[] = "Database error occurred. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Request Status - ConnectPH</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .status-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            text-align: center;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .error { color: #dc3545; }
        .status-icon { font-size: 48px; margin-bottom: 20px; }
        .error-list {
            text-align: left;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 1rem;
            margin: 1rem 0;
        }
        .error-list ul {
            margin: 0;
            padding-left: 1.5rem;
        }
        .error-list li {
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="status-container">
        <div class="status-icon">❌</div>
        <h1 class="error">Message Failed</h1>
        
        <?php if (!empty($error_messages)): ?>
            <div class="error-list">
                <strong>Please correct the following errors:</strong>
                <ul>
                    <?php foreach ($error_messages as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div style="margin-top: 30px;">
            <!-- updated links to point to support.html instead of inquiries.html -->
            <a href="support.html" class="btn btn-secondary">Try Again</a>
            <a href="index.html" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</body>
</html>
