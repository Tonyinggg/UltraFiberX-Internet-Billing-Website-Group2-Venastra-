<?php
require_once 'auth_check.php';
requireAdminLogin();

$pdo = getDBConnection();
$admin = getAdminInfo();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoload
$autoload = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoload)) {
    die('Composer autoload.php not found. Run "composer install".');
}
require $autoload;

$success_message = '';
$error_message = '';

// Handle sending message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send_message') {
    $recipient_email = trim($_POST['recipient_email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (empty($recipient_email) || empty($subject) || empty($message)) {
        $error_message = 'Please fill in all fields.';
    } else {
        try {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->SMTPDebug = 0; // set to 2 for debugging
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'josheruu@gmail.com';          // Your Gmail
            $mail->Password = 'lpmauvdsgcnywzgm';           // Google app password (no spaces)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('josheruu@gmail.com', 'UltraFiberX Admin'); // Must match Username
            $mail->addAddress($recipient_email);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->isHTML(false);

            $mail->send();

            // Log message in database
            $stmt = $pdo->prepare("
                INSERT INTO admin_messages (admin_id, recipient_email, subject, message, sent_date)
                VALUES (?, ?, ?, ?, NOW())
            ");
            $stmt->execute([$admin['id'], $recipient_email, $subject, $message]);

            $success_message = 'Message sent successfully!';
        } catch (Exception $e) {
            $error_message = 'Mailer Exception: ' . $mail->ErrorInfo;
        } catch (PDOException $e) {
            $error_message = 'Database Error: ' . $e->getMessage();
        }
    }
}

// Get sent messages
try {
    $messages = $pdo->query("
        SELECT * FROM admin_messages 
        WHERE admin_id = " . (int)$admin['id'] . "
        ORDER BY sent_date DESC
        LIMIT 50
    ")->fetchAll();
} catch (PDOException $e) {
    $messages = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging - UltraFiberX Admin</title>
    <link rel="stylesheet" href="../styles.css">
    <?php include 'sidebar.php'; ?>
    <style>
        .main-content { margin-left: 280px; padding: 2rem; background: #f8f9fa; min-height: 100vh; }
        .page-header { background: white; padding: 2rem; border-radius: 10px; margin-bottom: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .page-header h1 { margin: 0; color: #264229; }
        .messaging-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .messaging-section { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem; font-family: inherit; box-sizing: border-box; }
        .form-group textarea { resize: vertical; min-height: 150px; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #264229; box-shadow: 0 0 0 3px rgba(38, 66, 41, 0.1); }
        .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; font-weight: 500; transition: all 0.3s ease; }
        .btn-primary { background: #264229; color: white; }
        .btn-primary:hover { background: #1a2e1c; transform: translateY(-2px); }
        .alert { padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .messages-table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .messages-table th, .messages-table td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
        .messages-table th { background: #f5f5f5; font-weight: 600; }
        .message-preview { max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        @media (max-width: 1024px) { .messaging-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="page-header">
            <h1>Informing the client</h1>
            <h3></h3>
        </div>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if ($error_message): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="messaging-grid">
            <div class="messaging-section">
                <h2>Send Message</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="send_message">
                    
                    <div class="form-group">
                        <label for="recipient_email">Recipient Email:</label>
                        <input type="email" id="recipient_email" name="recipient_email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>

            <div class="messaging-section">
                <h2>Recent Messages</h2>
                <?php if (!empty($messages)): ?>
                <table class="messages-table">
                    <thead>
                        <tr>
                            <th>To</th>
                            <th>Subject</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($msg['recipient_email']); ?></td>
                            <td class="message-preview" title="<?php echo htmlspecialchars($msg['subject']); ?>">
                                <?php echo htmlspecialchars($msg['subject']); ?>
                            </td>
                            <td><?php echo date('M j, Y H:i', strtotime($msg['sent_date'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p style="color: #6c757d;">No messages sent yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
