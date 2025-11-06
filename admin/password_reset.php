<?php
session_start();
require_once '../db_connect.php'; // Adjust path if needed
require_once __DIR__ . '/../vendor/autoload.php'; // PHPMailer via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

$message = '';
$error = '';
$step = $_GET['step'] ?? 'request';
$token = $_GET['token'] ?? '';

// Handle password reset request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 'request') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = 'Please enter your email address.';
    } else {
        $stmt = $conn->prepare("SELECT id FROM admin_users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Always show same message to avoid revealing if email exists
        $message = 'If the email exists, a reset link has been sent.';

        if ($result->num_rows > 0) {
            $reset_token = bin2hex(random_bytes(32));
            $token_hash = hash('sha256', $reset_token);
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $update_stmt = $conn->prepare("UPDATE admin_users SET reset_token = ?, reset_token_expires = ? WHERE email = ?");
            $update_stmt->bind_param("sss", $token_hash, $expires, $email);
            $update_stmt->execute();

            // Send email via PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'josheruu@gmail.com';      // Your Gmail
                $mail->Password   = 'lpmauvdsgcnywzgm';        // App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('josheruu@gmail.com', 'Admin Reset');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';

                $reset_link = "http://" . $_SERVER['HTTP_HOST'] . "/ITPROJECTMANAGEMENT/admin/password_reset.php?step=reset&token=" . $reset_token;
                $mail->Body = "
                    <div style='font-family:Arial,sans-serif;'>
                        <h2>Password Reset Request</h2>
                        <p>Click the button below to reset your password. The link expires in 1 hour.</p>
                        <a href='$reset_link' 
                           style='display:inline-block;background:#5563DE;color:white;
                           padding:10px 20px;text-decoration:none;border-radius:5px;'>
                           Reset Password
                        </a>
                        <p style='margin-top:15px;'>If you didn’t request this, you can ignore this email.</p>
                    </div>
                ";

                $mail->send();
            } catch (Exception $e) {
                $error = "Mailer Error: " . $mail->ErrorInfo;
            }
        }
    }
}

// Handle new password submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $step === 'reset') {
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $token = $_POST['token'] ?? '';

    if (empty($new_password) || empty($confirm_password)) {
        $error = 'Please fill in all fields.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($new_password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif (empty($token) || strlen($token) !== 64) {
        $error = 'Invalid reset token.';
    } else {
        $token_hash = hash('sha256', $token);
        $stmt = $conn->prepare("SELECT id FROM admin_users WHERE reset_token = ? AND reset_token_expires > NOW()");
        $stmt->bind_param("s", $token_hash);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $admin_id = $row['id'];
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            $update_stmt = $conn->prepare("UPDATE admin_users SET password = ?, reset_token = NULL, reset_token_expires = NULL WHERE id = ?");
            $update_stmt->bind_param("si", $hashed_password, $admin_id);
            $update_stmt->execute();

            $message = 'Password reset successfully.';
            $step = 'success';
        } else {
            $error = 'Invalid or expired token.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Password Reset - Admin</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
body { 
    font-family: 'Poppins', sans-serif; 
    display:flex; justify-content:center; align-items:center; 
    min-height:100vh; 
    background:linear-gradient(135deg,#264229,#2ecc71); 
    margin:0; color:#333;
}
.container { 
    background:white; padding:30px; border-radius:12px; 
    max-width:400px; width:100%; box-shadow:0 8px 25px rgba(0,0,0,0.15);
}
h1 { margin-bottom:15px; font-size:22px; text-align:center; color:#2e2e2e; }
.message { padding:10px; margin-bottom:15px; border-radius:5px; font-size:14px; text-align:center; }
.message.success { background:#d1fae5; color:#065f46; }
.message.error { background:#fee2e2; color:#991b1b; }
input { width:100%; padding:10px; margin-bottom:15px; border:1px solid #ccc; border-radius:5px; }
button { 
    width:100%; padding:10px; 
    background:#2ecc71; color:white; border:none; 
    border-radius:5px; cursor:pointer; font-weight:600; 
    transition:0.3s;
}
button:hover { background:#27ae60; }
.back-link { text-align:center; margin-top:15px; }
.back-link a { color:#27ae60; text-decoration:none; font-weight:500; }
.back-link a:hover { text-decoration:underline; }
</style>
</head>
<body>
<div class="container">
<?php if($step === 'request'): ?>
    <h1>Reset Password</h1>
    <?php if($message): ?><div class="message success"><?=htmlspecialchars($message)?></div><?php endif; ?>
    <?php if($error): ?><div class="message error"><?=htmlspecialchars($error)?></div><?php endif; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email address" required>
        <button type="submit">Send Reset Link</button>
    </form>

<?php elseif($step === 'reset'): ?>
    <h1>Set New Password</h1>
    <?php if($error): ?><div class="message error"><?=htmlspecialchars($error)?></div><?php endif; ?>
    <form method="POST">
        <input type="hidden" name="token" value="<?=htmlspecialchars($token)?>">
        <input type="password" name="new_password" placeholder="New password" required>
        <input type="password" name="confirm_password" placeholder="Confirm password" required>
        <button type="submit">Reset Password</button>
    </form>

<?php elseif($step === 'success'): ?>
    <h1>Password Reset Successful</h1>
    <div class="message success"><?=htmlspecialchars($message)?></div>
    <div class="back-link"><a href="login.php">Go to Login</a></div>
<?php endif; ?>

<div class="back-link"><a href="login.php">Back to Login</a></div>
</div>
</body>
</html>
