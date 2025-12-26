<?php
/**
 * Verificação de Autenticação
 * Incluir no início de todas as páginas do admin
 */

// Iniciar sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se usuário está autenticado
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../admin/login.php');
    exit;
}

// Definir variáveis globais do usuário logado
$ADMIN_ID = $_SESSION['admin_id'];
$ADMIN_NOME = $_SESSION['admin_nome'] ?? 'Administrador';
$ADMIN_EMAIL = $_SESSION['admin_email'] ?? '';
$ADMIN_NIVEL = $_SESSION['admin_nivel'] ?? 'editor';

/**
 * Verificar nível de acesso requerido
 * @param string $nivelRequerido
 */
function requerNivel($nivelRequerido) {
    global $ADMIN_NIVEL;

    $niveis = [
        'moderador' => 1,
        'editor' => 2,
        'admin' => 3
    ];

    $nivelUsuario = $niveis[$ADMIN_NIVEL] ?? 0;
    $nivelNecessario = $niveis[$nivelRequerido] ?? 999;

    if ($nivelUsuario < $nivelNecessario) {
        header('Location: ../admin/index.php?erro=acesso_negado');
        exit;
    }
}
