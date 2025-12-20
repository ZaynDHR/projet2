<?php
require_once 'Database.php';

class Ticket {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createTicket($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO tickets (title, description, category, priority, reporter_id, status, created_at, updated_at) 
             VALUES (?, ?, ?, ?, ?, 'open', NOW(), NOW())"
        );

        $stmt->bind_param(
            "ssssi",
            $data['title'],
            $data['description'],
            $data['category'],
            $data['priority'],
            $data['reporter_id']
        );

        if ($stmt->execute()) {
            return ['success' => true, 'id' => $stmt->insert_id];
        } else {
            return ['success' => false, 'message' => 'Failed to create ticket'];
        }
    }

    public function getTickets($filters = []) {
        $sql = "SELECT t.*, u.name as reporter_name, a.name as assignee_name, 
                CONCAT('BUG-', LPAD(t.id, 4, '0')) as ticket_id
                FROM tickets t 
                LEFT JOIN users u ON t.reporter_id = u.id 
                LEFT JOIN users a ON t.assignee_id = a.id 
                WHERE 1=1";

        if (isset($filters['status'])) {
            $sql .= " AND t.status = '" . $this->db->escape_string($filters['status']) . "'";
        }

        if (isset($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        } else {
            $sql .= " LIMIT 50";
        }

        $result = $this->db->query($sql);
        $tickets = [];

        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }

        return $tickets;
    }

    public function getStatistics() {
        $stats = [
            'total' => 0,
            'open' => 0,
            'in_progress' => 0,
            'closed' => 0
        ];

        $result = $this->db->query("SELECT COUNT(*) as count FROM tickets");
        $row = $result->fetch_assoc();
        $stats['total'] = $row['count'];

        $result = $this->db->query("SELECT COUNT(*) as count FROM tickets WHERE status = 'open'");
        $row = $result->fetch_assoc();
        $stats['open'] = $row['count'];

        $result = $this->db->query("SELECT COUNT(*) as count FROM tickets WHERE status = 'in_progress'");
        $row = $result->fetch_assoc();
        $stats['in_progress'] = $row['count'];

        $result = $this->db->query("SELECT COUNT(*) as count FROM tickets WHERE status = 'closed'");
        $row = $result->fetch_assoc();
        $stats['closed'] = $row['count'];

        return $stats;
    }

    public function getRecentActivity($limit = 10) {
        $sql = "SELECT t.id, t.title as ticket_title, t.description, u.name as user_name, 'opened' as action,
                CONCAT('BUG-', LPAD(t.id, 4, '0')) as ticket_id, t.created_at
                FROM tickets t 
                LEFT JOIN users u ON t.reporter_id = u.id 
                ORDER BY t.created_at DESC 
                LIMIT " . (int)$limit;

        $result = $this->db->query($sql);
        $activities = [];

        while ($row = $result->fetch_assoc()) {
            $row['description'] = substr($row['description'], 0, 50) . '...';
            $activities[] = $row;
        }

        return $activities;
    }

    public function getTicketById($id) {
        $stmt = $this->db->prepare(
            "SELECT t.*, u.name as reporter_name, a.name as assignee_name,
                    CONCAT('BUG-', LPAD(t.id, 4, '0')) as ticket_id
             FROM tickets t 
             LEFT JOIN users u ON t.reporter_id = u.id 
             LEFT JOIN users a ON t.assignee_id = a.id 
             WHERE t.id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
