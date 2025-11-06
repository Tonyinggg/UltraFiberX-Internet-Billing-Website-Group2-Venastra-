<?php
/**
 * Admin Page - View All Support Requests
 * Displays all customer support requests and inquiries in a table format
 */

// Include database connection
require_once 'db_connect.php';

// Fetch all support requests from database
$sql = "SELECT * FROM inquiries ORDER BY date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Support Requests - ConnectPH Admin</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .admin-container {
            max-width: 1400px; /* increased width to accommodate new column */
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
            background-color: #264229; /* updated to green theme color */
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
        .priority-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .priority-low { background: #e8f5e8; color: #2e7d32; }
        .priority-medium { background: #fff3e0; color: #f57c00; }
        .priority-high { background: #ffebee; color: #d32f2f; }
        .priority-urgent { background: #f3e5f5; color: #7b1fa2; } /* updated critical to urgent */
        .message-preview {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        /* added inquiry type badge styling */
        .type-badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .type-general { background: #e3f2fd; color: #1976d2; }
        .type-technical { background: #fff3e0; color: #f57c00; }
        .type-billing { background: #e8f5e8; color: #388e3c; }
        .type-business { background: #f3e5f5; color: #7b1fa2; }
        .type-complaint { background: #ffebee; color: #d32f2f; }
        .type-feedback { background: #e0f2f1; color: #00796b; }
        .type-other { background: #f5f5f5; color: #616161; }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <!-- updated title to reflect unified support system -->
            <h1>Customer Support Requests</h1>
            <div class="admin-nav">
                <a href="view_customers.php" class="btn btn-secondary">Customers</a>
                <a href="view_inquiries.php" class="btn btn-primary">Support Requests</a>
                <a href="index.html" class="btn btn-outline">Back to Site</a>
            </div>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
            <!-- updated terminology from inquiries to support requests -->
            <p>Total Support Requests: <strong><?php echo $result->num_rows; ?></strong></p>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th> <!-- added inquiry type column -->
                        <th>Subject</th>
                        <th>Message Preview</th>
                        <th>Priority</th>
                        <th>Account #</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo str_pad($row['id'], 6, '0', STR_PAD_LEFT); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <!-- added inquiry type display with badge -->
                        <td>
                            <span class="type-badge type-<?php echo $row['inquiry_type'] ?? 'general'; ?>">
                                <?php echo ucfirst($row['inquiry_type'] ?? 'general'); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td class="message-preview" title="<?php echo htmlspecialchars($row['message']); ?>">
                            <?php echo htmlspecialchars(substr($row['message'], 0, 50)) . '...'; ?>
                        </td>
                        <td>
                            <span class="priority-badge priority-<?php echo $row['priority']; ?>">
                                <?php echo ucfirst($row['priority']); ?>
                            </span>
                        </td>
                        <td><?php echo $row['account_number'] ? htmlspecialchars($row['account_number']) : 'N/A'; ?></td>
                        <td><?php echo date('M j, Y g:i A', strtotime($row['date'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align: center; padding: 50px;">
                <!-- updated messaging to reflect unified support system -->
                <h3>No support requests found</h3>
                <p>Customer support requests will appear here once submitted.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
