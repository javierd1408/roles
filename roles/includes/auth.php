<?php
// includes/auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin() {
    if (!isset($_SESSION['username'], $_SESSION['rol'])) {
        header("Location: access_denied.php?reason=login");
        exit();
    }
}

function requireRole($allowedRoles = []) {
    requireLogin(); // asegúrate que haya sesión
    if (!in_array($_SESSION['rol'], $allowedRoles, true)) {
        header("Location: access_denied.php?reason=rol");
        exit();
    }
}
