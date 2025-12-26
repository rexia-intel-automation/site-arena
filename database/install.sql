-- ============================================
-- INSTALAÇÃO COMPLETA - Arena BRB
-- Banco de dados: u568843907_arenabrbweb
-- ============================================

-- Usar banco de dados
USE u568843907_arenabrbweb;

-- ============================================
-- TABELA: usuarios_admin
-- ============================================
CREATE TABLE IF NOT EXISTS usuarios_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha_hash VARCHAR(255) NOT NULL,
    nivel_acesso ENUM('admin', 'editor', 'moderador') DEFAULT 'editor',
    ativo BOOLEAN DEFAULT TRUE,
    ultimo_login DATETIME,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_email (email),
    INDEX idx_nivel_acesso (nivel_acesso),
    INDEX idx_ativo (ativo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABELA: categorias
-- ============================================
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    descricao TEXT,
    tipo ENUM('evento', 'noticia', 'ambos') DEFAULT 'ambos',
    cor VARCHAR(7) DEFAULT '#8e44ad',
    icone VARCHAR(50),
    ordem INT DEFAULT 0,
    ativo BOOLEAN DEFAULT TRUE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_slug (slug),
    INDEX idx_tipo (tipo),
    INDEX idx_ativo (ativo),
    INDEX idx_ordem (ordem)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABELA: locais
-- ============================================
CREATE TABLE IF NOT EXISTS locais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    descricao TEXT,
    endereco VARCHAR(500),
    capacidade INT,
    tipo ENUM('arena', 'ginasio', 'estadio', 'gramado', 'outro') DEFAULT 'arena',
    ativo BOOLEAN DEFAULT TRUE,
    ordem INT DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_slug (slug),
    INDEX idx_ativo (ativo),
    INDEX idx_ordem (ordem)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABELA: eventos
-- ============================================
CREATE TABLE IF NOT EXISTS eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    descricao TEXT,
    conteudo LONGTEXT,

    -- Informações do evento (CAMPOS OBRIGATÓRIOS)
    data_evento DATE NOT NULL,
    hora_evento TIME NOT NULL,
    data_fim DATE,
    hora_fim TIME,

    -- Localização (OBRIGATÓRIO)
    local_id INT NOT NULL,
    local_detalhes TEXT,

    -- Categoria (OBRIGATÓRIO)
    categoria_id INT NOT NULL,
    tipo_evento VARCHAR(50),

    -- Ingressos (OBRIGATÓRIOS)
    preco_minimo DECIMAL(10,2) NOT NULL,
    preco_maximo DECIMAL(10,2),
    link_ingressos VARCHAR(500) NOT NULL,
    lotacao_maxima INT,

    -- Mídia (IMAGEM OBRIGATÓRIA - 475x180px)
    imagem_destaque VARCHAR(500) NOT NULL,
    galeria_imagens JSON,
    video_url VARCHAR(500),

    -- SEO e metadata
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords VARCHAR(500),

    -- Status e visibilidade
    status ENUM('publicado', 'rascunho', 'cancelado', 'adiado') DEFAULT 'rascunho',
    destaque BOOLEAN DEFAULT FALSE,
    visualizacoes INT DEFAULT 0,

    -- Auditoria
    criado_por INT,
    atualizado_por INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    publicado_em DATETIME,

    -- Índices
    INDEX idx_slug (slug),
    INDEX idx_data_evento (data_evento),
    INDEX idx_status (status),
    INDEX idx_categoria (categoria_id),
    INDEX idx_local (local_id),
    INDEX idx_destaque (destaque),
    INDEX idx_criado_em (criado_em),

    -- Chaves estrangeiras
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT,
    FOREIGN KEY (local_id) REFERENCES locais(id) ON DELETE RESTRICT,
    FOREIGN KEY (criado_por) REFERENCES usuarios_admin(id) ON DELETE SET NULL,
    FOREIGN KEY (atualizado_por) REFERENCES usuarios_admin(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABELA: posts (notícias)
-- ============================================
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    resumo TEXT,
    conteudo LONGTEXT NOT NULL,

    -- Categoria e autor
    categoria_id INT,
    autor_id INT,
    autor_nome VARCHAR(255),

    -- Mídia
    imagem_destaque VARCHAR(500) NOT NULL,
    galeria_imagens JSON,
    video_url VARCHAR(500),

    -- SEO e metadata
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords VARCHAR(500),

    -- Status e visibilidade
    status ENUM('publicado', 'rascunho', 'arquivado') DEFAULT 'rascunho',
    destaque BOOLEAN DEFAULT FALSE,
    permite_comentarios BOOLEAN DEFAULT TRUE,
    visualizacoes INT DEFAULT 0,

    -- Auditoria
    criado_por INT,
    atualizado_por INT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    publicado_em DATETIME,

    -- Índices
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_categoria (categoria_id),
    INDEX idx_destaque (destaque),
    INDEX idx_autor (autor_id),
    INDEX idx_publicado_em (publicado_em),

    -- Chaves estrangeiras
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
    FOREIGN KEY (autor_id) REFERENCES usuarios_admin(id) ON DELETE SET NULL,
    FOREIGN KEY (criado_por) REFERENCES usuarios_admin(id) ON DELETE SET NULL,
    FOREIGN KEY (atualizado_por) REFERENCES usuarios_admin(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABELA: logs_atividade (auditoria)
-- ============================================
CREATE TABLE IF NOT EXISTS logs_atividade (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    acao VARCHAR(100) NOT NULL,
    tabela VARCHAR(50),
    registro_id INT,
    detalhes TEXT,
    ip VARCHAR(45),
    user_agent VARCHAR(500),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_usuario (usuario_id),
    INDEX idx_tabela_registro (tabela, registro_id),
    INDEX idx_criado_em (criado_em),

    FOREIGN KEY (usuario_id) REFERENCES usuarios_admin(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- SEEDS: Dados Iniciais
-- ============================================

-- Usuário Admin Padrão
-- Email: admin@arenabrb.com.br
-- Senha: Admin@123
INSERT INTO usuarios_admin (nome, email, senha_hash, nivel_acesso, ativo)
VALUES (
    'Administrador Arena BRB',
    'admin@arenabrb.com.br',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin',
    TRUE
)
ON DUPLICATE KEY UPDATE nome = nome;

-- Categorias de Eventos
INSERT INTO categorias (nome, slug, descricao, tipo, cor, icone, ordem, ativo) VALUES
('Shows', 'shows', 'Apresentações musicais e shows', 'evento', '#FF5733', 'music', 1, TRUE),
('Basquete', 'basquete', 'Jogos e eventos de basquete', 'evento', '#3498DB', 'basketball', 2, TRUE),
('Festivais', 'festivais', 'Festivais e eventos culturais', 'evento', '#9B59B6', 'festival', 3, TRUE),
('Corporativo', 'corporativo', 'Eventos corporativos e empresariais', 'evento', '#2ECC71', 'business', 4, TRUE),
('Família', 'familia', 'Eventos para toda a família', 'evento', '#F39C12', 'family', 5, TRUE),
('Esportes', 'esportes', 'Eventos esportivos diversos', 'evento', '#E74C3C', 'sports', 6, TRUE)
ON DUPLICATE KEY UPDATE nome = nome;

-- Categorias de Notícias
INSERT INTO categorias (nome, slug, descricao, tipo, cor, icone, ordem, ativo) VALUES
('Notícias', 'noticias', 'Notícias gerais da Arena BRB', 'noticia', '#E74C3C', 'news', 1, TRUE),
('Destaques', 'destaques', 'Destaques e novidades importantes', 'noticia', '#1ABC9C', 'star', 2, TRUE),
('Infraestrutura', 'infraestrutura', 'Melhorias e obras na infraestrutura', 'noticia', '#34495E', 'building', 3, TRUE),
('Sustentabilidade', 'sustentabilidade', 'Ações e iniciativas sustentáveis', 'noticia', '#27AE60', 'eco', 4, TRUE),
('Eventos', 'eventos-noticias', 'Notícias sobre eventos realizados', 'noticia', '#8E44AD', 'calendar', 5, TRUE)
ON DUPLICATE KEY UPDATE nome = nome;

-- Locais
INSERT INTO locais (nome, slug, descricao, endereco, capacidade, tipo, ordem, ativo) VALUES
(
    'Arena BRB Mané Garrincha',
    'arena-brb-mane-garrincha',
    'Estádio de futebol e arena multiuso localizado no Setor de Recreação Pública Norte',
    'SRPN - Asa Norte, Brasília - DF, 70070-040',
    72788,
    'estadio',
    1,
    TRUE
),
(
    'Gramado - Arena BRB Mané Garrincha',
    'gramado-arena-brb-mane-garrincha',
    'Gramado externo da Arena BRB Mané Garrincha para eventos ao ar livre',
    'SRPN - Asa Norte, Brasília - DF, 70070-040',
    100000,
    'gramado',
    2,
    TRUE
),
(
    'Arena BRB Nilson Nelson',
    'arena-brb-nilson-nelson',
    'Ginásio poliesportivo para eventos esportivos e shows',
    'SRPN - Asa Norte, Brasília - DF, 70070-200',
    14000,
    'ginasio',
    3,
    TRUE
),
(
    'Setor Interno - Arena BRB Mané Garrincha',
    'setor-interno-arena-brb-mane-garrincha',
    'Área interna coberta do estádio',
    'SRPN - Asa Norte, Brasília - DF, 70070-040',
    50000,
    'arena',
    4,
    TRUE
),
(
    'Área VIP - Arena BRB',
    'area-vip-arena-brb',
    'Espaço exclusivo para eventos corporativos e VIP',
    'SRPN - Asa Norte, Brasília - DF',
    1000,
    'outro',
    5,
    TRUE
)
ON DUPLICATE KEY UPDATE nome = nome;

-- Eventos Iniciais (migração dos 3 eventos hardcoded)
INSERT INTO eventos (
    titulo, slug, descricao, conteudo, data_evento, hora_evento,
    local_id, categoria_id, tipo_evento, preco_minimo, link_ingressos,
    imagem_destaque, status, destaque, publicado_em
)
SELECT
    'Turma do Pagode + Rodriguinho',
    'turma-do-pagode-rodriguinho',
    'Uma noite épica de pagode com os maiores sucessos',
    '<p>Prepare-se para uma noite inesquecível com <strong>Turma do Pagode</strong> e <strong>Rodriguinho</strong>!</p><p>Os maiores sucessos do pagode brasileiro em um único show na Arena BRB Mané Garrincha.</p>',
    '2025-12-15',
    '20:00:00',
    (SELECT id FROM locais WHERE slug = 'arena-brb-mane-garrincha' LIMIT 1),
    (SELECT id FROM categorias WHERE slug = 'shows' AND tipo = 'evento' LIMIT 1),
    'show',
    80.00,
    'https://www.bilheteriadigital.com/',
    '/public/assets/uploads/eventos/turma-pagode.jpg',
    'publicado',
    TRUE,
    NOW()
WHERE NOT EXISTS (SELECT 1 FROM eventos WHERE slug = 'turma-do-pagode-rodriguinho');

INSERT INTO eventos (
    titulo, slug, descricao, conteudo, data_evento, hora_evento,
    local_id, categoria_id, tipo_evento, preco_minimo, link_ingressos,
    imagem_destaque, status, destaque, publicado_em
)
SELECT
    'Brasília Basquete vs Flamengo',
    'brasilia-basquete-vs-flamengo',
    'Clássico do basquete brasileiro pelo NBB',
    '<p><strong>Brasília Basquete</strong> enfrenta o <strong>Flamengo</strong> em um dos jogos mais aguardados da temporada!</p>',
    '2025-12-18',
    '19:30:00',
    (SELECT id FROM locais WHERE slug = 'arena-brb-nilson-nelson' LIMIT 1),
    (SELECT id FROM categorias WHERE slug = 'basquete' AND tipo = 'evento' LIMIT 1),
    'basquete',
    50.00,
    'https://www.ticket360.com.br/',
    '/public/assets/uploads/eventos/basquete-flamengo.jpg',
    'publicado',
    TRUE,
    NOW()
WHERE NOT EXISTS (SELECT 1 FROM eventos WHERE slug = 'brasilia-basquete-vs-flamengo');

INSERT INTO eventos (
    titulo, slug, descricao, conteudo, data_evento, hora_evento,
    local_id, categoria_id, tipo_evento, preco_minimo, link_ingressos,
    imagem_destaque, status, destaque, publicado_em
)
SELECT
    'Festival de Verão Brasília',
    'festival-de-verao-brasilia',
    'O maior festival de verão do Centro-Oeste com atrações nacionais',
    '<p>Chegou a hora do <strong>Festival de Verão Brasília 2025</strong>! 12 horas de muita música, cultura e diversão.</p>',
    '2025-12-22',
    '16:00:00',
    (SELECT id FROM locais WHERE slug = 'gramado-arena-brb-mane-garrincha' LIMIT 1),
    (SELECT id FROM categorias WHERE slug = 'festivais' AND tipo = 'evento' LIMIT 1),
    'festival',
    120.00,
    'https://www.eventim.com.br/',
    '/public/assets/uploads/eventos/festival-verao.jpg',
    'publicado',
    TRUE,
    NOW()
WHERE NOT EXISTS (SELECT 1 FROM eventos WHERE slug = 'festival-de-verao-brasilia');

-- ============================================
-- INSTALAÇÃO CONCLUÍDA
-- ============================================
SELECT '✅ Instalação concluída com sucesso!' AS status;
SELECT CONCAT('📊 Total de categorias: ', COUNT(*)) AS info FROM categorias;
SELECT CONCAT('📍 Total de locais: ', COUNT(*)) AS info FROM locais;
SELECT CONCAT('📅 Total de eventos: ', COUNT(*)) AS info FROM eventos;
SELECT CONCAT('👤 Total de usuários admin: ', COUNT(*)) AS info FROM usuarios_admin;
