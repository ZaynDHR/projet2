<?php
class Auth {
    public static function requireAuth() {
        if (!self::isLoggedIn()) {
            header('Location: login.php');
            exit();
        }
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public static function getUser() {
        if (self::isLoggedIn() && isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        return null;
    }

    public static function login($userId, $userData) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['user'] = $userData;
    }

    public static function logout() {
        session_destroy();
        header('Location: login.php');
        exit();
    }

    public static function redirectIfLoggedIn() {
        if (self::isLoggedIn()) {
            header('Location: dashboard.php');
            exit();
        }
    }
}
?>
