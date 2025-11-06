<?php
require_once 'config.php';

$type = $_GET['type'] ?? '';
$id = (int)($_GET['id'] ?? 0);

if (!in_array($type, ['customer', 'inquiry']) || $id <= 0) {
    header('Location: index.html');
    exit;
}

$data = null;
$title = '';
$message = '';
$icon = '';

try {
    $pdo = getDBConnection();
    
    if ($type === 'customer') {
        $stmt = $pdo->prepare("SELECT name, email, plan, date FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if ($data) {
            $title = 'Application Submitted Successfully!';
            $message = 'Thank you for choosing ConnectPH Network! Your application has been received and is being processed.';
            $icon = '✅';
        }
    } elseif ($type === 'inquiry') {
        $stmt = $pdo->prepare("SELECT name, email, subject, date FROM inquiries WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if ($data) {
            $title = 'Message Sent Successfully!';
            $message = 'Thank you for contacting ConnectPH Network! Your inquiry has been received.';
            $icon = '📧';
        }
    }
    
    if (!$data) {
        header('Location: index.html');
        exit;
    }
    
} catch (PDOException $e) {
    error_log("Thank you page error: " . $e->getMessage());
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $type === 'customer' ? 'Application' : 'Inquiry'; ?> Confirmation - ConnectPH Network</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .thank-you-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
        }
        .thank-you-card {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        .success-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            animation: bounce 1s ease-in-out;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        .thank-you-title {
            color: #1a237e;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .thank-you-message {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .confirmation-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: left;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #dee2e6;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .detail-value {
            color: #1a237e;
            font-weight: 500;
        }
        .reference-id {
            background: #1a237e;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            display: inline-block;
            margin: 1rem 0;
        }
        .next-steps {
            background: #e3f2fd;
            border-left: 4px solid #1a237e;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: left;
        }
        .next-steps h3 {
            color: #1a237e;
            margin-bottom: 1rem;
        }
        .next-steps ul {
            margin: 0;
            padding-left: 1.5rem;
        }
        .next-steps li {
            margin-bottom: 0.5rem;
            color: #495057;
        }
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        .btn {
            padding: 0.75rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: #1a237e;
            color: white;
        }
        .btn-primary:hover {
            background: #0d47a1;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: white;
            color: #1a237e;
            border: 2px solid #1a237e;
        }
        .btn-secondary:hover {
            background: #1a237e;
            color: white;
            transform: translateY(-2px);
        }
        @media (max-width: 768px) {
            .thank-you-card {
                padding: 2rem;
                margin: 1rem;
            }
            .thank-you-title {
                font-size: 1.5rem;
            }
            .action-buttons {
                flex-direction: column;
            }
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <div class="thank-you-card">
            <div class="success-icon"><?php echo $icon; ?></div>
            <h1 class="thank-you-title"><?php echo $title; ?></h1>
            <p class="thank-you-message"><?php echo $message; ?></p>
            
            <div class="reference-id">
                <?php echo $type === 'customer' ? 'Application' : 'Ticket'; ?> ID: #<?php echo str_pad($id, 6, '0', STR_PAD_LEFT); ?>
            </div>
            
            <div class="confirmation-details">
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($data['name']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($data['email']); ?></span>
                </div>
                <?php if ($type === 'customer'): ?>
                <div class="detail-row">
                    <span class="detail-label">Selected Plan:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($data['plan']); ?></span>
                </div>
                <?php else: ?>
                <div class="detail-row">
                    <span class="detail-label">Subject:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($data['subject']); ?></span>
                </div>
                <?php endif; ?>
                <div class="detail-row">
                    <span class="detail-label">Submitted:</span>
                    <span class="detail-value"><?php echo date('F j, Y \a\t g:i A', strtotime($data['date'])); ?></span>
                </div>
            </div>
            
            <div class="next-steps">
                <h3>What happens next?</h3>
                <?php if ($type === 'customer'): ?>
                <ul>
                    <li>Our team will review your application within 24 hours</li>
                    <li>We'll contact you to confirm installation details</li>
                    <li>A technician will be scheduled for your preferred date</li>
                    <li>You'll receive email updates on your application status</li>
                </ul>
                <?php else: ?>
                <ul>
                    <li>Our support team will review your inquiry</li>
                    <li>We'll respond within 24 hours during business days</li>
                    <li>You'll receive updates via email</li>
                    <li>For urgent matters, please call our hotline</li>
                </ul>
                <?php endif; ?>
            </div>
            
            <div class="action-buttons">
                <a href="index.html" class="btn btn-primary">Back to Home</a>
                <?php if ($type === 'customer'): ?>
                    <a href="plans.html" class="btn btn-secondary">View Plans</a>
                <?php else: ?>
                    <a href="support.html" class="btn btn-secondary">Support Center</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
        // Auto-redirect after 30 seconds (optional)
        setTimeout(() => {
            const redirect = confirm('Would you like to return to the homepage?');
            if (redirect) {
                window.location.href = 'index.html';
            }
        }, 30000);
        
        // Print functionality
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html>
