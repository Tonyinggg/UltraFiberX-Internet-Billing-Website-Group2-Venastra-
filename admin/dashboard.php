<?php
require_once 'auth_check.php';
requireAdminLogin();

$admin = getAdminInfo();
$pdo = getDBConnection();

$active_tab = $_GET['tab'] ?? 'customers';
$search_query = $_GET['search'] ?? '';
$sort_by = $_GET['sort'] ?? 'date';

$widget_order = $_SESSION['widget_order'] ?? ['stats', 'expiring', 'customers', 'inquiries'];

if ($_POST && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = (int)$_POST['id'];
    
    try {
        if ($action === 'update_customer_status') {
            $status = sanitizeInput($_POST['status']);
            $stmt = $pdo->prepare("UPDATE customers SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            $success_message = "Customer status updated successfully.";
        } elseif ($action === 'update_inquiry_status') {
            $status = sanitizeInput($_POST['status']);
            $stmt = $pdo->prepare("UPDATE inquiries SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            $success_message = "Inquiry status updated successfully.";
        } elseif ($action === 'delete_customer') {
            $stmt = $pdo->prepare("DELETE FROM customers WHERE id = ?");
            $stmt->execute([$id]);
            $success_message = "Customer removed successfully from database.";
        } elseif ($action === 'delete_inquiry') {
            $stmt = $pdo->prepare("DELETE FROM inquiries WHERE id = ?");
            $stmt->execute([$id]);
            $success_message = "Inquiry removed successfully from database.";
        }
    } catch (PDOException $e) {
        $error_message = "Error processing request: " . $e->getMessage();
    }
}

// Get statistics
try {
    $stats = [];
    
    $stmt = $pdo->query("SELECT status, COUNT(*) as count FROM customers GROUP BY status");
    $customer_stats = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    $stats['total_customers'] = array_sum($customer_stats);
    $stats['pending_customers'] = $customer_stats['Pending'] ?? 0;
    
    $stmt = $pdo->query("SELECT status, COUNT(*) as count FROM inquiries GROUP BY status");
    $inquiry_stats = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    $stats['total_inquiries'] = array_sum($inquiry_stats);
    $stats['pending_inquiries'] = $inquiry_stats['Pending'] ?? 0;
    
} catch (PDOException $e) {
    error_log("Dashboard stats error: " . $e->getMessage());
}

try {
    $query = "SELECT * FROM customers WHERE 1=1";
    $params = [];
    
    if (!empty($search_query)) {
        $query .= " AND (name LIKE ? OR email LIKE ?)";
        $search_term = "%$search_query%";
        $params = [$search_term, $search_term];
    }
    
    if ($sort_by === 'first_name') {
        $query .= " ORDER BY SUBSTRING_INDEX(name, ' ', 1) ASC";
    } elseif ($sort_by === 'surname') {
        $query .= " ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC";
    } else {
        $query .= " ORDER BY date DESC";
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $recent_customers = $stmt->fetchAll();
    
    $inquiry_query = "SELECT * FROM inquiries WHERE 1=1";
    $inquiry_params = [];
    
    if (!empty($search_query)) {
        $inquiry_query .= " AND (name LIKE ? OR email LIKE ?)";
        $inquiry_params = ["%$search_query%", "%$search_query%"];
    }
    
    if ($sort_by === 'first_name') {
        $inquiry_query .= " ORDER BY SUBSTRING_INDEX(name, ' ', 1) ASC";
    } elseif ($sort_by === 'surname') {
        $inquiry_query .= " ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC";
    } else {
        $inquiry_query .= " ORDER BY date DESC";
    }
    
    $stmt = $pdo->prepare($inquiry_query);
    $stmt->execute($inquiry_params);
    $recent_inquiries = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Dashboard data error: " . $e->getMessage());
    $recent_customers = [];
    $recent_inquiries = [];
}

try {
    $expiring_stmt = $pdo->prepare("
        SELECT name, email, plan, DATE_ADD(date, INTERVAL 30 DAY) as expiry_date 
        FROM customers 
        WHERE status = 'Active' 
        AND DATE_ADD(date, INTERVAL 30 DAY) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
        ORDER BY expiry_date ASC
    ");
    $expiring_stmt->execute();
    $expiring_customers = $expiring_stmt->fetchAll();
} catch (PDOException $e) {
    $expiring_customers = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - UltraFiberX</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            transition: background 0.3s ease, color 0.3s ease;
        }
        
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            background: #f8f9fa;
            min-height: 100vh;
            transition: background 0.3s ease, color 0.3s ease;
        }
        
        .admin-header {
            background: white;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s ease, color 0.3s ease;
        }
        
        .dark .admin-header {
            background: #2a2a2a;
            color: #fff;
        }
        
        .admin-header h1 {
            margin: 0;
            color: #264229;
        }
        
        .dark .admin-header h1 {
            color: #fff;
        }
        
        .admin-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .admin-nav span {
            background: #f0f0f0;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
        }
        
        .dark .admin-nav span {
            background: #3a3a3a;
            color: #fff;
        }
        
        .admin-nav a {
            color: white;
            text-decoration: none;
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .admin-nav a:hover {
            transform: translateY(-1px);
        }
        
        .admin-nav a[href*="logout"] {
            background: #dc3545;
        }
        
        .admin-nav a[href*="logout"]:hover {
            background: #c82333;
        }
        
        .admin-nav a[href*="index"] {
            background: #6c757d;
        }
        
        .admin-nav a[href*="index"]:hover {
            background: #5a6268;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }
        
        .stat-card {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            text-align: center;
            border: 1px solid #e9ecef;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
        }
        
        .dark .stat-card {
            background: #2a2a2a;
            border-color: #444;
            color: #fff;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #264229;
            margin-bottom: 0.5rem;
        }
        
        .dark .stat-number {
            color: #4caf50;
        }
        
        .stat-label {
            color: #6c757d;
            font-weight: 500;
        }
        
        .dark .stat-label {
            color: #aaa;
        }
        
        .notification-panel {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(255, 107, 107, 0.3);
        }
        
        .notification-panel h3 {
            margin: 0 0 1rem 0;
            font-size: 1.2rem;
        }
        
        .notification-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .notification-list li {
            background: rgba(255,255,255,0.15);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .controls-bar {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            flex-wrap: wrap;
            transition: background 0.3s ease;
        }
        
        .dark .controls-bar {
            background: #2a2a2a;
        }
        
        .search-input, .sort-select {
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            color: #333;
            transition: background 0.3s ease, color 0.3s ease;
        }
        
        .dark .search-input, .dark .sort-select {
            background: #3a3a3a;
            color: #fff;
            border-color: #555;
        }
        
        .search-input {
            flex: 1;
            min-width: 250px;
        }
        
        .sort-select {
            cursor: pointer;
        }
        
        .tabs {
            display: flex;
            border-bottom: 2px solid #ddd;
            margin-bottom: 1rem;
            background: white;
            border-radius: 10px 10px 0 0;
            transition: background 0.3s ease;
        }
        
        .dark .tabs {
            background: #2a2a2a;
            border-bottom-color: #444;
        }
        
        .tab {
            padding: 1.2rem 2.5rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #666;
            border-bottom: 2px solid transparent;
            transition: all 0.3s;
        }
        
        .dark .tab {
            color: #aaa;
        }
        
        .tab.active {
            color: #264229;
            border-bottom-color: #264229;
        }
        
        .dark .tab.active {
            color: #4caf50;
            border-bottom-color: #4caf50;
        }
        
        .tab-content {
            display: none;
            background: white;
            padding: 2rem;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: background 0.3s ease;
        }
        
        .dark .tab-content {
            background: #2a2a2a;
            color: #fff;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th,
        .data-table td {
            padding: 1.5rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .dark .data-table th,
        .dark .data-table td {
            border-bottom-color: #444;
        }
        
        .data-table th {
            background: #f5f5f5;
            font-weight: 600;
        }
        
        .dark .data-table th {
            background: #3a3a3a;
            color: #fff;
        }
        
        .data-table tbody tr:hover {
            background: #f9f9f9;
        }
        
        .dark .data-table tbody tr:hover {
            background: #3a3a3a;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-pending { background: #fff3cd; color: #856404; }
        .status-approved { background: #d4edda; color: #155724; }
        .status-active { background: #d1ecf1; color: #0c5460; }
        
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
        }
        
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .admin-header {
                flex-direction: column;
                gap: 1rem;
            }
            
            .controls-bar {
                flex-direction: column;
            }
            
            .search-input {
                min-width: 100%;
            }
            
            .data-table th,
            .data-table td {
                padding: 0.75rem;
                font-size: 0.875rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="admin-header">
            <h1>Dashboard</h1>
            <div class="admin-nav">
            <span>Welcome, <?php echo htmlspecialchars($admin['username']); ?></span>
            <a href="../index.php" target="_blank">View Website</a>
        </div>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (!empty($expiring_customers)): ?>
        <div class="notification-panel">
            <h3>Plans Expiring Soon (Next 7 Days)</h3>
            <ul class="notification-list">
                <?php foreach ($expiring_customers as $customer): ?>
                <li>
                    <span>
                        <strong><?php echo htmlspecialchars($customer['name']); ?></strong>
                        (<?php echo htmlspecialchars($customer['plan']); ?>)
                    </span>
                    <span style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.5rem; border-radius: 5px;">
                        Expires: <?php echo date('M j, Y', strtotime($customer['expiry_date'])); ?>
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_customers'] ?? 0; ?></div>
                <div class="stat-label">Total Customers</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['pending_customers'] ?? 0; ?></div>
                <div class="stat-label">Pending Customers</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_inquiries'] ?? 0; ?></div>
                <div class="stat-label">Total Inquiries</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['pending_inquiries'] ?? 0; ?></div>
                <div class="stat-label">Pending Inquiries</div>
            </div>
        </div>

        <div class="tabs">
            <button class="tab <?php echo $active_tab === 'customers' ? 'active' : ''; ?>" onclick="showTab('customers')">Customers</button>
            <button class="tab <?php echo $active_tab === 'inquiries' ? 'active' : ''; ?>" onclick="showTab('inquiries')">Inquiries</button>
        </div>

        <div class="controls-bar">
            <input type="text" class="search-input" id="searchInput" placeholder="Search by name or email..." value="<?php echo htmlspecialchars($search_query); ?>">
            <select class="sort-select" id="sortSelect">
                <option value="date" <?php echo $sort_by === 'date' ? 'selected' : ''; ?>>Sort by Date</option>
                <option value="first_name" <?php echo $sort_by === 'first_name' ? 'selected' : ''; ?>>Sort by First Name</option>
                <option value="surname" <?php echo $sort_by === 'surname' ? 'selected' : ''; ?>>Sort by Surname</option>
            </select>
        </div>

        <div id="customers" class="tab-content <?php echo $active_tab === 'customers' ? 'active' : ''; ?>">
            <h2>Customer Signups</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th><th>Name</th><th>Email</th><th>Phone</th>
                        <th>Plan</th><th>Status</th><th>Date</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_customers as $customer): ?>
                    <tr>
                        <td><?php echo $customer['id']; ?></td>
                        <td><?php echo htmlspecialchars($customer['name']); ?></td>
                        <td><?php echo htmlspecialchars($customer['email']); ?></td>
                        <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                        <td><?php echo htmlspecialchars($customer['plan']); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $customer['status'])); ?>">
                                <?php echo $customer['status']; ?>
                            </span>
                        </td>
                        <td><?php echo date('M j, Y', strtotime($customer['date'])); ?></td>
                        <td>
                            <form method="POST" style="display: inline-flex; gap: 0.5rem; align-items: center;">
                                <input type="hidden" name="action" value="update_customer_status">
                                <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
                                <select name="status" style="padding: 0.25rem 0.5rem; border: 1px solid #ddd; border-radius: 5px;">
                                    <option value="Pending" <?php echo $customer['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Approved" <?php echo $customer['status'] === 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                    <option value="Rejected" <?php echo $customer['status'] === 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                    <option value="Active" <?php echo $customer['status'] === 'Active' ? 'selected' : ''; ?>>Active</option>
                                </select>
                                <button type="submit" style="background: #264229; color: white; border: none; padding: 0.25rem 0.75rem; border-radius: 5px; cursor: pointer;">Update</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="inquiries" class="tab-content <?php echo $active_tab === 'inquiries' ? 'active' : ''; ?>">
            <h2>Inquiries</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th><th>Name</th><th>Email</th><th>Subject</th>
                        <th>Priority</th><th>Status</th><th>Date</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_inquiries as $inquiry): ?>
                    <tr>
                        <td><?php echo $inquiry['id']; ?></td>
                        <td><?php echo htmlspecialchars($inquiry['name']); ?></td>
                        <td><?php echo htmlspecialchars($inquiry['email']); ?></td>
                        <td><?php echo htmlspecialchars($inquiry['subject']); ?></td>
                        <td><?php echo ucfirst($inquiry['priority']); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $inquiry['status'])); ?>">
                                <?php echo $inquiry['status']; ?>
                            </span>
                        </td>
                        <td><?php echo date('M j, Y', strtotime($inquiry['date'])); ?></td>
                        <td>
                            <form method="POST" style="display: inline-flex; gap: 0.5rem; align-items: center;">
                                <input type="hidden" name="action" value="update_inquiry_status">
                                <input type="hidden" name="id" value="<?php echo $inquiry['id']; ?>">
                                <select name="status" style="padding: 0.25rem 0.5rem; border: 1px solid #ddd; border-radius: 5px;">
                                    <option value="Pending" <?php echo $inquiry['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="In Progress" <?php echo $inquiry['status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="Resolved" <?php echo $inquiry['status'] === 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                    <option value="Closed" <?php echo $inquiry['status'] === 'Closed' ? 'selected' : ''; ?>>Closed</option>
                                </select>
                                <button type="submit" style="background: #264229; color: white; border: none; padding: 0.25rem 0.75rem; border-radius: 5px; cursor: pointer;">Update</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.getElementById(tabName).classList.add('active');
            
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => {
                if (tab.textContent.toLowerCase().includes(tabName.replace('-', ' '))) {
                    tab.classList.add('active');
                }
            });
        }
        
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                updateFilters();
            }
        });
        
        document.getElementById('sortSelect').addEventListener('change', updateFilters);
        
        function updateFilters() {
            const search = document.getElementById('searchInput').value;
            const sort = document.getElementById('sortSelect').value;
            const tab = document.querySelector('.tab.active').textContent.toLowerCase().includes('customer') ? 'customers' : 'inquiries';
            window.location.href = `?tab=${tab}&search=${encodeURIComponent(search)}&sort=${sort}`;
        }
    </script>
</body>
</html>
