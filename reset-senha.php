<?php
/**
 * Script de Reset de Senha do Administrador
 * Use este script APENAS para redefinir a senha em caso de emergência
 * APAGUE este arquivo após usar!
 */

require_once 'config/database.php';
require_once 'includes/db/Database.php';

echo "<h1>🔐 Reset de Senha - Arena BRB Admin</h1>";

try {
    $db = Database::getInstance()->getConnection();

    // Nova senha
    $novaSenha = 'Admin@123';
    $novoHash = password_hash($novaSenha, PASSWORD_DEFAULT);

    // Atualizar no banco de dados
    $sql = "UPDATE usuarios_admin
            SET senha_hash = :senha_hash
            WHERE email = 'admin@arenabrb.com.br'";

    $stmt = $db->prepare($sql);
    $result = $stmt->execute(['senha_hash' => $novoHash]);

    if ($result) {
        echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
        echo "<h2>✅ Senha redefinida com sucesso!</h2>";
        echo "<p><strong>Email:</strong> admin@arenabrb.com.br</p>";
        echo "<p><strong>Nova senha:</strong> Admin@123</p>";
        echo "<hr>";
        echo "<p><strong>⚠️ IMPORTANTE:</strong></p>";
        echo "<ol>";
        echo "<li>Faça login em <a href='/admin/login.php'>/admin/login.php</a></li>";
        echo "<li>Altere a senha imediatamente após o login</li>";
        echo "<li><strong style='color: red;'>DELETE este arquivo (reset-senha.php) por segurança!</strong></li>";
        echo "</ol>";
        echo "</div>";

        // Mostrar o hash gerado para debug
        echo "<details style='margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 4px;'>";
        echo "<summary style='cursor: pointer; font-weight: bold;'>🔍 Informações Técnicas (Debug)</summary>";
        echo "<pre style='background: #fff; padding: 10px; margin-top: 10px; overflow: auto;'>";
        echo "Hash gerado: " . htmlspecialchars($novoHash) . "\n";
        echo "Senha em texto: Admin@123\n";
        echo "\nVerificar hash:\n";
        $verify = password_verify('Admin@123', $novoHash);
        echo "password_verify('Admin@123', hash) = " . ($verify ? "✅ TRUE" : "❌ FALSE");
        echo "</pre>";
        echo "</details>";

    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px;'>";
        echo "<h2>❌ Erro ao atualizar senha</h2>";
        echo "</div>";
    }

} catch (Exception $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px;'>";
    echo "<h2>❌ Erro:</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
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
    h1 {
        color: #333;
        border-bottom: 3px solid #667eea;
        padding-bottom: 10px;
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
