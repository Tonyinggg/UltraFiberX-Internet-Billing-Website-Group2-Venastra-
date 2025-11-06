<?php
require_once 'auth_check.php';
requireAdminLogin();

$pdo = getDBConnection();

// Handle billing actions
if ($_POST && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    try {
        if ($action === 'generate_invoice') {
            $customer_id = (int)$_POST['customer_id'];
            $amount = (float)$_POST['amount'];
            
            $stmt = $pdo->prepare("
                INSERT INTO invoices (customer_id, amount, due_date, status, created_date) 
                VALUES (?, ?, DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'Pending', NOW())
            ");
            $stmt->execute([$customer_id, $amount]);
            $success_message = "Invoice generated successfully.";
        } elseif ($action === 'mark_paid') {
            $invoice_id = (int)$_POST['invoice_id'];
            $stmt = $pdo->prepare("UPDATE invoices SET status = 'Paid', paid_date = NOW() WHERE id = ?");
            $stmt->execute([$invoice_id]);
            $success_message = "Invoice marked as paid.";
        }
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

// Get billing data
try {
    $billing_data = $pdo->query("
        SELECT c.id, c.name, c.email, c.plan,
               CASE c.plan
                   WHEN 'Plan1000' THEN 1000
                   WHEN 'Plan1200' THEN 1200
                   WHEN 'Plan1500' THEN 1500
                   WHEN 'Plan1800' THEN 1800
                   WHEN 'Plan2200' THEN 2200
                   ELSE 1000
               END as monthly_fee,
               c.status,
               COALESCE(i.total_outstanding, 0) as outstanding_balance
        FROM customers c
        LEFT JOIN (
            SELECT customer_id, SUM(amount) as total_outstanding
            FROM invoices 
            WHERE status = 'Pending'
            GROUP BY customer_id
        ) i ON c.id = i.customer_id
        WHERE c.status IN ('Active', 'Suspended')
        ORDER BY c.name
    ")->fetchAll();
    
    // Get recent invoices
    $recent_invoices = $pdo->query("
        SELECT i.*, c.name as customer_name, c.email
        FROM invoices i
        JOIN customers c ON i.customer_id = c.id
        ORDER BY i.created_date DESC
        LIMIT 20
    ")->fetchAll();
    
} catch (PDOException $e) {
    $billing_data = [];
    $recent_invoices = [];
    $error_message = "Error loading billing data.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Management - UltraFiberX Admin</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .page-header h1 {
            margin: 0;
            color: #264229;
        }
        
        .page-header p {
            margin: 0.5rem 0 0 0;
            color: #6c757d;
        }
        
        .billing-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .billing-section {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        
        .billing-section h3 {
            margin-top: 0;
            color: #264229;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .data-table th,
        .data-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .data-table th {
            background: #f5f5f5;
            font-weight: 600;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary { background: #264229; color: white; }
        .btn-primary:hover { background: #1a2e1c; }
        
        .btn-success { background: #28a745; color: white; }
        .btn-success:hover { background: #218838; }
        
        .amount { font-weight: 600; color: #264229; }
        .outstanding { color: #dc3545; font-weight: 600; }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-pending { background: #fff3cd; color: #856404; }
        .status-paid { background: #d4edda; color: #155724; }
        
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        
        @media (max-width: 1024px) {
            .billing-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>Billing Management</h1>
            <p>Manage customer billing and invoices</p>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="billing-grid">
            <div class="billing-section">
                <h3>Customer Billing</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Plan</th>
                            <th>Monthly Fee</th>
                            <th>Outstanding</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($billing_data as $customer): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($customer['name']); ?></strong><br>
                                <small><?php echo htmlspecialchars($customer['email']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($customer['plan']); ?></td>
                            <td class="amount">₱<?php echo number_format($customer['monthly_fee']); ?></td>
                            <td class="<?php echo $customer['outstanding_balance'] > 0 ? 'outstanding' : ''; ?>">
                                ₱<?php echo number_format($customer['outstanding_balance']); ?>
                            </td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="generate_invoice">
                                    <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
                                    <input type="hidden" name="amount" value="<?php echo $customer['monthly_fee']; ?>">
                                    <button type="submit" class="btn btn-primary">Generate Invoice</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="billing-section">
                <h3>Recent Invoices</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_invoices as $invoice): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($invoice['customer_name']); ?></strong>
                            </td>
                            <td class="amount">₱<?php echo number_format($invoice['amount']); ?></td>
                            <td><?php echo date('M j, Y', strtotime($invoice['due_date'])); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($invoice['status']); ?>">
                                    <?php echo $invoice['status']; ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($invoice['status'] === 'Pending'): ?>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="mark_paid">
                                    <input type="hidden" name="invoice_id" value="<?php echo $invoice['id']; ?>">
                                    <button type="submit" class="btn btn-success">Mark Paid</button>
                                </form>
                                <?php else: ?>
                                <span class="status-badge status-paid">Paid</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
