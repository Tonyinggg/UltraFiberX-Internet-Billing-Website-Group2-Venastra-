<?php
/**
 * Process Customer Signup Form
 * Handles form submission from customer-form.html with enhanced validation and security
 */

require_once 'config.php';

// Initialize variables
$success = false;
$error_messages = [];

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $first_name = sanitizeInput($_POST['firstName'] ?? '');
    $last_name = sanitizeInput($_POST['lastName'] ?? '');
    $middle_name = sanitizeInput($_POST['middleName'] ?? '');
    $full_name = trim($first_name . ' ' . $last_name);
    
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $birth_date = sanitizeInput($_POST['birthDate'] ?? '');
    $gender = sanitizeInput($_POST['gender'] ?? '');
    $alternate_phone = sanitizeInput($_POST['alternatePhone'] ?? '');
    
    // Address information
    $street_address = sanitizeInput($_POST['streetAddress'] ?? '');
    $barangay = sanitizeInput($_POST['barangay'] ?? '');
    $city = sanitizeInput($_POST['city'] ?? '');
    $province = sanitizeInput($_POST['province'] ?? '');
    $zip_code = sanitizeInput($_POST['zipCode'] ?? '');
    $landmarks = sanitizeInput($_POST['landmarks'] ?? '');
    
    // Plan and installation details
    $preferred_plan = sanitizeInput($_POST['preferredPlan'] ?? '');
    $install_date = sanitizeInput($_POST['installDate'] ?? '');
    $install_time = sanitizeInput($_POST['installTime'] ?? '');
    $payment_method = sanitizeInput($_POST['paymentMethod'] ?? '');
    
    // Additional information
    $referral_source = sanitizeInput($_POST['referralSource'] ?? '');
    $special_requests = sanitizeInput($_POST['specialRequests'] ?? '');
    $marketing_consent = isset($_POST['marketing']) ? 1 : 0;
    
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
    if (empty($phone)) {
        $error_messages[] = "Phone number is required.";
    } elseif (!isValidPhilippineMobile($phone)) {
        $error_messages[] = "Please enter a valid Philippine mobile number (09XXXXXXXXX).";
    }
    if (empty($preferred_plan)) {
        $error_messages[] = "Please select a preferred plan.";
    }
    if (empty($street_address)) {
        $error_messages[] = "Street address is required.";
    }
    if (empty($city)) {
        $error_messages[] = "City is required.";
    }
    if (empty($province)) {
        $error_messages[] = "Province is required.";
    }
    
    // Check for duplicate email
    if (empty($error_messages)) {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT id FROM customers WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error_messages[] = "An account with this email address already exists.";
            }
        } catch (PDOException $e) {
            error_log("Database error during duplicate check: " . $e->getMessage());
            $error_messages[] = "Database error occurred. Please try again.";
        }
    }
    
    if (empty($error_messages)) {
        try {
            $pdo = getDBConnection();
            $sql = "INSERT INTO customers (
                name, email, phone, plan, message, first_name, last_name, middle_name, 
                birth_date, gender, alternate_phone, street_address, barangay, city, 
                province, zip_code, landmarks, install_date, install_time, payment_method, 
                referral_source, special_requests, marketing_consent, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $full_name, $email, $phone, $preferred_plan, $special_requests,
                $first_name, $last_name, $middle_name, $birth_date, $gender,
                $alternate_phone, $street_address, $barangay, $city, $province,
                $zip_code, $landmarks, $install_date, $install_time, $payment_method,
                $referral_source, $special_requests, $marketing_consent
            ]);
            
            $success = true;
            $customer_id = $pdo->lastInsertId();
            
            header("Location: thank-you.php?type=customer&id=" . $customer_id);
            exit;
            
        } catch (PDOException $e) {
            error_log("Database error during customer insertion: " . $e->getMessage());
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
    <title>Application Status - ConnectPH</title>
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
        <h1 class="error">Application Failed</h1>
        
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
            <a href="customer-form.html" class="btn btn-secondary">Try Again</a>
            <a href="index.html" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</body>
</html>
