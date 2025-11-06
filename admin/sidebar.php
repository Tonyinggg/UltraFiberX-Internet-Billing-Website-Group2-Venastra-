<?php
// Sidebar navigation component with dark mode toggle

$current_page = basename($_SERVER['PHP_SELF']);
$current_theme = $_SESSION['theme'] ?? 'light';
?>
<style>
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100vh;
        background: linear-gradient(135deg, #264229 0%, #2e7d32 100%);
        color: white;
        padding: 0;
        margin: 0;
        overflow-y: auto;
        box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        z-index: 1000;
        transition: background 0.3s ease;
    }
    
    
    .sidebar-header {
        padding: 2rem 1.5rem;
        border-bottom: 2px solid rgba(255,255,255,0.1);
        text-align: center;
    }
    
    .sidebar-logo {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .sidebar-subtitle {
        font-size: 0.85rem;
        opacity: 0.8;
    }
    
    .sidebar-nav {
        list-style: none;
        padding: 1rem 0;
        margin: 0;
    }
    
    .sidebar-nav li {
        margin: 0;
    }
    
    .sidebar-nav a {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .sidebar-nav a:hover {
        background: rgba(255,255,255,0.1);
        border-left-color: #4caf50;
        padding-left: 1.75rem;
    }
    
    .sidebar-nav a.active {
        background: rgba(255,255,255,0.15);
        border-left-color: #ffc107;
        font-weight: 600;
    }
    
    .sidebar-nav .icon {
        font-size: 1.2rem;
        width: 24px;
        text-align: center;
    }
    
    /* Added theme toggle button styles */
    .theme-toggle-btn {
        width: 100%;
        padding: 0.75rem 1.5rem;
        background: rgba(255,255,255,0.1);
        color: white;
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .theme-toggle-btn:hover {
        background: rgba(255,255,255,0.2);
        border-color: rgba(255,255,255,0.3);
    }
    
    .sidebar-footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 1rem;
        border-top: 2px solid rgba(255,255,255,0.1);
        background: rgba(0,0,0,0.1);
    }
    
    .sidebar-footer a {
        display: block;
        padding: 0.75rem;
        color: white;
        text-decoration: none;
        text-align: center;
        background: #dc3545;
        border-radius: 5px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .sidebar-footer a:hover {
        background: #c82333;
        transform: translateY(-2px);
    }
    
    .main-content {
        margin-left: 280px;
        min-height: 100vh;
        background: #f8f9fa;
        transition: background 0.3s ease, color 0.3s ease;
    }
    
    /* Added dark mode styles for main content */
    .dark .main-content {
        background: #1a1a1a;
        color: #fff;
    }
    
    @media (max-width: 768px) {
        .sidebar {
            width: 250px;
        }
        .main-content {
            margin-left: 0;
        }
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        .sidebar.active {
            transform: translateX(0);
        }
    }
</style>

<div class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">Ultra Fiber X</div>
        <div class="sidebar-subtitle">Admin Panel</div>
    </div>
    
    <ul class="sidebar-nav">
        <li>
            <a href="dashboard.php" class="<?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>">
                <span class="icon">📊</span>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="customer_accounts.php" class="<?php echo $current_page === 'customer_accounts.php' ? 'active' : ''; ?>">
                <span class="icon">👥</span>
                <span>Customer Accounts</span>
            </a>
        </li>
        <li>
            <a href="billing_management.php" class="<?php echo $current_page === 'billing_management.php' ? 'active' : ''; ?>">
                <span class="icon">💰</span>
                <span>Billing</span>
            </a>
        </li>
        <li>
            <a href="service_analytics.php" class="<?php echo $current_page === 'service_analytics.php' ? 'active' : ''; ?>">
                <span class="icon">📈</span>
                <span>Analytics</span>
            </a>
        </li>
        <li>
            <a href="messaging.php" class="<?php echo $current_page === 'messaging.php' ? 'active' : ''; ?>">
                <span class="icon">✉️</span>
                <span>Messaging</span>
            </a>
        </li>
    </ul>
    
    <div class="sidebar-footer">
    <a href="auth_check.php?logout=true" 
       onclick="return confirm('Are you sure you want to logout?');">
       Logout
    </a>
</div>

</div>

<!-- Added dark mode toggle script -->
<script>
    function toggleTheme() {
        const html = document.documentElement;
        const currentTheme = html.classList.contains('dark') ? 'dark' : 'light';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        html.classList.toggle('dark');
        
        const themeIcon = document.getElementById('themeIcon');
        const themeText = document.getElementById('themeText');
        
        themeIcon.textContent = newTheme === 'dark' ? '☀️' : '🌙';
        themeText.textContent = newTheme === 'dark' ? 'Light Mode' : 'Dark Mode';
        
        // Save preference to server
        fetch('theme-toggle.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=toggle_theme'
        });
        
        // Save to localStorage for persistence
        localStorage.setItem('theme', newTheme);
    }
    
    // Load theme preference on page load
    window.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('theme') || '<?php echo $current_theme; ?>';
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
            const themeIcon = document.getElementById('themeIcon');
            const themeText = document.getElementById('themeText');
            if (themeIcon && themeText) {
                themeIcon.textContent = '☀️';
                themeText.textContent = 'Light Mode';
            }
        }
    });
</script>
