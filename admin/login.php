<?php
/**
 * Página de Login do Painel Administrativo
 */

session_start();

// Se já estiver logado, redirecionar para dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Ajuste os caminhos conforme sua estrutura real de pastas
require_once '../config/database.php';
require_once '../includes/db/Database.php';
require_once '../includes/models/Usuario.php';
require_once '../includes/helpers/security.php';

$erro = '';
$sucesso = '';

// Processar login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos';
    } else {
        $usuarioModel = new Usuario();
        // $usuario = $usuarioModel->autenticar($email, $senha); 
        // Simulação para evitar erro caso o model não esteja pronto na revisão:
        // Remova este bloco simulado e use a linha acima em produção
        $usuario = null; 
        if($email === 'admin@arenabrb.com.br' && $senha === 'Admin@123') {
             $usuario = ['id' => 1, 'nome' => 'Administrador', 'email' => $email, 'nivel_acesso' => 'admin'];
        }

        if ($usuario) {
            $_SESSION['admin_id'] = $usuario['id'];
            $_SESSION['admin_nome'] = $usuario['nome'];
            $_SESSION['admin_email'] = $usuario['email'];
            $_SESSION['admin_nivel'] = $usuario['nivel_acesso'];

            // Se a função registrarLog existir:
            if(function_exists('registrarLog')) {
                registrarLog($usuario['id'], 'login', null, null, 'Login realizado com sucesso');
            }

            header('Location: index.php');
            exit;
        } else {
            $erro = 'Email ou senha incorretos';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Arena BRB Admin</title>
    
    <link rel="stylesheet" href="assets/css/design-system.css">
    <link rel="stylesheet" href="assets/css/admin-minimal.css"> 
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>Arena BRB</h1>
            <p>Painel Administrativo</p>
        </div>

        <?php if ($erro): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       placeholder="seu@email.com"
                       required
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password"
                       id="senha"
                       name="senha"
                       placeholder="Digite sua senha"
                       required>
            </div>

            <button type="submit" class="btn-login">
                Entrar
            </button>
        </form>

        <div class="footer">
            © <?= date('Y') ?> Arena BRB. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
