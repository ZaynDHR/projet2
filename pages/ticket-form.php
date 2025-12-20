<?php
require_once '../config/config.php';
require_once '../classes/Auth.php';
require_once '../classes/Ticket.php';

// Require authentication
Auth::requireAuth();

$currentUser = Auth::getUser();
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = $_POST['category'] ?? 'bug';
    $priority = $_POST['priority'] ?? 'medium';

    if (empty($title) || empty($description)) {
        $error = 'Please fill in all required fields';
    } else {
        $ticket = new Ticket();
        $result = $ticket->createTicket([
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'priority' => $priority,
            'reporter_id' => $currentUser['id']
        ]);

        if ($result['success']) {
            $success = 'Ticket created successfully!';
            header('refresh:2;url=dashboard.php');
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
    <title>Create Ticket - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="../css/ticket-form.css">
</head>
<body>
    <div class="form-layout">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="dashboard-header">
                <div class="header-logo">
                     <div class="logo-text">BugTracker</div>
                 </div>
                 <div class="header-actions">
                      <a href="dashboard.php" class="icon-button" title="Back to Dashboard">⬅</a>
                  </div>
            </header>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-card">
                    <div class="form-title">
                        <h1>Bug Ticket Form</h1>
                    </div>

                    <?php if ($error): ?>
                        <div style="padding: 16px 40px;">
                            <div class="error-message">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div style="padding: 16px 40px;">
                            <div style="background: #e8f7f5; color: #00897b; padding: 14px 16px; border-radius: 8px; font-size: 14px; border-left: 4px solid #5dd9c1; display: flex; align-items: center; gap: 8px;">
                                <span style="font-weight: bold;">✓</span>
                                <?php echo htmlspecialchars($success); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="form-layout-inner">
                        <!-- Steps Sidebar -->
                        <div class="steps-sidebar">
                            <div class="step-item active">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h3>Essential Information</h3>
                                </div>
                            </div>


                        </div>

                        <!-- Form Content -->
                        <div class="form-content">
                            <form method="POST" action="" id="ticketForm">
                                <div class="step-header">
                                    <h2>Step 1: Essential Information</h2>
                                </div>

                                <div class="form-fields">
                                    <div class="form-group">
                                        <label for="title">Ticket Title</label>
                                        <input 
                                            type="text" 
                                            id="title" 
                                            name="title" 
                                            placeholder="API performance degradation"
                                            value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>"
                                            required
                                        >
                                        <span class="form-hint">A concise summary of the issue.</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Short Description</label>
                                        <textarea 
                                            id="description" 
                                            name="description" 
                                            placeholder="Users are reporting slow loading times when fetching data. This affects dashboard loading and ticket detail views. Needs urgent attention."
                                            required
                                        ><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
                                        <span class="form-hint">Briefly describe the bug and its impact.</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select id="category" name="category" required>
                                            <option value="bug" <?php echo (($_POST['category'] ?? 'bug') === 'bug') ? 'selected' : ''; ?>>Bug</option>
                                            <option value="feature" <?php echo (($_POST['category'] ?? '') === 'feature') ? 'selected' : ''; ?>>Feature Request</option>
                                            <option value="improvement" <?php echo (($_POST['category'] ?? '') === 'improvement') ? 'selected' : ''; ?>>Improvement</option>
                                        </select>
                                        <span class="form-hint">Classify the type of issue.</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="priority">Priority</label>
                                        <select id="priority" name="priority" required>
                                            <option value="low" <?php echo (($_POST['priority'] ?? '') === 'low') ? 'selected' : ''; ?>>Low</option>
                                            <option value="medium" <?php echo (($_POST['priority'] ?? 'medium') === 'medium') ? 'selected' : ''; ?>>Medium</option>
                                            <option value="high" <?php echo (($_POST['priority'] ?? '') === 'high') ? 'selected' : ''; ?>>High</option>
                                            <option value="critical" <?php echo (($_POST['priority'] ?? '') === 'critical') ? 'selected' : ''; ?>>Critical</option>
                                        </select>
                                        <span class="form-hint">How critical is this issue?</span>
                                    </div>
                                </div>

                                <button type="submit" class="save-button">Save Ticket</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/ticket-form.js"></script>
</body>
</html>
