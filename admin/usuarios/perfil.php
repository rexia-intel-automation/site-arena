<?php
/**
 * Editar Próprio Perfil
 * Qualquer usuário logado pode acessar
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Usuario.php';
require_once '../../includes/helpers/security.php';

$pageTitle = 'Meu Perfil';

$usuarioModel = new Usuario();

// Buscar dados do usuário logado
$usuario = $usuarioModel->getById($ADMIN_ID);

$erros = [];
$sucesso = false;
$dados = $usuario;

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF
    if (!verificarCSRFToken($_POST['csrf_token'] ?? '')) {
        $erros[] = 'Token de segurança inválido';
    } else {
        // Dados do formulário
        $dados = [
            'nome' => sanitizeString($_POST['nome'] ?? ''),
            'email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
            'senha_atual' => $_POST['senha_atual'] ?? '',
            'senha_nova' => $_POST['senha_nova'] ?? '',
            'senha_nova_confirma' => $_POST['senha_nova_confirma'] ?? '',
            'nivel_acesso' => $usuario['nivel_acesso'], // Mantém o atual
            'ativo' => 1 // Sempre ativo
        ];

        // Validações
        if (empty($dados['nome'])) {
            $erros[] = 'Nome é obrigatório';
        }

        if (strlen($dados['nome']) > 255) {
            $erros[] = 'Nome deve ter no máximo 255 caracteres';
        }

        if (empty($dados['email'])) {
            $erros[] = 'Email é obrigatório';
        } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'Email inválido';
        } elseif ($usuarioModel->emailExiste($dados['email'], $ADMIN_ID)) {
            $erros[] = 'Este email já está cadastrado';
        }

        // Se está alterando senha
        if (!empty($dados['senha_nova'])) {
            // Precisa fornecer senha atual
            if (empty($dados['senha_atual'])) {
                $erros[] = 'Para alterar a senha, você deve fornecer sua senha atual';
            } else {
                // Verificar senha atual
                $db = Database::getInstance()->getConnection();
                $stmt = $db->prepare("SELECT senha_hash FROM usuarios_admin WHERE id = :id");
                $stmt->execute(['id' => $ADMIN_ID]);
                $senhaHash = $stmt->fetch()['senha_hash'];

                if (!password_verify($dados['senha_atual'], $senhaHash)) {
                    $erros[] = 'Senha atual incorreta';
                }
            }

            // Validar nova senha
            if (strlen($dados['senha_nova']) < 8) {
                $erros[] = 'Nova senha deve ter no mínimo 8 caracteres';
            } elseif (!preg_match('/[A-Z]/', $dados['senha_nova'])) {
                $erros[] = 'Nova senha deve conter pelo menos uma letra maiúscula';
            } elseif (!preg_match('/[a-z]/', $dados['senha_nova'])) {
                $erros[] = 'Nova senha deve conter pelo menos uma letra minúscula';
            } elseif (!preg_match('/[0-9]/', $dados['senha_nova'])) {
                $erros[] = 'Nova senha deve conter pelo menos um número';
            }

            // Confirmar nova senha
            if ($dados['senha_nova'] !== $dados['senha_nova_confirma']) {
                $erros[] = 'As senhas não coincidem';
            }

            // Se tudo ok, usar a nova senha
            if (empty($erros)) {
                $dados['senha'] = $dados['senha_nova'];
            }
        }

        // Atualizar perfil
        if (empty($erros)) {
            try {
                $usuarioModel->atualizar($ADMIN_ID, $dados);

                // Registrar log
                registrarLog($ADMIN_ID, 'atualizar', 'usuarios_admin', $ADMIN_ID, 'Perfil atualizado');

                $sucesso = true;
                // Recarregar dados
                $usuario = $usuarioModel->getById($ADMIN_ID);
                $dados = $usuario;
            } catch (Exception $e) {
                $erros[] = $e->getMessage();
            }
        }
    }
}

$csrfToken = gerarCSRFToken();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - Arena BRB Admin</title>
    <link rel="stylesheet" href="assets/css/design-system.css">
    <link rel="stylesheet" href="/admin/assets/css/admin.css">
    <link rel="stylesheet" href="/admin/assets/css/admin-minimal.css">
    <style>
        .password-strength {
            margin-top: 0.5rem;
            padding: 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
            display: none;
        }
        .password-strength.weak {
            background: #fee2e2;
            color: #991b1b;
            display: block;
        }
        .password-strength.medium {
            background: #fef3c7;
            color: #92400e;
            display: block;
        }
        .password-strength.strong {
            background: #d1fae5;
            color: #065f46;
            display: block;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        <?php include '../includes/header.php'; ?>

        <main class="admin-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Meu Perfil</h2>
                    <a href="/admin/index.php" class="btn btn-secondary">
                        ← Voltar ao Dashboard
                    </a>
                </div>

                <div class="card-body">
                    <?php if ($sucesso): ?>
                        <div class="alert alert-success">
                            ✓ Perfil atualizado com sucesso!
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($erros)): ?>
                        <div class="alert alert-error">
                            <strong>❌ Erro ao atualizar perfil:</strong>
                            <ul style="margin: 0.5rem 0 0 1.5rem;">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="admin-form">
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                        <!-- Informações Básicas -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">📝 Informações Pessoais</h3>

                        <div class="form-group">
                            <label for="nome" class="required">Nome Completo</label>
                            <input type="text"
                                   id="nome"
                                   name="nome"
                                   class="form-control"
                                   value="<?= htmlspecialchars($dados['nome'] ?? '') ?>"
                                   required
                                   maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="email" class="required">Email</label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control"
                                   value="<?= htmlspecialchars($dados['email'] ?? '') ?>"
                                   required
                                   maxlength="255">
                            <small class="form-help">Email será usado para login</small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Alterar Senha -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">🔒 Alterar Senha</h3>

                        <div class="alert alert-info" style="margin-bottom: 1rem;">
                            ℹ️ Para alterar sua senha, preencha os campos abaixo. Deixe em branco para manter a senha atual.
                        </div>

                        <div class="form-group">
                            <label for="senha_atual">Senha Atual</label>
                            <input type="password"
                                   id="senha_atual"
                                   name="senha_atual"
                                   class="form-control">
                            <small class="form-help">Digite sua senha atual para confirmar a alteração</small>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="senha_nova">Nova Senha</label>
                                <input type="password"
                                       id="senha_nova"
                                       name="senha_nova"
                                       class="form-control"
                                       minlength="8">
                                <div id="password-strength" class="password-strength"></div>
                                <small class="form-help">Mínimo 8 caracteres, 1 maiúscula, 1 minúscula, 1 número</small>
                            </div>

                            <div class="form-group">
                                <label for="senha_nova_confirma">Confirmar Nova Senha</label>
                                <input type="password"
                                       id="senha_nova_confirma"
                                       name="senha_nova_confirma"
                                       class="form-control"
                                       minlength="8">
                                <small class="form-help">Digite a nova senha novamente</small>
                            </div>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Informações da Conta -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">ℹ️ Informações da Conta</h3>

                        <div style="background: #f9fafb; padding: 1.5rem; border-radius: 6px;">
                            <div style="margin-bottom: 0.5rem;">
                                <strong>Nível de Acesso:</strong>
                                <?php
                                $nivelLabels = [
                                    'admin' => 'Admin',
                                    'editor' => 'Editor',
                                    'moderador' => 'Moderador'
                                ];
                                $nivelColors = [
                                    'admin' => '#dc2626',
                                    'editor' => '#2563eb',
                                    'moderador' => '#16a34a'
                                ];
                                ?>
                                <span class="badge" style="background-color: <?= $nivelColors[$usuario['nivel_acesso']] ?>; margin-left: 0.5rem;">
                                    <?= $nivelLabels[$usuario['nivel_acesso']] ?>
                                </span>
                            </div>
                            <div style="margin-bottom: 0.5rem;">
                                <strong>Conta criada em:</strong> <?= date('d/m/Y H:i', strtotime($usuario['criado_em'])) ?>
                            </div>
                            <?php if ($usuario['ultimo_login']): ?>
                                <div>
                                    <strong>Último login:</strong> <?= date('d/m/Y H:i', strtotime($usuario['ultimo_login'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Botões -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                ✓ Salvar Alterações
                            </button>
                            <a href="/admin/index.php" class="btn btn-secondary">
                                ❌ Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Validador de força de senha
        const senhaNovaInput = document.getElementById('senha_nova');
        const strengthDiv = document.getElementById('password-strength');

        senhaNovaInput.addEventListener('input', function() {
            const senha = this.value;
            let strength = 0;
            let message = '';

            if (senha.length >= 8) strength++;
            if (/[a-z]/.test(senha)) strength++;
            if (/[A-Z]/.test(senha)) strength++;
            if (/[0-9]/.test(senha)) strength++;
            if (/[^a-zA-Z0-9]/.test(senha)) strength++;

            strengthDiv.className = 'password-strength';

            if (senha.length === 0) {
                strengthDiv.style.display = 'none';
            } else if (strength <= 2) {
                strengthDiv.classList.add('weak');
                message = '❌ Senha fraca';
            } else if (strength <= 3) {
                strengthDiv.classList.add('medium');
                message = '⚠️ Senha média';
            } else {
                strengthDiv.classList.add('strong');
                message = '✓ Senha forte';
            }

            strengthDiv.textContent = message;
        });

        // Validar confirmação de senha
        const senhaConfirmaInput = document.getElementById('senha_nova_confirma');
        const form = document.querySelector('form');

        form.addEventListener('submit', function(e) {
            const senhaAtual = document.getElementById('senha_atual').value;
            const senhaNova = senhaNovaInput.value;
            const senhaConfirma = senhaConfirmaInput.value;

            // Se está tentando alterar senha
            if (senhaNova !== '' || senhaConfirma !== '') {
                // Precisa da senha atual
                if (senhaAtual === '') {
                    e.preventDefault();
                    alert('Digite sua senha atual para alterar a senha!');
                    document.getElementById('senha_atual').focus();
                    return;
                }

                // Senhas novas devem coincidir
                if (senhaNova !== senhaConfirma) {
                    e.preventDefault();
                    alert('As senhas não coincidem!');
                    senhaConfirmaInput.focus();
                }
            }
        });
    </script>
</body>
</html>
