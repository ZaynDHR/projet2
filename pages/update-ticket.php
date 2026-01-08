<?php
require_once '../config/config.php';
require_once '../classes/Auth.php';
require_once '../classes/Ticket.php';

Auth::requireAuth();

$ticketId = $_POST['id'] ?? null;
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$status = $_POST['status'] ?? '';
$priority = $_POST['priority'] ?? '';

if (!$ticketId || empty($title) || empty($description)) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

$ticket = new Ticket();
$result = $ticket->updateTicket([
    'id' => $ticketId,
    'title' => $title,
    'description' => $description,
    'status' => $status,
    'priority' => $priority
]);

header('Content-Type: application/json');
echo json_encode($result);
?>
