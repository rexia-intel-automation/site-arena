<?php
/**
 * Logout do Painel Administrativo
 */

session_start();

// Registrar log de logout antes de destruir a sessão
if (isset($_SESSION['admin_id'])) {
    require_once '../config/database.php';
    require_once '../includes/db/Database.php';
    require_once '../includes/helpers/security.php';

    registrarLog($_SESSION['admin_id'], 'logout', null, null, 'Logout realizado');
}

// Destruir todas as variáveis de sessão
$_SESSION = [];

// Destruir o cookie de sessão
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destruir a sessão
session_destroy();

// Redirecionar para login
header('Location: login.php');
exit;
