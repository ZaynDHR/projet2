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
        'category' => 'bug',
        'priority' => 'high',
        'status' => 'open'
    ],
    [
        'title' => 'Add dark mode support',
        'description' => 'Users have requested the ability to switch to a dark theme for better visibility in low-light environments.',
        'category' => 'feature',
        'priority' => 'medium',
        'status' => 'open'
    ],
    [
        'title' => 'Fix dashboard performance issue',
        'description' => 'The dashboard takes too long to load when there are many tickets. Need to optimize the database queries.',
        'category' => 'improvement',
        'priority' => 'critical',
        'status' => 'in_progress'
    ]
];

$inserted = 0;

foreach ($tickets as $ticket) {
    $title = $conn->real_escape_string($ticket['title']);
    $description = $conn->real_escape_string($ticket['description']);
    $category = $conn->real_escape_string($ticket['category']);
    $priority = $conn->real_escape_string($ticket['priority']);
    $status = $conn->real_escape_string($ticket['status']);
    
    $sql = "INSERT INTO tickets (title, description, category, priority, status, reporter_id, created_at, updated_at) 
            VALUES ('$title', '$description', '$category', '$priority', '$status', 1, NOW(), NOW())";
    
    if ($conn->query($sql) === TRUE) {
        $inserted++;
    }
}

$conn->close();

if ($inserted === 3) {
    echo '<h2 style="color: green; text-align: center; margin-top: 50px;">✓ 3 test tickets inserted successfully!</h2>';
    echo '<p style="text-align: center; margin-top: 20px;"><a href="pages/dashboard.php">Go to Dashboard</a></p>';
} else {
    echo '<h2 style="color: red; text-align: center; margin-top: 50px;">✗ Error inserting tickets</h2>';
}
?>
