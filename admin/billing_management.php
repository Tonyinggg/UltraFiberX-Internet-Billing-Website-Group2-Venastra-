<?php
require_once 'auth_check.php';
requireAdminLogin();

$pdo = getDBConnection();

$search_query = $_GET['search'] ?? '';
$sort_by = $_GET['sort'] ?? 'date';
$segment_filter = $_GET['segment'] ?? 'all'; // Added customer segmentation filter

if ($_POST && isset($_POST['bulk_action'])) {
    $bulk_action = $_POST['bulk_action'];
    $selected_customers = $_POST['selected_customers'] ?? [];
    
    if (empty($selected_customers)) {
        $error_message = "Please select at least one customer.";
    } else {
        try {
            $placeholders = implode(',', array_fill(0, count($selected_customers), '?'));
            
            if ($bulk_action === 'bulk_suspend') {
                $stmt = $pdo->prepare("UPDATE customers SET status = 'Suspended' WHERE id IN ($placeholders)");
                $stmt->execute($selected_customers);
                $success_message = count($selected_customers) . " account(s) suspended successfully.";
            } elseif ($bulk_action === 'bulk_activate') {
                $stmt = $pdo->prepare("UPDATE customers SET status = 'Active', approved_date = COALESCE(approved_date, CURDATE()) WHERE id IN ($placeholders)");
                $stmt->execute($selected_customers);
                $success_message = count($selected_customers) . " account(s) activated successfully.";
            } elseif ($bulk_action === 'bulk_delete') {
                $stmt = $pdo->prepare("DELETE FROM customers WHERE id IN ($placeholders)");
                $stmt->execute($selected_customers);
                $success_message = count($selected_customers) . " account(s) deleted successfully.";
            }
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    }
}

// Handle single account actions
if ($_POST && isset($_POST['action'])) {
    $action = $_POST['action'];
    $customer_id = (int)$_POST['customer_id'];
    
    try {
        if ($action === 'suspend_account') {
            $stmt = $pdo->prepare("UPDATE customers SET status = 'Suspended' WHERE id = ?");
            $stmt->execute([$customer_id]);
            $success_message = "Account suspended successfully.";
        } elseif ($action === 'activate_account') {
            $stmt = $pdo->prepare("
                UPDATE customers 
                SET status = 'Active', 
                    approved_date = COALESCE(approved_date, CURDATE()) 
                WHERE id = ?
            ");
            $stmt->execute([$customer_id]);
            $success_message = "Account activated successfully.";
        } elseif ($action === 'update_plan') {
            $new_plan = sanitizeInput($_POST['new_plan']);
            $stmt = $pdo->prepare("UPDATE customers SET plan = ? WHERE id = ?");
            $stmt->execute([$new_plan, $customer_id]);
            $success_message = "Plan updated successfully.";
        }
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

try {
    $query = "
        SELECT id, name, email, phone, plan, status, date,
               DATEDIFF(CURDATE(), approved_date) as days_active
        FROM customers 
        WHERE 1=1
    ";
    $params = [];
    
    if ($segment_filter === 'active') {
        $query .= " AND status = 'Active'";
    } elseif ($segment_filter === 'pending') {
        $query .= " AND status = 'Pending'";
    } elseif ($segment_filter === 'suspended') {
        $query .= " AND status = 'Suspended'";
    } elseif ($segment_filter === 'premium') {
        $query .= " AND plan IN ('Plan1800', 'Plan2200')";
    } elseif ($segment_filter === 'basic') {
        $query .= " AND plan IN ('Plan1000', 'Plan1200')";
    } elseif ($segment_filter === 'new') {
        $query .= " AND DATEDIFF(CURDATE(), date) <= 30";
    }
    
    if (!empty($search_query)) {
        $query .= " AND (name LIKE ? OR email LIKE ?)";
        $search_term = "%$search_query%";
        $params = [$search_term, $search_term];
    }
    
    // Sort by first name or surname
    if ($sort_by === 'first_name') {
        $query .= " ORDER BY SUBSTRING_INDEX(name, ' ', 1) ASC";
    } elseif ($sort_by === 'surname') {
        $query .= " ORDER BY SUBSTRING_INDEX(name, ' ', -1) ASC";
    } else {
        $query .= " ORDER BY date DESC";
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $customers = $stmt->fetchAll();
} catch (PDOException $e) {
    $customers = [];
    $error_message = "Error loading customer data.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Accounts - UltraFiberX Admin</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body { margin: 0; padding: 0; }
        .main-content { margin-left: 280px; padding: 2rem; background: #f8f9fa; min-height: 100vh; }
        .dark .main-content { background: #1a1a1a; }
        .page-header { background: white; padding: 2rem; border-radius: 10px; margin-bottom: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .dark .page-header { background: #2a2a2a; color: #fff; }
        .page-header h1 { margin: 0; color: #264229; }
        .dark .page-header h1 { color: #fff; }
        .page-header p { margin: 0.5rem 0 0 0; color: #6c757d; }
        .dark .page-header p { color: #aaa; }
        
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
        }
        .dark .controls-bar { background: #2a2a2a; }
        
        .search-input, .sort-select, .segment-select {
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            color: #333;
        }
        .dark .search-input, .dark .sort-select, .dark .segment-select {
            background: #3a3a3a;
            color: #fff;
            border-color: #555;
        }
        
        .search-input { flex: 1; min-width: 250px; }
        
        /* Added segmentation filter styles */
        .segment-select {
            cursor: pointer;
        }
        
        .segment-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-right: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .segment-badge.active {
            border-color: #264229;
            background: #e8f5e9;
            color: #264229;
        }
        
        .dark .segment-badge.active {
            background: #1b5e20;
            color: #fff;
        }
        
        .bulk-actions-bar {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: none;
            gap: 1rem;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            flex-wrap: wrap;
        }
        .dark .bulk-actions-bar { background: #2a2a2a; }
        
        .bulk-actions-bar.active {
            display: flex;
        }
        
        .bulk-actions-bar .selection-info {
            flex: 1;
            font-weight: 500;
            color: #264229;
        }
        .dark .bulk-actions-bar .selection-info { color: #fff; }
        
        .bulk-actions-bar .action-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .bulk-actions-bar .action-btn.activate {
            background: #28a745;
            color: white;
        }
        
        .bulk-actions-bar .action-btn.activate:hover {
            background: #218838;
        }
        
        .bulk-actions-bar .action-btn.suspend {
            background: #ffc107;
            color: #212529;
        }
        
        .bulk-actions-bar .action-btn.suspend:hover {
            background: #e0a800;
        }
        
        .bulk-actions-bar .action-btn.delete {
            background: #dc3545;
            color: white;
        }
        
        .bulk-actions-bar .action-btn.delete:hover {
            background: #c82333;
        }
        
        .account-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem; }
        .account-card { background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 1px solid #e9ecef; transition: transform 0.3s ease, box-shadow 0.3s ease; position: relative; }
        .dark .account-card { background: #2a2a2a; border-color: #444; color: #fff; }
        .account-card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .account-card .checkbox-wrapper {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }
        
        .account-card input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .account-card.selected {
            background: #f0f7ff;
            border-color: #264229;
        }
        .dark .account-card.selected { background: #1b5e20; }
        
        .account-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; margin-top: 1.5rem; }
        .account-name { font-size: 1.2rem; font-weight: 600; color: #264229; }
        .dark .account-name { color: #fff; }
        .account-status { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; font-weight: 500; }
        .status-active { background: #d4edda; color: #155724; }
        .status-suspended { background: #f8d7da; color: #721c24; }
        .status-pending { background: #fff3cd; color: #856404; }
        .account-details { margin-bottom: 1.5rem; }
        .detail-row { display: flex; justify-content: space-between; margin-bottom: 0.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #eee; }
        .dark .detail-row { border-bottom-color: #444; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #6c757d; font-weight: 500; }
        .dark .detail-label { color: #aaa; }
        .detail-value { font-weight: 600; color: #333; }
        .dark .detail-value { color: #fff; }
        .account-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 1.5rem; }
        .btn { padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; font-size: 0.875rem; font-weight: 500; transition: all 0.3s ease; }
        .btn-primary { background: #264229; color: white; }
        .btn-primary:hover { background: #1a2e1c; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-warning:hover { background: #e0a800; }
        .btn-select { padding: 0.5rem; border: 1px solid #ddd; border-radius: 5px; font-size: 0.875rem; flex: 1; }
        .dark .btn-select { background: #3a3a3a; color: #fff; border-color: #555; }
        .alert { padding: 1rem; border-radius: 5px; margin-bottom: 1rem; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        @media (max-width: 768px) { 
            .main-content { margin-left: 0; padding: 1rem; } 
            .account-grid { grid-template-columns: 1fr; }
            .controls-bar { flex-direction: column; }
            .search-input { min-width: 100%; }
            .bulk-actions-bar { flex-direction: column; }
        }
        
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="page-header">
            <h1>Customer Account Management</h1>
            <p>Manage customer accounts and plans</p>
        </div>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="controls-bar">
            <input type="text" class="search-input" id="searchInput" placeholder="Search by name or email..." value="<?php echo htmlspecialchars($search_query); ?>">
            <select class="sort-select" id="sortSelect">
                <option value="date" <?php echo $sort_by === 'date' ? 'selected' : ''; ?>>Sort by Date</option>
                <option value="first_name" <?php echo $sort_by === 'first_name' ? 'selected' : ''; ?>>Sort by First Name</option>
                <option value="surname" <?php echo $sort_by === 'surname' ? 'selected' : ''; ?>>Sort by Surname</option>
            </select>
            <!-- Added customer segmentation dropdown -->
            <select class="segment-select" id="segmentSelect">
                <option value="all" <?php echo $segment_filter === 'all' ? 'selected' : ''; ?>>All Customers</option>
                <option value="active" <?php echo $segment_filter === 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="pending" <?php echo $segment_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="suspended" <?php echo $segment_filter === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                <option value="premium" <?php echo $segment_filter === 'premium' ? 'selected' : ''; ?>>Premium Plans</option>
                <option value="basic" <?php echo $segment_filter === 'basic' ? 'selected' : ''; ?>>Basic Plans</option>
                <option value="new" <?php echo $segment_filter === 'new' ? 'selected' : ''; ?>>New (Last 30 Days)</option>
            </select>
        </div>

        <form id="bulkActionsForm" method="POST">
            <div class="bulk-actions-bar" id="bulkActionsBar">
                <span class="selection-info"><span id="selectedCount">0</span> customer(s) selected</span>
                <button type="submit" name="bulk_action" value="bulk_activate" class="action-btn activate" onclick="return confirm('Activate selected accounts?')">Activate</button>
                <button type="submit" name="bulk_action" value="bulk_suspend" class="action-btn suspend" onclick="return confirm('Suspend selected accounts?')">Suspend</button>
                <button type="submit" name="bulk_action" value="bulk_delete" class="action-btn delete" onclick="return confirm('Delete selected accounts? This cannot be undone.')">Delete</button>
            </div>

            <div class="account-grid">
                <?php foreach ($customers as $customer): ?>
                <div class="account-card" data-customer-id="<?php echo $customer['id']; ?>">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" name="selected_customers[]" value="<?php echo $customer['id']; ?>" class="customer-checkbox" onchange="updateBulkActionsBar()">
                    </div>
                    
                    <div class="account-header">
                        <div class="account-name"><?php echo htmlspecialchars($customer['name']); ?></div>
                        <div class="account-status status-<?php echo strtolower($customer['status']); ?>">
                            <?php echo $customer['status']; ?>
                        </div>
                    </div>
                    
                    <div class="account-details">
                        <div class="detail-row">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($customer['email']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Phone:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($customer['phone']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Plan:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($customer['plan']); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Days Active:</span>
                            <span class="detail-value">
                                <?php echo is_null($customer['days_active']) ? "Not yet approved" : $customer['days_active'] . " days"; ?>
                            </span>
                        </div>
                    </div>

                    <div class="account-actions">
                        <?php if ($customer['status'] === 'Active'): ?>
                            <form method="POST" style="display: inline; flex: 1;">
                                <input type="hidden" name="action" value="suspend_account">
                                <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
                                <button type="submit" class="btn btn-warning" style="width: 100%;" onclick="return confirm('Suspend this account?')">Suspend</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" style="display: inline; flex: 1;">
                                <input type="hidden" name="action" value="activate_account">
                                <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Activate</button>
                            </form>
                        <?php endif; ?>
                        
                        <form method="POST" style="display: inline; flex: 1;">
                            <input type="hidden" name="action" value="update_plan">
                            <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
                            <select name="new_plan" onchange="this.form.submit()" class="btn-select">
                                <option value="">Change Plan</option>
                                <option value="Plan1000">Plan1000 - 100Mbps</option>
                                <option value="Plan1200">Plan1200 - 150Mbps</option>
                                <option value="Plan1500">Plan1500 - 200Mbps</option>
                                <option value="Plan1800">Plan1800 - 300Mbps</option>
                                <option value="Plan2200">Plan2200 - 500Mbps</option>
                            </select>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                updateFilters();
            }
        });
        
        document.getElementById('sortSelect').addEventListener('change', updateFilters);
        document.getElementById('segmentSelect').addEventListener('change', updateFilters);
        
        function updateFilters() {
            const search = document.getElementById('searchInput').value;
            const sort = document.getElementById('sortSelect').value;
            const segment = document.getElementById('segmentSelect').value;
            window.location.href = `?search=${encodeURIComponent(search)}&sort=${sort}&segment=${segment}`;
        }
        
        function updateBulkActionsBar() {
            const checkboxes = document.querySelectorAll('.customer-checkbox:checked');
            const bulkActionsBar = document.getElementById('bulkActionsBar');
            const selectedCount = document.getElementById('selectedCount');
            
            selectedCount.textContent = checkboxes.length;
            
            if (checkboxes.length > 0) {
                bulkActionsBar.classList.add('active');
                checkboxes.forEach(checkbox => {
                    checkbox.closest('.account-card').classList.add('selected');
                });
            } else {
                bulkActionsBar.classList.remove('active');
            }
            
            document.querySelectorAll('.account-card').forEach(card => {
                const checkbox = card.querySelector('.customer-checkbox');
                if (!checkbox.checked) {
                    card.classList.remove('selected');
                }
            });
        }
    </script>
</body>
</html>
