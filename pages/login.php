<?php
require_once '../config/config.php';
require_once '../classes/Auth.php';

// Redirect if already logged in
// Auth::redirectIfLoggedIn();

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../classes/User.php';
    
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $user = new User();
        $result = $user->login($email, $password);

        if ($result['success']) {
            header('Location: dashboard.php');
            exit();
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login-container">
         <!-- Login Form -->
         <div class="login-panel">
            <div class="login-card">
                <h2>Welcome Back</h2>

                <?php if ($error): ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="your.email@example.com"
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="••••••••"
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Toggle password visibility">
                                👁️
                            </button>
                        </div>
                    </div>

                    <div class="forgot-password">
                        <a href="forgot-password.php">Forgot password?</a>
                    </div>

                    <button type="submit" class="login-button">Login</button>

                    <div class="signup-link">
                        Don't have an account? <a href="signup.php">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/login.js"></script>
</body>
</html>
