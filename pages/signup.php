<?php
require_once '../config/config.php';
require_once '../classes/Auth.php';

// Redirect if already logged in
// Auth::redirectIfLoggedIn();

$error = '';
$success = '';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../classes/User.php';
    
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($fullName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = 'Please fill in all fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters';
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error = 'Password must include at least one uppercase letter';
    } elseif (!preg_match('/[a-z]/', $password)) {
        $error = 'Password must include at least one lowercase letter';
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error = 'Password must include at least one number';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } else {
        $user = new User();
        $result = $user->register($fullName, $email, $password);

        if ($result['success']) {
            $success = 'Registration successful! Redirecting to login...';
            header('refresh:2;url=index.php');
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
    <title>Sign Up - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="../css/signup.css">
</head>
<body>
    <div class="signup-container">
        <!-- Left Panel - Features -->
        <div class="features-panel">
            <div class="logo-section">
                <div class="logo-icon">🐛</div>
                <div class="logo-text">BugTracker</div>
            </div>

            <div class="features-section">
                <h3>Why Choose BugTracker?</h3>

                <div class="feature-item">
                    <div class="feature-icon">🐛</div>
                    <div class="feature-content">
                        <h4>Efficient Bug Tracking</h4>
                        <p>Log, prioritize, and manage issues with ease.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">👥</div>
                    <div class="feature-content">
                        <h4>Collaborative Teamwork</h4>
                        <p>Streamline communication and resolution across teams.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">📊</div>
                    <div class="feature-content">
                        <h4>Intuitive User Interface</h4>
                        <p>Navigate and interact effortlessly with a clean design.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">🎨</div>
                    <div class="feature-content">
                        <h4>High-Contrast Visuals</h4>
                        <p>Experience optimal readability and reduced eye strain.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">💡</div>
                    <div class="feature-content">
                        <h4>Smart Suggestions</h4>
                        <p>Get insights to resolve issues faster and smarter.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">✓</div>
                    <div class="feature-content">
                        <h4>Reliable Performance</h4>
                        <p>Count on a stable platform for your daily tasks.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Signup Form -->
        <div class="form-panel">
            <div class="signup-card">
                <div class="signup-header">
                    <h2>Create Your BugTracker Account</h2>
                    <p>Manage your tickets efficiently, track progress, and collaborate with your team.</p>
                </div>

                <?php if ($error): ?>
                    <div class="error-message">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="success-message">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" id="signupForm">
                    <div class="form-section">
                        <h3 class="section-title">Account Information</h3>

                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <div class="input-wrapper">
                                <span class="input-icon">👤</span>
                                <input 
                                    type="text" 
                                    id="full_name" 
                                    name="full_name" 
                                    placeholder="John Doe"
                                    value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-wrapper">
                                <span class="input-icon">📧</span>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    placeholder="john.doe@example.com"
                                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="section-title">Security Details</h3>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-wrapper">
                                <span class="input-icon">🔒</span>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Enter your password"
                                    required
                                >
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <div class="input-wrapper">
                                <span class="input-icon">🔒</span>
                                <input 
                                    type="password" 
                                    id="confirm_password" 
                                    name="confirm_password" 
                                    placeholder="Re-enter your password"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="register-button">Register</button>

                    <div class="login-link">
                        Already have an account? <a href="index.php">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/signup.js"></script>
</body>
</html>
