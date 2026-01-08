<?php
require_once 'config/config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$tickets = [
    [
        'title' => 'Login button not working',
        'description' => 'The login button on the main page is unresponsive. Users are unable to click it or it takes several seconds to respond.',
        'category' => 'frontend',
        'priority' => 'high',
        'status' => 'open'
    ],
    [
        'title' => 'Add dark mode support',
        'description' => 'Users have requested the ability to switch to a dark theme for better visibility in low-light environments.',
        'category' => 'frontend',
        'priority' => 'medium',
        'status' => 'open'
    ],
    [
        'title' => 'Fix dashboard performance issue',
        'description' => 'The dashboard takes too long to load when there are many tickets. Need to optimize the database queries.',
        'category' => 'backend',
        'priority' => 'critical',
        'status' => 'in_progress'
    ],
    [
        'title' => 'API endpoint returning 500 errors',
        'description' => 'The /api/tickets endpoint is randomly returning 500 errors. Need to debug server logs.',
        'category' => 'backend',
        'priority' => 'critical',
        'status' => 'open'
    ],
    [
        'title' => 'Database connection timeout',
        'description' => 'Connection to MySQL database times out during peak hours. Need to increase pool size.',
        'category' => 'infrastructure',
        'priority' => 'high',
        'status' => 'in_progress'
    ],
    [
        'title' => 'Fix responsive layout on mobile',
        'description' => 'Dashboard layout breaks on mobile devices. Elements overflow and text is misaligned.',
        'category' => 'frontend',
        'priority' => 'high',
        'status' => 'open'
    ],
    [
        'title' => 'Setup SSL certificate',
        'description' => 'Configure SSL/TLS certificate for production server to ensure secure HTTPS connections.',
        'category' => 'infrastructure',
        'priority' => 'medium',
        'status' => 'closed'
    ],
    [
        'title' => 'Optimize image loading',
        'description' => 'Implement lazy loading for images to reduce initial page load time.',
        'category' => 'frontend',
        'priority' => 'medium',
        'status' => 'open'
    ],
    [
        'title' => 'Add user authentication logs',
        'description' => 'Implement logging for failed login attempts for security audit purposes.',
        'category' => 'backend',
        'priority' => 'medium',
        'status' => 'open'
    ],
    [
        'title' => 'Setup monitoring and alerting',
        'description' => 'Implement Prometheus and Grafana for system monitoring and automatic alerts.',
        'category' => 'infrastructure',
        'priority' => 'medium',
        'status' => 'open'
    ]
];

$inserted = 0;

foreach ($tickets as $ticket) {
    $stmt = $conn->prepare("INSERT INTO tickets (title, description, category, priority, status, reporter_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, 1, NOW(), NOW())");
    $stmt->bind_param("sssss", $ticket['title'], $ticket['description'], $ticket['category'], $ticket['priority'], $ticket['status']);
    
    if ($stmt->execute()) {
        $inserted++;
    }
}

$conn->close();

if ($inserted === 10) {
    echo '<h2 style="color: green; text-align: center; margin-top: 50px;">✓ 10 test tickets inserted successfully!</h2>';
    echo '<p style="text-align: center; margin-top: 20px;"><a href="pages/dashboard.php">Go to Dashboard</a></p>';
} else {
    echo '<h2 style="color: red; text-align: center; margin-top: 50px;">✗ Error inserting tickets (inserted: ' . $inserted . ')</h2>';
}
?>
