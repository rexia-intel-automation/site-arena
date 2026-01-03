<?php
/**
 * Sidebar - Menu Lateral do Painel Administrativo
 */

// Detectar página atual para marcar item ativo
$currentPage = basename($_SERVER['PHP_SELF']);
$currentDir = basename(dirname($_SERVER['PHP_SELF']));

function isActive($page, $dir = null) {
    global $currentPage, $currentDir;
    if ($dir) {
        return $currentDir === $dir ? 'active' : '';
    }
    return $currentPage === $page ? 'active' : '';
}
?>

<aside class="admin-sidebar">
    <div class="sidebar-header">
        <a href="/admin/index.php" class="sidebar-logo">
            Arena BRB
        </a>
        <p class="sidebar-subtitle">Painel Administrativo</p>
    </div>

    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <div class="nav-section">
            <a href="/admin/index.php" class="nav-link <?= isActive('index.php') ?>">
                <span class="nav-icon">📊</span>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Gestão de Conteúdo -->
        <div class="nav-section">
            <div class="nav-section-title">Conteúdo</div>

            <a href="/admin/eventos/index.php" class="nav-link <?= isActive(null, 'eventos') ?>">
                <span class="nav-icon">📅</span>
                <span>Eventos</span>
            </a>

            <a href="/admin/noticias/index.php" class="nav-link <?= isActive(null, 'noticias') ?>">
                <span class="nav-icon">📰</span>
                <span>Notícias</span>
            </a>
        </div>

        <!-- Configurações -->
        <div class="nav-section">
            <div class="nav-section-title">Configurações</div>

            <a href="/admin/categorias/index.php" class="nav-link <?= isActive(null, 'categorias') ?>">
                <span class="nav-icon">🏷️</span>
                <span>Categorias</span>
            </a>

            <a href="/admin/locais/index.php" class="nav-link <?= isActive(null, 'locais') ?>">
                <span class="nav-icon">📍</span>
                <span>Locais</span>
            </a>

            <a href="/admin/galeria/index.php" class="nav-link <?= isActive(null, 'galeria') ?>">
                <span class="nav-icon">📸</span>
                <span>Galeria</span>
            </a>
        </div>

        <!-- Usuários -->
        <?php if ($ADMIN_NIVEL === 'admin'): ?>
        <div class="nav-section">
            <div class="nav-section-title">Sistema</div>

            <a href="/admin/usuarios/index.php" class="nav-link <?= isActive(null, 'usuarios') ?>">
                <span class="nav-icon">👤</span>
                <span>Usuários</span>
            </a>
        </div>
        <?php endif; ?>

        <!-- Sair -->
        <div class="nav-section">
            <a href="/" class="nav-link" target="_blank">
                <span class="nav-icon">🌐</span>
                <span>Ver Site</span>
            </a>

            <a href="/admin/logout.php" class="nav-link">
                <span class="nav-icon">🚪</span>
                <span>Sair</span>
            </a>
        </div>
    </nav>
</aside>
