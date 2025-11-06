<?php
/**
 * Process Contact Form
 * Handles form submission from contact.html with enhanced validation and security
 */

require_once 'config.php';

// Initialize variables
$success = false;
$error_messages = [];

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $first_name = sanitizeInput($_POST['firstName'] ?? '');
    $last_name = sanitizeInput($_POST['lastName'] ?? '');
    $full_name = trim($first_name . ' ' . $last_name);
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $company = sanitizeInput($_POST['company'] ?? '');
    $subject = sanitizeInput($_POST['subject'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');
    $inquiry_type = sanitizeInput($_POST['inquiryType'] ?? 'general');
    $newsletter_consent = isset($_POST['newsletter']) ? 1 : 0;
    
    // Validation
    if (empty($first_name)) {
        $error_messages[] = "First name is required.";
    }
    if (empty($last_name)) {
        $error_messages[] = "Last name is required.";
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
    
    // Validate inquiry type
    $valid_inquiry_types = ['general', 'technical', 'billing', 'business', 'complaint', 'feedback', 'other'];
    if (!in_array($inquiry_type, $valid_inquiry_types)) {
        $inquiry_type = 'general';
    }
    
    if (empty($error_messages)) {
        try {
            $pdo = getDBConnection();
            $sql = "INSERT INTO inquiries (name, email, subject, message, phone, account_number, priority, inquiry_type, newsletter_consent, status) 
                    VALUES (?, ?, ?, ?, ?, ?, 'medium', ?, ?, 'Pending')";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$full_name, $email, $subject, $message, $phone, $company, $inquiry_type, $newsletter_consent]);
            
            $success = true;
            $inquiry_id = $pdo->lastInsertId();
            
            header("Location: thank-you.php?type=inquiry&id=" . $inquiry_id);
            exit;
            
        } catch (PDOException $e) {
            error_log("Database error during contact form submission: " . $e->getMessage());
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
    <title>Contact Form Status - UltraFiberX</title>
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
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            margin: 0.5rem;
        }
        .btn-primary {
            background: #4caf50;
            color: white;
        }
        .btn-primary:hover {
            background: #45a049;
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: transparent;
            color: #4caf50;
            border: 2px solid #4caf50;
        }
        .btn-secondary:hover {
            background: #4caf50;
            color: white;
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
            <a href="contact.html" class="btn btn-secondary">Try Again</a>
            <a href="index.html" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</body>
</html>
