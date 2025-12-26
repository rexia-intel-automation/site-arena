<?php
/**
 * Header do Painel Administrativo
 */

// Obter iniciais do nome do usuário
$iniciais = '';
if (!empty($ADMIN_NOME)) {
    $palavras = explode(' ', $ADMIN_NOME);
    foreach ($palavras as $palavra) {
        if (!empty($palavra)) {
            $iniciais .= mb_strtoupper(mb_substr($palavra, 0, 1));
            if (strlen($iniciais) >= 2) break;
        }
    }
}
?>

<header class="admin-header">
    <div class="header-left">
        <h1><?= $pageTitle ?? 'Dashboard' ?></h1>
    </div>

    <div class="header-right">
        <div class="user-info">
            <div class="user-avatar" title="<?= htmlspecialchars($ADMIN_NOME) ?>">
                <?= htmlspecialchars($iniciais) ?>
            </div>
            <div class="user-details">
                <span class="user-name"><?= htmlspecialchars($ADMIN_NOME) ?></span>
                <span class="user-role"><?= ucfirst($ADMIN_NIVEL) ?></span>
            </div>
        </div>

        <a href="/admin/logout.php" class="btn btn-sm btn-danger" title="Sair">
            Sair
        </a>
    </div>
</header>
