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

// Incluir configurações e classes
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
        $usuario = $usuarioModel->autenticar($email, $senha);

        if ($usuario) {
            // Definir variáveis de sessão
            $_SESSION['admin_id'] = $usuario['id'];
            $_SESSION['admin_nome'] = $usuario['nome'];
            $_SESSION['admin_email'] = $usuario['email'];
            $_SESSION['admin_nivel'] = $usuario['nivel_acesso'];

            // Registrar log de login
            registrarLog($usuario['id'], 'login', null, null, 'Login realizado com sucesso');

            // Redirecionar para dashboard
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 420px;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h1 {
            font-size: 28px;
            color: #667eea;
            margin-bottom: 5px;
        }

        .logo p {
            color: #6c757d;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
            font-size: 13px;
        }

        .credentials-hint {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 13px;
            color: #6c757d;
            border-left: 3px solid #667eea;
        }

        .credentials-hint strong {
            color: #333;
        }
    </style>
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

        <?php if ($sucesso): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($sucesso) ?>
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

        <div class="credentials-hint">
            <strong>Credenciais padrão:</strong><br>
            Email: admin@arenabrb.com.br<br>
            Senha: Admin@123<br>
            <small>⚠️ Altere após o primeiro login!</small>
        </div>

        <div class="footer">
            © <?= date('Y') ?> Arena BRB. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
