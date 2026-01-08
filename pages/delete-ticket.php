<?php
require_once '../config/config.php';
require_once '../classes/Auth.php';
require_once '../classes/Ticket.php';

Auth::requireAuth();

$ticketId = $_GET['id'] ?? null;

if (!$ticketId) {
    echo json_encode(['success' => false, 'message' => 'No ticket ID provided']);
    exit;
}

$ticket = new Ticket();
$result = $ticket->deleteTicket($ticketId);

header('Content-Type: application/json');
echo json_encode($result);
?>
