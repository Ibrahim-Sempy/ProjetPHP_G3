<?php

class Auth {
    public static function isLoggedIn() {
        return isset($_SESSION['voter_id']);
    }

    public static function isAdmin() {
        return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: index.php?page=login');
            exit();
        }
    }

    public static function requireAdmin() {
        if (!self::isAdmin()) {
            header('Location: index.php?page=home');
            exit();
        }
    }
}