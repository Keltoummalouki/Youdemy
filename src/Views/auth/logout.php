<?php
require_once '../../../vendor/autoload.php';

use App\Services\SessionManager;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

session_destroy();

header('Location: ./login.php');
exit();