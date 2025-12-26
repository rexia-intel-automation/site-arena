<?php
/**
 * Script para deletar o arquivo reset-senha.php
 */

$arquivoReset = __DIR__ . '/reset-senha.php';
$arquivoDelete = __DIR__ . '/delete-reset.php';

echo "<h1>🗑️ Deletar Arquivo de Reset</h1>";

if (file_exists($arquivoReset)) {
    if (unlink($arquivoReset)) {
        echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 8px;'>";
        echo "<h2>✅ Arquivo reset-senha.php deletado com sucesso!</h2>";
        echo "<p>O arquivo de reset foi removido por segurança.</p>";
        echo "</div>";
    } else {
        echo "<div style='background: #fff3cd; color: #856404; padding: 20px; border-radius: 8px;'>";
        echo "<h2>⚠️ Não foi possível deletar automaticamente</h2>";
        echo "<p>Delete manualmente o arquivo <code>reset-senha.php</code> via FTP ou painel de controle.</p>";
        echo "</div>";
    }
} else {
    echo "<div style='background: #d1ecf1; color: #0c5460; padding: 20px; border-radius: 8px;'>";
    echo "<h2>ℹ️ Arquivo já foi deletado</h2>";
    echo "<p>O arquivo reset-senha.php não existe mais.</p>";
    echo "</div>";
}

// Auto-deletar este arquivo também
echo "<hr>";
echo "<h3>🔒 Auto-deletar este arquivo?</h3>";
echo "<p>Este arquivo (delete-reset.php) também deve ser removido.</p>";

if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    if (unlink($arquivoDelete)) {
        echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 8px;'>";
        echo "<h2>✅ Tudo limpo!</h2>";
        echo "<p>Ambos os arquivos foram deletados com sucesso.</p>";
        echo "<p><a href='/admin/login.php'>Ir para Login Admin</a></p>";
        echo "</div>";
    }
} else {
    echo "<a href='?confirm=yes' style='display: inline-block; background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;'>Deletar delete-reset.php também</a>";
}
?>

<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background: #f5f5f5;
    }
    h1 { color: #333; }
    code {
        background: #f4f4f4;
        padding: 2px 6px;
        border-radius: 3px;
    }
    a {
        color: #667eea;
        text-decoration: none;
        font-weight: bold;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
