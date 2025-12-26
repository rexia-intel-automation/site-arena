-- ============================================
-- BANCO DE DADOS: arena_brb
-- Arena BRB - Sistema de Gerenciamento
-- ============================================

CREATE DATABASE IF NOT EXISTS arena_brb
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE arena_brb;

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
-- TABELA: locais (NOVA - para gerenciamento de locais)
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
