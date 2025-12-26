-- ============================================
-- SEED: Usuário Administrador Padrão
-- ============================================

USE arena_brb;

-- Usuário: admin@arenabrb.com.br
-- Senha: Admin@123
-- IMPORTANTE: Alterar senha após primeiro login!

INSERT INTO usuarios_admin (nome, email, senha_hash, nivel_acesso, ativo)
VALUES (
    'Administrador Arena BRB',
    'admin@arenabrb.com.br',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin',
    TRUE
);
