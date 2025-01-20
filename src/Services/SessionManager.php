<?php
namespace App\Services;

class SessionManager {
    
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function isLoggedIn() {
        self::startSession();
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public static function requireAuth() {
        self::startSession();
        if (!self::isLoggedIn()) {
            header('Location: /auth/login.php');
            exit();
        }
    }
    
    public static function setUser($userId, $username, $role) {
        self::startSession();
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
    }

    public static function getUser() {
        self::startSession();
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? null,
            'role' => $_SESSION['role'] ?? null
        ];
    }

    public static function logout() {
        self::startSession();
        session_unset();
        session_destroy();
        header('Location: /auth/login.php');
        exit();
    }

    public static function checkRole($allowedRoles) {
        self::startSession();
        if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowedRoles)) {
            header('Location: /error.php?message=unauthorized');
            exit();
        }
    }
}