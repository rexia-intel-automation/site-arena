<?php
/**
 * Editar Usuário
 * RESTRIÇÃO: Apenas administradores
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Usuario.php';
require_once '../../includes/helpers/security.php';

// Verificar se é admin
if ($ADMIN_NIVEL !== 'admin') {
    header('Location: /admin/index.php?erro=sem_permissao');
    exit;
}

$pageTitle = 'Editar Usuário';

$usuarioModel = new Usuario();

// Validar ID
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /admin/usuarios/index.php');
    exit;
}

// Buscar usuário
$usuario = $usuarioModel->getById($id);
if (!$usuario) {
    header('Location: /admin/usuarios/index.php');
    exit;
}

$erros = [];
$dados = $usuario;
$editandoProprioUsuario = ($id == $ADMIN_ID);

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
            'senha' => $_POST['senha'] ?? '',
            'senha_confirma' => $_POST['senha_confirma'] ?? '',
            'nivel_acesso' => $_POST['nivel_acesso'] ?? $usuario['nivel_acesso'],
            'ativo' => isset($_POST['ativo']) ? 1 : 0
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
        } elseif ($usuarioModel->emailExiste($dados['email'], $id)) {
            $erros[] = 'Este email já está cadastrado';
        }

        // Validar senha (se foi fornecida)
        if (!empty($dados['senha'])) {
            if (strlen($dados['senha']) < 8) {
                $erros[] = 'Senha deve ter no mínimo 8 caracteres';
            } elseif (!preg_match('/[A-Z]/', $dados['senha'])) {
                $erros[] = 'Senha deve conter pelo menos uma letra maiúscula';
            } elseif (!preg_match('/[a-z]/', $dados['senha'])) {
                $erros[] = 'Senha deve conter pelo menos uma letra minúscula';
            } elseif (!preg_match('/[0-9]/', $dados['senha'])) {
                $erros[] = 'Senha deve conter pelo menos um número';
            }

            // Confirmar senha
            if ($dados['senha'] !== $dados['senha_confirma']) {
                $erros[] = 'As senhas não coincidem';
            }
        }

        // Validar nível de acesso
        if (!in_array($dados['nivel_acesso'], ['admin', 'editor', 'moderador'])) {
            $erros[] = 'Nível de acesso inválido';
        }

        // Proteções para próprio usuário
        if ($editandoProprioUsuario) {
            // Não pode desativar próprio usuário
            if (!$dados['ativo']) {
                $erros[] = 'Você não pode desativar seu próprio usuário';
            }

            // Não pode rebaixar próprio nível de acesso se for admin
            if ($usuario['nivel_acesso'] === 'admin' && $dados['nivel_acesso'] !== 'admin') {
                $erros[] = 'Você não pode rebaixar seu próprio nível de acesso';
            }
        }

        // Atualizar usuário
        if (empty($erros)) {
            try {
                $usuarioModel->atualizar($id, $dados);

                // Registrar log
                registrarLog($ADMIN_ID, 'atualizar', 'usuarios_admin', $id, 'Usuário atualizado: ' . $dados['nome']);

                header('Location: /admin/usuarios/index.php?msg=atualizado');
                exit;
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
                    <h2 class="card-title">
                        Editar Usuário: <?= htmlspecialchars($usuario['nome']) ?>
                        <?php if ($editandoProprioUsuario): ?>
                            <span class="badge" style="background: #f59e0b; margin-left: 0.5rem;">Você</span>
                        <?php endif; ?>
                    </h2>
                    <a href="/admin/usuarios/index.php" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    <?php if ($editandoProprioUsuario): ?>
                        <div class="alert alert-info" style="margin-bottom: 1.5rem;">
                            ℹ️ <strong>Você está editando seu próprio usuário.</strong>
                            Algumas restrições se aplicam: você não pode desativar sua conta nem rebaixar seu nível de acesso.
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($erros)): ?>
                        <div class="alert alert-error">
                            <strong>❌ Erro ao atualizar usuário:</strong>
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
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">📝 Informações Básicas</h3>

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
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">🔒 Alterar Senha (Opcional)</h3>

                        <div class="alert alert-info" style="margin-bottom: 1rem;">
                            ℹ️ Deixe os campos de senha em branco para manter a senha atual
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="senha">Nova Senha</label>
                                <input type="password"
                                       id="senha"
                                       name="senha"
                                       class="form-control"
                                       minlength="8">
                                <div id="password-strength" class="password-strength"></div>
                                <small class="form-help">Mínimo 8 caracteres, 1 maiúscula, 1 minúscula, 1 número</small>
                            </div>

                            <div class="form-group">
                                <label for="senha_confirma">Confirmar Nova Senha</label>
                                <input type="password"
                                       id="senha_confirma"
                                       name="senha_confirma"
                                       class="form-control"
                                       minlength="8">
                                <small class="form-help">Digite a senha novamente</small>
                            </div>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Permissões -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">🔑 Permissões</h3>

                        <div class="form-group">
                            <label for="nivel_acesso" class="required">Nível de Acesso</label>
                            <select id="nivel_acesso"
                                    name="nivel_acesso"
                                    class="form-control"
                                    required
                                    <?= ($editandoProprioUsuario && $usuario['nivel_acesso'] === 'admin') ? 'disabled' : '' ?>>
                                <option value="moderador" <?= ($dados['nivel_acesso'] ?? '') === 'moderador' ? 'selected' : '' ?>>
                                    Moderador - Acesso básico
                                </option>
                                <option value="editor" <?= ($dados['nivel_acesso'] ?? '') === 'editor' ? 'selected' : '' ?>>
                                    Editor - Gerenciar eventos e notícias
                                </option>
                                <option value="admin" <?= ($dados['nivel_acesso'] ?? '') === 'admin' ? 'selected' : '' ?>>
                                    Admin - Acesso total (incluindo usuários)
                                </option>
                            </select>
                            <?php if ($editandoProprioUsuario && $usuario['nivel_acesso'] === 'admin'): ?>
                                <input type="hidden" name="nivel_acesso" value="admin">
                                <small class="form-help" style="color: #f59e0b;">Você não pode rebaixar seu próprio nível de acesso</small>
                            <?php else: ?>
                                <small class="form-help">Define o que este usuário pode fazer no sistema</small>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox"
                                       name="ativo"
                                       value="1"
                                       <?= ($dados['ativo'] ?? false) ? 'checked' : '' ?>
                                       <?= $editandoProprioUsuario ? 'disabled' : '' ?>
                                       style="width: 20px; height: 20px;">
                                <span style="font-weight: 600;">Usuário Ativo</span>
                            </label>
                            <?php if ($editandoProprioUsuario): ?>
                                <input type="hidden" name="ativo" value="1">
                                <small class="form-help" style="color: #f59e0b;">Você não pode desativar sua própria conta</small>
                            <?php else: ?>
                                <small class="form-help">Apenas usuários ativos podem fazer login</small>
                            <?php endif; ?>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Informações Adicionais -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">ℹ️ Informações</h3>

                        <div style="background: #f9fafb; padding: 1rem; border-radius: 6px;">
                            <div style="margin-bottom: 0.5rem;">
                                <strong>Criado em:</strong> <?= date('d/m/Y H:i', strtotime($usuario['criado_em'])) ?>
                            </div>
                            <?php if ($usuario['ultimo_login']): ?>
                                <div>
                                    <strong>Último login:</strong> <?= date('d/m/Y H:i', strtotime($usuario['ultimo_login'])) ?>
                                </div>
                            <?php else: ?>
                                <div>
                                    <strong>Último login:</strong> <span style="color: #9ca3af;">Nunca</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Botões -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                ✓ Salvar Alterações
                            </button>
                            <a href="/admin/usuarios/index.php" class="btn btn-secondary">
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
        const senhaInput = document.getElementById('senha');
        const strengthDiv = document.getElementById('password-strength');

        senhaInput.addEventListener('input', function() {
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
        const senhaConfirmaInput = document.getElementById('senha_confirma');
        const form = document.querySelector('form');

        form.addEventListener('submit', function(e) {
            const senha = senhaInput.value;
            const senhaConfirma = senhaConfirmaInput.value;

            if (senha !== '' && senha !== senhaConfirma) {
                e.preventDefault();
                alert('As senhas não coincidem!');
                senhaConfirmaInput.focus();
            }
        });
    </script>
</body>
</html>
