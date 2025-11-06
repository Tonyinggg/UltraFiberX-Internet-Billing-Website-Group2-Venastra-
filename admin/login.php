<?php
require_once '../config.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error_message = '';
$max_attempts = 5;
$lockout_time = 300; // 5 minutes

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

function validatePassword($password) {
    $errors = [];
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters long";
    if (strlen($password) > 16) $errors[] = "Password must not exceed 16 characters";
    if (!preg_match('/[0-9]/', $password)) $errors[] = "Password must contain at least one number";
    if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};:\'",.<>?\/\\|`~]/', $password))
        $errors[] = "Password must contain at least one special character (!@#$%^&* etc.)";
    return $errors;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pdo = getDBConnection();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Check rate limiting
    if ($_SESSION['login_attempts'] >= $max_attempts && (time() - $_SESSION['last_attempt_time']) < $lockout_time) {
        $remaining = ceil(($lockout_time - (time() - $_SESSION['last_attempt_time'])) / 60);
        $error_message = "Too many failed attempts. Try again after {$remaining} minute(s).";
    } else {
        if (empty($username) || empty($password)) {
            $error_message = 'Please enter both username and password.';
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
                $stmt->execute([$username]);
                $admin = $stmt->fetch();

                if ($admin && password_verify($password, $admin['password'])) {
                    // Successful login
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_email'] = $admin['email'];

                    $update_stmt = $pdo->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
                    $update_stmt->execute([$admin['id']]);

                    $_SESSION['login_attempts'] = 0;
                    header('Location: dashboard.php');
                    exit;
                } else {
                    // Failed login
                    $_SESSION['login_attempts']++;
                    $_SESSION['last_attempt_time'] = time();
                    $error_message = 'Invalid username or password.';
                }

            } catch (Exception $e) {
                error_log("Login error: " . $e->getMessage());
                $error_message = 'Login failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - UltraFiberX</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(135deg, #264229 0%, #2e7d32 100%);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
            color: white;
        }
        .login-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.5);
        }
        .login-header p {
            margin: 0.5rem 0 0 0;
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .login-form {
            background: white;
            padding: 3rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
        }
        .login-form h2 {
            text-align: center;
            color: #264229;
            margin-bottom: 1.5rem;
        }
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        .form-group input:focus {
            outline: none;
            border-color: #264229;
        }
        .toggle-password {
            position: absolute;
            top: 70%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #555;
            font-size: 1.2rem;
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background: #264229;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
            margin-bottom: 1rem;
        }
        .login-btn:hover {
            background: #1a2e1c;
        }
        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 0.75rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }
        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 0.75rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }
        .back-link {
            text-align: center;
        }
        .back-btn {
            width: 100%;
            display: inline-block;
            color: white;
            text-decoration: none;
            padding: 1rem;
            background: #6c757d;
            border: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
            text-align: center;
            box-sizing: border-box;
        }
        .back-btn:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .forgot-password-link {
            text-align: center;
            margin-top: 1rem;
        }
        .forgot-password-link a {
            color: #264229;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .forgot-password-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Ultra Fiber X</h1>
            <p>High-Speed Internet Solutions</p>
        </div>
        
        <form class="login-form" method="POST">
            <h2>Admin Login</h2>

            <!-- ✅ Logout Confirmation -->
            <?php if (isset($_SESSION['logout_message'])): ?>
                <div class="success-message"><?php echo htmlspecialchars($_SESSION['logout_message']); ?></div>
                <?php unset($_SESSION['logout_message']); ?>
            <?php endif; ?>

            <!-- ❌ Error Message -->
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required value="<?php echo htmlspecialchars($username ?? ''); ?>">
            </div>
            
            <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" id="password" required>
            <i class="fa-solid fa-eye-slash toggle-password" id="togglePassword"></i>
            </div>


            
            <button type="submit" class="login-btn"><b>Login</b></button>

            <div class="forgot-password-link">
                <a href="password_reset.php">Forgot your password?</a>
            </div>

            <div class="back-link" style="margin-top: 1.5rem;">
                <a href="../index.php" class="back-btn">Back to Website</a>
            </div>
        </form>
    </div>

    <!-- ✅ JavaScript for Show/Hide Password -->
    <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        const isPassword = passwordField.type === 'password';
        passwordField.type = isPassword ? 'text' : 'password';
        togglePassword.classList.toggle('fa-eye');
        togglePassword.classList.toggle('fa-eye-slash');
        });
    </script>

</body>
</html>
