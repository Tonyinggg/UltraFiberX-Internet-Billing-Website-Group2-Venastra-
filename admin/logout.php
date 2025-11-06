<?php
require_once 'auth_check.php';
requireAdminLogin(); // Ensure user is logged in

// Handle logout confirmation from modal
if (isset($_POST['confirm_logout'])) {
    adminLogout();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - UltraFiberX</title>
<link rel="stylesheet" href="../styles.css">
<style>
    /* Modal backdrop */
    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    /* Modal box */
    .modal {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        text-align: center;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal h2 {
        margin-bottom: 1.5rem;
        color: #264229;
    }

    .modal form button {
        padding: 0.75rem 1.5rem;
        margin: 0 0.5rem;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s;
    }

    .confirm-btn {
        background: #264229;
        color: white;
    }
    .confirm-btn:hover { background: #1a2e1c; }

    .cancel-btn {
        background: #c62828;
        color: white;
    }
    .cancel-btn:hover { background: #8e1c1c; }
</style>
</head>
<body>

<!-- Example dashboard content -->
<h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h1>
<button id="logoutBtn">Logout</button>

<!-- Modal -->
<div class="modal-backdrop" id="logoutModal">
    <div class="modal">
        <h2>Are you sure you want to logout?</h2>
        <form method="POST">
            <button type="submit" name="confirm_logout" class="confirm-btn">Yes, Logout</button>
            <button type="button" class="cancel-btn" id="cancelLogout">Cancel</button>
        </form>
    </div>
</div>

<script>
    const logoutBtn = document.getElementById('logoutBtn');
    const modal = document.getElementById('logoutModal');
    const cancelBtn = document.getElementById('cancelLogout');

    logoutBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Optional: close modal when clicking outside
    window.addEventListener('click', e => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>

</body>
</html>
