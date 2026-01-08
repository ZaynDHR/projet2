<?php
require_once 'Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function register($fullName, $email, $password) {
        // Check if user exists
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return ['success' => false, 'message' => 'Email already registered'];
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $fullName, $email, $hashedPassword);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Registration successful'];
        } else {
            return ['success' => false, 'message' => 'Registration failed'];
        }
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }

        $user = $result->fetch_assoc();
        
        // Verify hashed password
        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }

        // Set session (remove password from user data)
        $userData = ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']];
        Auth::login($user['id'], $userData);

        return ['success' => true, 'message' => 'Login successful'];
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT id, name, email FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
