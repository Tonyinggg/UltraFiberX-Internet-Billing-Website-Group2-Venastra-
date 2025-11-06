<?php
/**
 * Admin Page - View All Customer Signups
 * Displays all customer applications in a table format
 */

// Include database connection
require_once 'db_connect.php';

// Fetch all customers from database
$sql = "SELECT * FROM customers ORDER BY date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Applications - ConnectPH Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .admin-table th, .admin-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .admin-table th {
            background-color: #1a237e;
            color: white;
            font-weight: 600;
        }
        .admin-table tr:hover {
            background-color: #f5f5f5;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .admin-nav {
            display: flex;
            gap: 10px;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-new { background: #e3f2fd; color: #1976d2; }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Customer Applications</h1>
            <div class="admin-nav">
                <a href="view_customers.php" class="btn btn-primary">Customers</a>
                <a href="view_inquiries.php" class="btn btn-secondary">Inquiries</a>
                <a href="index.html" class="btn btn-outline">Back to Site</a>
            </div>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
            <p>Total Applications: <strong><?php echo $result->num_rows; ?></strong></p>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Plan</th>
                        <th>Install Date</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Date Applied</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo str_pad($row['id'], 6, '0', STR_PAD_LEFT); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['plan']); ?></td>
                        <td><?php echo $row['install_date'] ? date('M j, Y', strtotime($row['install_date'])) : 'N/A'; ?></td>
                        <td><?php echo htmlspecialchars($row['city']); ?></td>
                        <td><span class="status-badge status-new">New</span></td>
                        <td><?php echo date('M j, Y g:i A', strtotime($row['date'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align: center; padding: 50px;">
                <h3>No customer applications found</h3>
                <p>Customer signups will appear here once submitted.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
