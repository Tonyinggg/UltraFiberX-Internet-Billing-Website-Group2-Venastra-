<?php
require_once 'auth_check.php';
requireAdminLogin();

$pdo = getDBConnection();

try {
    // ===== Customer Statistics =====
    $customer_stats = $pdo->query("
        SELECT 
            COUNT(*) AS total_customers,
            SUM(CASE WHEN status = 'Active' THEN 1 ELSE 0 END) AS active_customers,
            SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS pending_customers,
            SUM(CASE WHEN status = 'Suspended' THEN 1 ELSE 0 END) AS suspended_customers
        FROM customers
    ")->fetch();

    // ===== Plan Distribution =====
    $plan_stats = $pdo->query("
        SELECT 
            plan, 
            COUNT(*) AS count,
            CASE plan
                WHEN 'Plan1000' THEN 1000
                WHEN 'Plan1200' THEN 1200
                WHEN 'Plan1500' THEN 1500
                WHEN 'Plan1800' THEN 1800
                WHEN 'Plan2200' THEN 2200
                ELSE 1000
            END AS monthly_revenue
        FROM customers 
        WHERE status = 'Active'
        GROUP BY plan
        ORDER BY count DESC
    ")->fetchAll();

    // ===== Total Monthly Revenue =====
    $total_revenue = 0;
    foreach ($plan_stats as $plan) {
        $total_revenue += $plan['count'] * $plan['monthly_revenue'];
    }

    // ===== Recent Signups (Last 30 Days) =====
    $recent_signups = $pdo->query("
        SELECT DATE(date) AS signup_date, COUNT(*) AS signups
        FROM customers 
        WHERE date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        GROUP BY DATE(date)
        ORDER BY signup_date DESC
        LIMIT 10
    ")->fetchAll();

} catch (PDOException $e) {
    $error_message = "Error loading analytics data.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Analytics - UltraFiberX Admin</title>
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
        
        .revenue-highlight {
            background: linear-gradient(135deg, #264229, #4caf50);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(38, 66, 41, 0.3);
        }
        
        .revenue-highlight h3 {
            margin: 0 0 0.5rem 0;
        }
        
        .revenue-amount {
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .analytics-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-align: center;
            border: 1px solid #e9ecef;
        }
        
        .metric-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #264229;
            margin-bottom: 0.5rem;
        }
        
        .metric-label {
            color: #6c757d;
            font-weight: 500;
        }
        
        .chart-container {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }
        
        .chart-container h3 {
            margin-top: 0;
            color: #264229;
        }
        
        .plan-bar {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .plan-name {
            width: 120px;
            font-weight: 600;
        }
        
        .plan-progress {
            flex: 1;
            height: 20px;
            background: #e9ecef;
            border-radius: 10px;
            margin: 0 1rem;
            overflow: hidden;
        }
        
        .plan-fill {
            height: 100%;
            background: linear-gradient(90deg, #264229, #4caf50);
            border-radius: 10px;
        }
        
        .plan-count {
            width: 80px;
            text-align: right;
            font-weight: 600;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
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
        
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            background: #f8d7da;
            color: #721c24;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .analytics-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>Service Analytics</h1>
            <p>Monitor performance and customer insights</p>
        </div>

        <?php if (isset($error_message)): ?>
            <div class="alert"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Revenue Summary -->
        <div class="revenue-highlight">
            <h3>Monthly Recurring Revenue</h3>
            <div class="revenue-amount">₱<?php echo number_format($total_revenue ?? 0); ?></div>
        </div>

        <!-- Quick Stats -->
        <div class="analytics-grid">
            <div class="analytics-card">
                <div class="metric-number"><?php echo $customer_stats['total_customers'] ?? 0; ?></div>
                <div class="metric-label">Total Customers</div>
            </div>
            <div class="analytics-card">
                <div class="metric-number"><?php echo $customer_stats['active_customers'] ?? 0; ?></div>
                <div class="metric-label">Active Customers</div>
            </div>
            <div class="analytics-card">
                <div class="metric-number"><?php echo $customer_stats['pending_customers'] ?? 0; ?></div>
                <div class="metric-label">Pending Approvals</div>
            </div>
            <div class="analytics-card">
                <div class="metric-number"><?php echo count($plan_stats); ?></div>
                <div class="metric-label">Active Plans</div>
            </div>
        </div>

        <!-- Plan Distribution -->
        <div class="chart-container">
            <h3>Plan Distribution</h3>
            <?php if (!empty($plan_stats)): ?>
                <?php 
                $counts = array_column($plan_stats, 'count');
                $max_count = !empty($counts) ? max($counts) : 0;
                foreach ($plan_stats as $plan): 
                    $percentage = ($max_count > 0) ? ($plan['count'] / $max_count) * 100 : 0;
                ?>
                    <div class="plan-bar">
                        <div class="plan-name"><?php echo htmlspecialchars($plan['plan']); ?></div>
                        <div class="plan-progress">
                            <div class="plan-fill" style="width: <?php echo $percentage; ?>%"></div>
                        </div>
                        <div class="plan-count"><?php echo $plan['count']; ?> customers</div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #6c757d;">No active plans found.</p>
            <?php endif; ?>
        </div>

        <!-- Recent Signups -->
        <div class="chart-container">
            <h3>Recent Signups (Last 30 Days)</h3>
            <?php if (!empty($recent_signups)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>New Signups</th>
                        <th>Day of Week</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_signups as $signup): ?>
                    <tr>
                        <td><?php echo date('M j, Y', strtotime($signup['signup_date'])); ?></td>
                        <td><strong><?php echo $signup['signups']; ?></strong></td>
                        <td><?php echo date('l', strtotime($signup['signup_date'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p style="color: #6c757d;">No signups recorded in the last 30 days.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
