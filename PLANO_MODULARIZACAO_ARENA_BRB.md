# 📋 PLANO DE MODULARIZAÇÃO - ARENA BRB

## 🎯 OBJETIVO

Transformar o site estático da Arena BRB em um **sistema dinâmico com gerenciamento de conteúdo**, mantendo:

- ✅ **Estrutura da home atual** (não alterar)
- ✅ **Estilos visuais existentes** (não alterar)
- ✅ **Design responsivo e tema claro/escuro**
- ➕ **Sistema de cadastro de notícias**
- ➕ **Sistema de cadastro de eventos**
- ➕ **Painel administrativo completo**

---

## 📊 ANÁLISE DA SITUAÇÃO ATUAL

### Estrutura Existente

```
site-arena/
├── index.php              # Home estática (426 linhas)
├── .htaccess             # Configurações Apache otimizadas
├── README.md             # Documentação
└── assets/
    ├── css/
    │   └── styles.css    # 24.9 KB - Design moderno
    └── js/
        └── main.js       # 9.1 KB - Interatividade
```

### O que existe (MANTER)
- ✅ Site institucional estático funcional
- ✅ Design responsivo moderno
- ✅ Tema claro/escuro com localStorage
- ✅ Hero section monumental
- ✅ Seção de eventos (3 eventos hardcoded)
- ✅ Seção de features/espaços
- ✅ Tour virtual 360°
- ✅ Footer com redes sociais
- ✅ Otimizações .htaccess (GZIP, cache, segurança)

### O que NÃO existe (CRIAR)
- ❌ Banco de dados
- ❌ Sistema de posts/notícias
- ❌ Sistema dinâmico de eventos
- ❌ Painel administrativo
- ❌ Sistema de autenticação
- ❌ CRUDs
- ❌ Upload de imagens
- ❌ API/Backend

---

## 🏗️ ESTRUTURA MODULAR PROPOSTA

### Nova Organização de Diretórios

```
site-arena/
│
├── 📁 config/                        # CONFIGURAÇÕES
│   ├── database.php                  # Conexão com MySQL
│   ├── config.php                    # Configurações gerais
│   └── .env.example                  # Exemplo de variáveis de ambiente
│
├── 📁 includes/                      # FUNCIONALIDADES CORE
│   ├── db/                           # Classes de banco de dados
│   │   ├── Database.php              # Singleton de conexão PDO
│   │   └── QueryBuilder.php          # Helper de queries
│   │
│   ├── models/                       # Modelos de dados
│   │   ├── Evento.php                # Modelo de eventos
│   │   ├── Post.php                  # Modelo de posts/notícias
│   │   ├── Categoria.php             # Modelo de categorias
│   │   └── Usuario.php               # Modelo de usuários admin
│   │
│   ├── controllers/                  # Controladores
│   │   ├── EventoController.php      # Lógica de eventos
│   │   ├── PostController.php        # Lógica de posts
│   │   └── AuthController.php        # Autenticação
│   │
│   ├── helpers/                      # Funções auxiliares
│   │   ├── functions.php             # Funções globais
│   │   ├── security.php              # XSS, CSRF, validações
│   │   ├── slugify.php               # Geração de slugs
│   │   └── upload.php                # Upload de imagens
│   │
│   └── components/                   # Componentes reutilizáveis
│       ├── header.php                # Cabeçalho (do site atual)
│       ├── footer.php                # Rodapé (do site atual)
│       ├── event-card.php            # Card de evento
│       └── post-card.php             # Card de post
│
├── 📁 public/                        # PÁGINAS PÚBLICAS
│   ├── index.php                     # Home (atual, sem alterações)
│   ├── eventos.php                   # Listagem de eventos
│   ├── evento.php                    # Evento individual
│   ├── noticias.php                  # Listagem de notícias
│   ├── noticia.php                   # Notícia individual
│   │
│   ├── api/                          # API endpoints (para AJAX)
│   │   ├── eventos.php               # GET eventos
│   │   └── posts.php                 # GET posts
│   │
│   └── assets/                       # Assets públicos (MANTIDOS)
│       ├── css/
│       │   └── styles.css            # Estilos atuais (não alterar)
│       ├── js/
│       │   └── main.js               # Scripts atuais (não alterar)
│       └── uploads/                  # Uploads de usuários
│           ├── eventos/
│           ├── noticias/
│           └── galerias/
│
├── 📁 admin/                         # PAINEL ADMINISTRATIVO
│   ├── index.php                     # Dashboard
│   ├── login.php                     # Página de login
│   ├── logout.php                    # Logout
│   │
│   ├── eventos/                      # Gestão de eventos
│   │   ├── index.php                 # Listar eventos
│   │   ├── criar.php                 # Criar evento
│   │   ├── editar.php                # Editar evento
│   │   ├── deletar.php               # Deletar evento
│   │   └── ajax.php                  # Operações AJAX
│   │
│   ├── noticias/                     # Gestão de notícias
│   │   ├── index.php                 # Listar notícias
│   │   ├── criar.php                 # Criar notícia
│   │   ├── editar.php                # Editar notícia
│   │   ├── deletar.php               # Deletar notícia
│   │   └── ajax.php                  # Operações AJAX
│   │
│   ├── categorias/                   # Gestão de categorias
│   │   └── index.php                 # CRUD de categorias
│   │
│   ├── usuarios/                     # Gestão de usuários admin
│   │   └── index.php                 # CRUD de usuários
│   │
│   ├── includes/                     # Componentes do admin
│   │   ├── auth-check.php            # Verificação de autenticação
│   │   ├── header.php                # Cabeçalho do admin
│   │   ├── sidebar.php               # Menu lateral
│   │   └── footer.php                # Rodapé do admin
│   │
│   └── assets/                       # Assets do admin
│       ├── css/
│       │   └── admin.css             # Estilos do painel
│       ├── js/
│       │   └── admin.js              # Scripts do painel
│       └── vendor/                   # Bibliotecas externas
│           └── tinymce/              # Editor WYSIWYG
│
├── 📁 database/                      # MIGRATIONS E SEEDS
│   ├── schema.sql                    # Criação de todas as tabelas
│   ├── seeds/
│   │   ├── categorias.sql            # Categorias padrão
│   │   └── usuario_admin.sql         # Usuário admin padrão
│   └── migrations/
│       └── 001_initial_setup.sql     # Migration inicial
│
├── 📄 .htaccess                      # Configurações Apache (MANTER)
├── 📄 .gitignore                     # Git ignore
├── 📄 README.md                      # Documentação principal
└── 📄 CHANGELOG.md                   # Histórico de mudanças
```

---

## 🗄️ ESTRUTURA DO BANCO DE DADOS

### Schema Completo

```sql
-- ============================================
-- BANCO DE DADOS: arena_brb
-- ============================================

-- Tabela de Usuários Administrativos
CREATE TABLE usuarios_admin (
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
    INDEX idx_nivel_acesso (nivel_acesso)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Categorias
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    descricao TEXT,
    tipo ENUM('evento', 'noticia', 'ambos') DEFAULT 'ambos',
    cor VARCHAR(7),  -- Código hexadecimal de cor (#FF5733)
    icone VARCHAR(50), -- Nome do ícone (ex: 'music', 'sports', 'news')
    ordem INT DEFAULT 0,
    ativo BOOLEAN DEFAULT TRUE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_tipo (tipo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Eventos
CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    descricao TEXT,
    conteudo LONGTEXT,

    -- Informações do evento
    data_evento DATE NOT NULL,
    hora_evento TIME,
    data_fim DATE,
    hora_fim TIME,

    -- Localização
    local VARCHAR(255),
    local_detalhes TEXT,
    cidade VARCHAR(100) DEFAULT 'Brasília',
    estado VARCHAR(2) DEFAULT 'DF',

    -- Categoria e tipo
    categoria_id INT,
    tipo_evento VARCHAR(50), -- 'show', 'esporte', 'festival', 'corporativo'

    -- Ingressos
    preco_minimo DECIMAL(10,2),
    preco_maximo DECIMAL(10,2),
    link_ingressos VARCHAR(500),
    lotacao_maxima INT,

    -- Mídia
    imagem_destaque VARCHAR(500),
    galeria_imagens JSON, -- Array de URLs de imagens
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
    INDEX idx_destaque (destaque),
    INDEX idx_criado_em (criado_em),

    -- Chaves estrangeiras
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
    FOREIGN KEY (criado_por) REFERENCES usuarios_admin(id) ON DELETE SET NULL,
    FOREIGN KEY (atualizado_por) REFERENCES usuarios_admin(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Posts/Notícias
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    resumo TEXT,
    conteudo LONGTEXT NOT NULL,

    -- Categoria e autor
    categoria_id INT,
    autor_id INT,
    autor_nome VARCHAR(255), -- Para exibição (cache)

    -- Mídia
    imagem_destaque VARCHAR(500),
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

-- Tabela de Tags (opcional, para futuro)
CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    tipo ENUM('evento', 'noticia', 'ambos') DEFAULT 'ambos',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de relacionamento Posts <-> Tags
CREATE TABLE post_tags (
    post_id INT,
    tag_id INT,
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de relacionamento Eventos <-> Tags
CREATE TABLE evento_tags (
    evento_id INT,
    tag_id INT,
    PRIMARY KEY (evento_id, tag_id),
    FOREIGN KEY (evento_id) REFERENCES eventos(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Logs de Atividade (auditoria)
CREATE TABLE logs_atividade (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    acao VARCHAR(100) NOT NULL, -- 'criar', 'editar', 'deletar', 'login', etc
    tabela VARCHAR(50), -- 'eventos', 'posts', etc
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
```

### Seeds (Dados Iniciais)

```sql
-- ============================================
-- DADOS INICIAIS
-- ============================================

-- Usuário Admin Padrão
-- Senha: admin123 (ALTERAR após primeiro login!)
INSERT INTO usuarios_admin (nome, email, senha_hash, nivel_acesso) VALUES
('Administrador', 'admin@arenabrb.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Categorias de Eventos
INSERT INTO categorias (nome, slug, descricao, tipo, cor, icone, ordem) VALUES
('Shows', 'shows', 'Apresentações musicais e shows', 'evento', '#FF5733', 'music', 1),
('Esportes', 'esportes', 'Eventos esportivos', 'evento', '#3498DB', 'sports', 2),
('Festivais', 'festivais', 'Festivais e eventos culturais', 'evento', '#9B59B6', 'festival', 3),
('Corporativo', 'corporativo', 'Eventos corporativos', 'evento', '#2ECC71', 'business', 4),
('Família', 'familia', 'Eventos para toda a família', 'evento', '#F39C12', 'family', 5);

-- Categorias de Notícias
INSERT INTO categorias (nome, slug, descricao, tipo, cor, icone, ordem) VALUES
('Notícias', 'noticias', 'Notícias gerais da Arena BRB', 'noticia', '#E74C3C', 'news', 1),
('Destaques', 'destaques', 'Destaques e novidades', 'noticia', '#1ABC9C', 'star', 2),
('Infraestrutura', 'infraestrutura', 'Melhorias e obras', 'noticia', '#34495E', 'building', 3),
('Sustentabilidade', 'sustentabilidade', 'Ações sustentáveis', 'noticia', '#27AE60', 'eco', 4);

-- Eventos de exemplo (migração dos eventos hardcoded atuais)
INSERT INTO eventos (
    titulo, slug, descricao, data_evento, hora_evento, local,
    categoria_id, tipo_evento, preco_minimo, status, destaque, publicado_em
) VALUES
(
    'Turma do Pagode + Rodriguinho',
    'turma-do-pagode-rodriguinho',
    'Uma noite épica de pagode com os maiores sucessos',
    '2025-12-15',
    '20:00:00',
    'Arena BRB Mané Garrincha',
    (SELECT id FROM categorias WHERE slug = 'shows'),
    'show',
    80.00,
    'publicado',
    TRUE,
    NOW()
),
(
    'Brasília Basquete vs Flamengo',
    'brasilia-basquete-vs-flamengo',
    'Clássico do basquete brasileiro',
    '2025-12-18',
    '19:30:00',
    'Arena BRB Nilson Nelson',
    (SELECT id FROM categorias WHERE slug = 'esportes'),
    'esporte',
    50.00,
    'publicado',
    TRUE,
    NOW()
),
(
    'Festival de Verão Brasília',
    'festival-de-verao-brasilia',
    'O maior festival de verão do Centro-Oeste',
    '2025-12-22',
    '16:00:00',
    'Gramado - Arena BRB Mané Garrincha',
    (SELECT id FROM categorias WHERE slug = 'festivais'),
    'festival',
    120.00,
    'publicado',
    TRUE,
    NOW()
);
```

---

## 🔧 ARQUITETURA DE CLASSES

### 1. Database.php - Conexão Singleton

```php
<?php
// includes/db/Database.php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    // Prevenir clonagem
    private function __clone() {}

    // Prevenir unserialize
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}
```

### 2. Evento.php - Model de Eventos

```php
<?php
// includes/models/Evento.php

class Evento {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Buscar todos os eventos publicados
     */
    public function getPublicados($limit = null, $offset = 0) {
        $sql = "SELECT e.*, c.nome as categoria_nome, c.cor as categoria_cor
                FROM eventos e
                LEFT JOIN categorias c ON e.categoria_id = c.id
                WHERE e.status = 'publicado'
                AND e.data_evento >= CURDATE()
                ORDER BY e.data_evento ASC, e.hora_evento ASC";

        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($sql);

        if ($limit) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Buscar evento por slug
     */
    public function getBySlug($slug) {
        $sql = "SELECT e.*, c.nome as categoria_nome, c.cor as categoria_cor,
                       u.nome as autor_nome
                FROM eventos e
                LEFT JOIN categorias c ON e.categoria_id = c.id
                LEFT JOIN usuarios_admin u ON e.criado_por = u.id
                WHERE e.slug = :slug AND e.status = 'publicado'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);

        // Incrementar visualizações
        $evento = $stmt->fetch();
        if ($evento) {
            $this->incrementarVisualizacoes($evento['id']);
        }

        return $evento;
    }

    /**
     * Buscar eventos em destaque
     */
    public function getDestaques($limit = 3) {
        return $this->getPublicados($limit);
    }

    /**
     * Criar novo evento
     */
    public function criar($dados) {
        $sql = "INSERT INTO eventos (
                    titulo, slug, descricao, conteudo, data_evento, hora_evento,
                    local, categoria_id, tipo_evento, preco_minimo, preco_maximo,
                    imagem_destaque, status, destaque, criado_por, publicado_em
                ) VALUES (
                    :titulo, :slug, :descricao, :conteudo, :data_evento, :hora_evento,
                    :local, :categoria_id, :tipo_evento, :preco_minimo, :preco_maximo,
                    :imagem_destaque, :status, :destaque, :criado_por, :publicado_em
                )";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($dados);
    }

    /**
     * Atualizar evento
     */
    public function atualizar($id, $dados) {
        $sql = "UPDATE eventos SET
                    titulo = :titulo,
                    slug = :slug,
                    descricao = :descricao,
                    conteudo = :conteudo,
                    data_evento = :data_evento,
                    hora_evento = :hora_evento,
                    local = :local,
                    categoria_id = :categoria_id,
                    tipo_evento = :tipo_evento,
                    preco_minimo = :preco_minimo,
                    preco_maximo = :preco_maximo,
                    imagem_destaque = :imagem_destaque,
                    status = :status,
                    destaque = :destaque,
                    atualizado_por = :atualizado_por
                WHERE id = :id";

        $dados['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($dados);
    }

    /**
     * Deletar evento
     */
    public function deletar($id) {
        $sql = "DELETE FROM eventos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Incrementar visualizações
     */
    private function incrementarVisualizacoes($id) {
        $sql = "UPDATE eventos SET visualizacoes = visualizacoes + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Buscar total de eventos
     */
    public function contarTotal() {
        $sql = "SELECT COUNT(*) as total FROM eventos WHERE status = 'publicado'";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['total'];
    }
}
```

### 3. Post.php - Model de Posts/Notícias

```php
<?php
// includes/models/Post.php

class Post {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Buscar posts publicados
     */
    public function getPublicados($limit = null, $offset = 0) {
        $sql = "SELECT p.*, c.nome as categoria_nome, c.cor as categoria_cor,
                       u.nome as autor_nome
                FROM posts p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN usuarios_admin u ON p.autor_id = u.id
                WHERE p.status = 'publicado'
                ORDER BY p.publicado_em DESC";

        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($sql);

        if ($limit) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Buscar post por slug
     */
    public function getBySlug($slug) {
        $sql = "SELECT p.*, c.nome as categoria_nome, c.cor as categoria_cor,
                       u.nome as autor_nome
                FROM posts p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN usuarios_admin u ON p.autor_id = u.id
                WHERE p.slug = :slug AND p.status = 'publicado'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);

        $post = $stmt->fetch();
        if ($post) {
            $this->incrementarVisualizacoes($post['id']);
        }

        return $post;
    }

    /**
     * Buscar posts em destaque
     */
    public function getDestaques($limit = 3) {
        $sql = "SELECT p.*, c.nome as categoria_nome, c.cor as categoria_cor
                FROM posts p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                WHERE p.status = 'publicado' AND p.destaque = TRUE
                ORDER BY p.publicado_em DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Criar novo post
     */
    public function criar($dados) {
        $sql = "INSERT INTO posts (
                    titulo, slug, resumo, conteudo, categoria_id, autor_id,
                    imagem_destaque, status, destaque, criado_por, publicado_em
                ) VALUES (
                    :titulo, :slug, :resumo, :conteudo, :categoria_id, :autor_id,
                    :imagem_destaque, :status, :destaque, :criado_por, :publicado_em
                )";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($dados);
    }

    /**
     * Atualizar post
     */
    public function atualizar($id, $dados) {
        $sql = "UPDATE posts SET
                    titulo = :titulo,
                    slug = :slug,
                    resumo = :resumo,
                    conteudo = :conteudo,
                    categoria_id = :categoria_id,
                    imagem_destaque = :imagem_destaque,
                    status = :status,
                    destaque = :destaque,
                    atualizado_por = :atualizado_por
                WHERE id = :id";

        $dados['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($dados);
    }

    /**
     * Deletar post
     */
    public function deletar($id) {
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Incrementar visualizações
     */
    private function incrementarVisualizacoes($id) {
        $sql = "UPDATE posts SET visualizacoes = visualizacoes + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Contar total de posts
     */
    public function contarTotal() {
        $sql = "SELECT COUNT(*) as total FROM posts WHERE status = 'publicado'";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['total'];
    }
}
```

---

## 🎨 INTEGRAÇÃO COM A HOME ATUAL

### Modificações Mínimas em index.php

A home atual será mantida, com **apenas uma pequena modificação** na seção de eventos para buscar os dados do banco de dados:

```php
<!-- ANTES (linha 138-241 de index.php) -->
<div class="events-grid">
    <!-- 3 eventos hardcoded -->
</div>

<!-- DEPOIS -->
<div class="events-grid">
    <?php
    // Buscar eventos do banco de dados
    require_once 'config/database.php';
    require_once 'includes/db/Database.php';
    require_once 'includes/models/Evento.php';

    $eventoModel = new Evento();
    $eventos = $eventoModel->getDestaques(3); // Buscar 3 eventos em destaque

    foreach ($eventos as $evento):
        include 'includes/components/event-card.php';
    endforeach;
    ?>
</div>
```

### Componente event-card.php

```php
<?php
// includes/components/event-card.php
// Substitui o HTML hardcoded dos eventos
?>
<div class="event-card">
    <div class="event-img">
        <?php if (!empty($evento['imagem_destaque'])): ?>
            <img src="<?= htmlspecialchars($evento['imagem_destaque']) ?>"
                 alt="<?= htmlspecialchars($evento['titulo']) ?>">
        <?php else: ?>
            <!-- SVG padrão (mantém o atual) -->
            <svg>...</svg>
        <?php endif; ?>

        <div class="event-date">
            <?= date('d \d\e F', strtotime($evento['data_evento'])) ?>
        </div>

        <span class="event-cat" style="background-color: <?= $evento['categoria_cor'] ?? '#8e44ad' ?>">
            <?= htmlspecialchars($evento['categoria_nome']) ?>
        </span>
    </div>

    <div class="event-content">
        <h3 class="event-title"><?= htmlspecialchars($evento['titulo']) ?></h3>
        <p class="event-venue"><?= htmlspecialchars($evento['local']) ?></p>

        <div class="event-footer">
            <span class="event-price">
                R$ <?= number_format($evento['preco_minimo'], 2, ',', '.') ?>
            </span>
            <a href="evento.php?slug=<?= $evento['slug'] ?>" class="event-btn">
                Ver Detalhes
            </a>
        </div>
    </div>
</div>
```

**IMPORTANTE:** O CSS e a estrutura visual **não mudam**. Apenas substituímos dados estáticos por dinâmicos.

---

## 🔐 SISTEMA DE AUTENTICAÇÃO

### Fluxo de Autenticação

```php
<?php
// admin/login.php

session_start();
require_once '../config/database.php';
require_once '../includes/db/Database.php';
require_once '../includes/models/Usuario.php';
require_once '../includes/helpers/security.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    $usuarioModel = new Usuario();
    $usuario = $usuarioModel->autenticar($email, $senha);

    if ($usuario) {
        $_SESSION['admin_id'] = $usuario['id'];
        $_SESSION['admin_nome'] = $usuario['nome'];
        $_SESSION['admin_nivel'] = $usuario['nivel_acesso'];

        // Log de atividade
        registrarLog($usuario['id'], 'login', null, null, 'Login realizado');

        header('Location: index.php');
        exit;
    } else {
        $erro = "Email ou senha inválidos";
    }
}
?>
```

### Verificação de Autenticação

```php
<?php
// admin/includes/auth-check.php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Opcional: Verificar nível de acesso
function verificarNivelAcesso($nivelRequerido) {
    $niveis = ['moderador' => 1, 'editor' => 2, 'admin' => 3];

    $nivelUsuario = $niveis[$_SESSION['admin_nivel']] ?? 0;
    $nivelNecessario = $niveis[$nivelRequerido] ?? 999;

    if ($nivelUsuario < $nivelNecessario) {
        header('Location: ../index.php?erro=acesso_negado');
        exit;
    }
}
?>
```

---

## 📱 PAINEL ADMINISTRATIVO

### Dashboard (admin/index.php)

```php
<?php
require_once 'includes/auth-check.php';
require_once '../config/database.php';
require_once '../includes/db/Database.php';
require_once '../includes/models/Evento.php';
require_once '../includes/models/Post.php';

$eventoModel = new Evento();
$postModel = new Post();

// Estatísticas
$totalEventos = $eventoModel->contarTotal();
$totalPosts = $postModel->contarTotal();
$eventosProximos = $eventoModel->getPublicados(5);
$ultimosPosts = $postModel->getPublicados(5);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Arena BRB Admin</title>
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="admin-content">
        <div class="dashboard">
            <h1>Dashboard</h1>

            <!-- Cards de estatísticas -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <div class="stat-info">
                        <h3><?= $totalEventos ?></h3>
                        <p>Eventos Ativos</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">📰</div>
                    <div class="stat-info">
                        <h3><?= $totalPosts ?></h3>
                        <p>Notícias Publicadas</p>
                    </div>
                </div>

                <!-- Mais cards... -->
            </div>

            <!-- Tabelas de resumo -->
            <div class="dashboard-tables">
                <div class="table-section">
                    <h2>Próximos Eventos</h2>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Data</th>
                                <th>Local</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($eventosProximos as $evento): ?>
                            <tr>
                                <td><?= htmlspecialchars($evento['titulo']) ?></td>
                                <td><?= date('d/m/Y', strtotime($evento['data_evento'])) ?></td>
                                <td><?= htmlspecialchars($evento['local']) ?></td>
                                <td>
                                    <a href="eventos/editar.php?id=<?= $evento['id'] ?>">Editar</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tabela de últimas notícias... -->
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/admin.js"></script>
</body>
</html>
```

### CRUD de Eventos (admin/eventos/index.php)

```php
<?php
require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Evento.php';

$eventoModel = new Evento();

// Paginação
$porPagina = 20;
$paginaAtual = $_GET['pagina'] ?? 1;
$offset = ($paginaAtual - 1) * $porPagina;

$eventos = $eventoModel->getTodos($porPagina, $offset);
$totalEventos = $eventoModel->contarTotal();
$totalPaginas = ceil($totalEventos / $porPagina);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Eventos - Arena BRB Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/sidebar.php'; ?>

    <main class="admin-content">
        <div class="page-header">
            <h1>Eventos</h1>
            <a href="criar.php" class="btn btn-primary">
                <span class="icon">+</span> Novo Evento
            </a>
        </div>

        <!-- Filtros -->
        <div class="filters">
            <input type="search" placeholder="Buscar eventos..." id="searchEvents">
            <select id="filterStatus">
                <option value="">Todos os status</option>
                <option value="publicado">Publicado</option>
                <option value="rascunho">Rascunho</option>
                <option value="cancelado">Cancelado</option>
            </select>
            <select id="filterCategoria">
                <option value="">Todas as categorias</option>
                <!-- Categorias do banco -->
            </select>
        </div>

        <!-- Tabela de eventos -->
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Título</th>
                    <th>Data</th>
                    <th>Local</th>
                    <th>Categoria</th>
                    <th>Status</th>
                    <th>Visualizações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventos as $evento): ?>
                <tr>
                    <td>
                        <?php if ($evento['imagem_destaque']): ?>
                            <img src="<?= $evento['imagem_destaque'] ?>"
                                 alt="" class="table-thumb">
                        <?php else: ?>
                            <div class="no-image">📅</div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($evento['titulo']) ?></strong>
                    </td>
                    <td>
                        <?= date('d/m/Y', strtotime($evento['data_evento'])) ?>
                        <?php if ($evento['hora_evento']): ?>
                            <br><small><?= date('H:i', strtotime($evento['hora_evento'])) ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($evento['local']) ?></td>
                    <td>
                        <span class="badge" style="background-color: <?= $evento['categoria_cor'] ?>">
                            <?= $evento['categoria_nome'] ?>
                        </span>
                    </td>
                    <td>
                        <span class="status-badge status-<?= $evento['status'] ?>">
                            <?= ucfirst($evento['status']) ?>
                        </span>
                    </td>
                    <td><?= number_format($evento['visualizacoes']) ?></td>
                    <td class="actions">
                        <a href="editar.php?id=<?= $evento['id'] ?>"
                           class="btn-icon" title="Editar">
                            ✏️
                        </a>
                        <a href="deletar.php?id=<?= $evento['id'] ?>"
                           class="btn-icon btn-danger"
                           title="Deletar"
                           onclick="return confirm('Tem certeza que deseja deletar este evento?')">
                            🗑️
                        </a>
                        <a href="../../evento.php?slug=<?= $evento['slug'] ?>"
                           class="btn-icon"
                           title="Ver no site"
                           target="_blank">
                            👁️
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Paginação -->
        <?php if ($totalPaginas > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <a href="?pagina=<?= $i ?>"
                   class="<?= $i == $paginaAtual ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </main>

    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/admin.js"></script>
</body>
</html>
```

### Formulário de Criação/Edição (admin/eventos/criar.php)

```php
<?php
require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Evento.php';
require_once '../../includes/models/Categoria.php';
require_once '../../includes/helpers/slugify.php';

$eventoModel = new Evento();
$categoriaModel = new Categoria();
$categorias = $categoriaModel->getByTipo('evento');

// Se for edição, buscar dados do evento
$evento = null;
$isEdicao = false;
if (isset($_GET['id'])) {
    $evento = $eventoModel->getById($_GET['id']);
    $isEdicao = true;
}

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'titulo' => $_POST['titulo'],
        'slug' => slugify($_POST['titulo']),
        'descricao' => $_POST['descricao'],
        'conteudo' => $_POST['conteudo'],
        'data_evento' => $_POST['data_evento'],
        'hora_evento' => $_POST['hora_evento'],
        'local' => $_POST['local'],
        'categoria_id' => $_POST['categoria_id'],
        'tipo_evento' => $_POST['tipo_evento'],
        'preco_minimo' => $_POST['preco_minimo'],
        'preco_maximo' => $_POST['preco_maximo'],
        'link_ingressos' => $_POST['link_ingressos'],
        'imagem_destaque' => $_POST['imagem_destaque'], // Upload será tratado separadamente
        'status' => $_POST['status'],
        'destaque' => isset($_POST['destaque']) ? 1 : 0,
        'criado_por' => $_SESSION['admin_id'],
        'publicado_em' => $_POST['status'] === 'publicado' ? date('Y-m-d H:i:s') : null
    ];

    if ($isEdicao) {
        $dados['atualizado_por'] = $_SESSION['admin_id'];
        $eventoModel->atualizar($_GET['id'], $dados);
        header('Location: index.php?msg=atualizado');
    } else {
        $eventoModel->criar($dados);
        header('Location: index.php?msg=criado');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $isEdicao ? 'Editar' : 'Novo' ?> Evento - Arena BRB Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <!-- TinyMCE para editor WYSIWYG -->
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/sidebar.php'; ?>

    <main class="admin-content">
        <div class="page-header">
            <h1><?= $isEdicao ? 'Editar' : 'Novo' ?> Evento</h1>
        </div>

        <form method="POST" enctype="multipart/form-data" class="admin-form">
            <!-- Informações Básicas -->
            <div class="form-section">
                <h2>Informações Básicas</h2>

                <div class="form-group">
                    <label for="titulo">Título *</label>
                    <input type="text"
                           id="titulo"
                           name="titulo"
                           value="<?= $evento['titulo'] ?? '' ?>"
                           required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição Curta</label>
                    <textarea id="descricao"
                              name="descricao"
                              rows="3"><?= $evento['descricao'] ?? '' ?></textarea>
                    <small>Máximo 200 caracteres</small>
                </div>

                <div class="form-group">
                    <label for="conteudo">Conteúdo Completo</label>
                    <textarea id="conteudo"
                              name="conteudo"
                              class="wysiwyg"><?= $evento['conteudo'] ?? '' ?></textarea>
                </div>
            </div>

            <!-- Data e Local -->
            <div class="form-section">
                <h2>Data e Local</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="data_evento">Data do Evento *</label>
                        <input type="date"
                               id="data_evento"
                               name="data_evento"
                               value="<?= $evento['data_evento'] ?? '' ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="hora_evento">Horário</label>
                        <input type="time"
                               id="hora_evento"
                               name="hora_evento"
                               value="<?= $evento['hora_evento'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="local">Local *</label>
                    <select id="local" name="local" required>
                        <option value="">Selecione...</option>
                        <option value="Arena BRB Mané Garrincha"
                                <?= ($evento['local'] ?? '') === 'Arena BRB Mané Garrincha' ? 'selected' : '' ?>>
                            Arena BRB Mané Garrincha
                        </option>
                        <option value="Arena BRB Nilson Nelson"
                                <?= ($evento['local'] ?? '') === 'Arena BRB Nilson Nelson' ? 'selected' : '' ?>>
                            Arena BRB Nilson Nelson
                        </option>
                        <option value="Gramado - Arena BRB Mané Garrincha"
                                <?= ($evento['local'] ?? '') === 'Gramado - Arena BRB Mané Garrincha' ? 'selected' : '' ?>>
                            Gramado - Arena BRB Mané Garrincha
                        </option>
                    </select>
                </div>
            </div>

            <!-- Categoria e Tipo -->
            <div class="form-section">
                <h2>Categoria e Tipo</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="categoria_id">Categoria *</label>
                        <select id="categoria_id" name="categoria_id" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= $categoria['id'] ?>"
                                        <?= ($evento['categoria_id'] ?? '') == $categoria['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($categoria['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tipo_evento">Tipo de Evento</label>
                        <input type="text"
                               id="tipo_evento"
                               name="tipo_evento"
                               value="<?= $evento['tipo_evento'] ?? '' ?>"
                               placeholder="ex: show, esporte, festival">
                    </div>
                </div>
            </div>

            <!-- Ingressos -->
            <div class="form-section">
                <h2>Ingressos</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="preco_minimo">Preço Mínimo (R$)</label>
                        <input type="number"
                               id="preco_minimo"
                               name="preco_minimo"
                               step="0.01"
                               value="<?= $evento['preco_minimo'] ?? '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="preco_maximo">Preço Máximo (R$)</label>
                        <input type="number"
                               id="preco_maximo"
                               name="preco_maximo"
                               step="0.01"
                               value="<?= $evento['preco_maximo'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="link_ingressos">Link para Compra</label>
                    <input type="url"
                           id="link_ingressos"
                           name="link_ingressos"
                           value="<?= $evento['link_ingressos'] ?? '' ?>"
                           placeholder="https://">
                </div>
            </div>

            <!-- Imagem -->
            <div class="form-section">
                <h2>Imagem de Destaque</h2>

                <div class="form-group">
                    <label for="imagem_destaque">Upload de Imagem</label>
                    <input type="file"
                           id="imagem_destaque"
                           name="imagem_destaque"
                           accept="image/*">

                    <?php if (!empty($evento['imagem_destaque'])): ?>
                        <div class="image-preview">
                            <img src="<?= $evento['imagem_destaque'] ?>" alt="Preview">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Publicação -->
            <div class="form-section">
                <h2>Publicação</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="rascunho"
                                    <?= ($evento['status'] ?? 'rascunho') === 'rascunho' ? 'selected' : '' ?>>
                                Rascunho
                            </option>
                            <option value="publicado"
                                    <?= ($evento['status'] ?? '') === 'publicado' ? 'selected' : '' ?>>
                                Publicado
                            </option>
                            <option value="cancelado"
                                    <?= ($evento['status'] ?? '') === 'cancelado' ? 'selected' : '' ?>>
                                Cancelado
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox"
                                   name="destaque"
                                   value="1"
                                   <?= ($evento['destaque'] ?? false) ? 'checked' : '' ?>>
                            <span>Destacar na home</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <?= $isEdicao ? 'Atualizar' : 'Criar' ?> Evento
                </button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </main>

    <?php include '../includes/footer.php'; ?>
    <script src="../assets/js/admin.js"></script>
    <script>
        // Inicializar TinyMCE
        tinymce.init({
            selector: '.wysiwyg',
            height: 400,
            plugins: 'lists link image code',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code'
        });
    </script>
</body>
</html>
```

---

## ✅ CHECKLIST DE IMPLEMENTAÇÃO

### Fase 1: Infraestrutura Base
- [ ] Criar estrutura de diretórios
- [ ] Criar arquivo de configuração `config/database.php`
- [ ] Criar classe `Database.php` (conexão singleton)
- [ ] Criar arquivo `database/schema.sql` com todas as tabelas
- [ ] Criar arquivo `database/seeds/categorias.sql`
- [ ] Criar arquivo `database/seeds/usuario_admin.sql`
- [ ] Criar arquivo `database/seeds/eventos_iniciais.sql` (migrar os 3 eventos hardcoded)
- [ ] Executar schema e seeds no banco de dados

### Fase 2: Models
- [ ] Criar `includes/models/Evento.php`
- [ ] Criar `includes/models/Post.php`
- [ ] Criar `includes/models/Categoria.php`
- [ ] Criar `includes/models/Usuario.php`

### Fase 3: Helpers
- [ ] Criar `includes/helpers/functions.php`
- [ ] Criar `includes/helpers/security.php`
- [ ] Criar `includes/helpers/slugify.php`
- [ ] Criar `includes/helpers/upload.php`

### Fase 4: Componentes
- [ ] Extrair header da home em `includes/components/header.php`
- [ ] Extrair footer da home em `includes/components/footer.php`
- [ ] Criar `includes/components/event-card.php`
- [ ] Criar `includes/components/post-card.php`

### Fase 5: Modificar Home
- [ ] **ÚNICA MODIFICAÇÃO:** Substituir eventos hardcoded por dados do banco
- [ ] Incluir arquivos necessários (database, models)
- [ ] Buscar eventos com `Evento::getDestaques(3)`
- [ ] Renderizar com componente `event-card.php`
- [ ] **TESTAR** se visual permanece idêntico

### Fase 6: Páginas Públicas
- [ ] Criar `public/eventos.php` (listagem de eventos)
- [ ] Criar `public/evento.php` (evento individual)
- [ ] Criar `public/noticias.php` (listagem de notícias)
- [ ] Criar `public/noticia.php` (notícia individual)
- [ ] Criar `public/api/eventos.php` (endpoint AJAX)
- [ ] Criar `public/api/posts.php` (endpoint AJAX)

### Fase 7: Sistema de Autenticação
- [ ] Criar `admin/login.php`
- [ ] Criar `admin/logout.php`
- [ ] Criar `admin/includes/auth-check.php`
- [ ] Implementar `Usuario::autenticar()`
- [ ] Implementar sistema de sessões

### Fase 8: Painel Admin - Base
- [ ] Criar `admin/index.php` (dashboard)
- [ ] Criar `admin/includes/header.php`
- [ ] Criar `admin/includes/sidebar.php`
- [ ] Criar `admin/includes/footer.php`
- [ ] Criar `admin/assets/css/admin.css`
- [ ] Criar `admin/assets/js/admin.js`

### Fase 9: CRUD de Eventos
- [ ] Criar `admin/eventos/index.php` (listar)
- [ ] Criar `admin/eventos/criar.php` (criar)
- [ ] Criar `admin/eventos/editar.php` (editar)
- [ ] Criar `admin/eventos/deletar.php` (deletar)
- [ ] Implementar paginação
- [ ] Implementar filtros
- [ ] Implementar busca

### Fase 10: CRUD de Notícias
- [ ] Criar `admin/noticias/index.php` (listar)
- [ ] Criar `admin/noticias/criar.php` (criar)
- [ ] Criar `admin/noticias/editar.php` (editar)
- [ ] Criar `admin/noticias/deletar.php` (deletar)
- [ ] Integrar editor WYSIWYG (TinyMCE)
- [ ] Implementar paginação
- [ ] Implementar filtros

### Fase 11: CRUD de Categorias
- [ ] Criar `admin/categorias/index.php`
- [ ] Implementar CRUD completo inline
- [ ] Seletor de cores
- [ ] Seletor de ícones

### Fase 12: Upload de Imagens
- [ ] Implementar `includes/helpers/upload.php`
- [ ] Validação de tipos de arquivo
- [ ] Redimensionamento automático
- [ ] Proteção contra XSS
- [ ] Criar diretório `public/assets/uploads/`

### Fase 13: Segurança
- [ ] Implementar proteção CSRF
- [ ] Implementar sanitização de inputs
- [ ] Implementar validação de uploads
- [ ] Implementar rate limiting (opcional)
- [ ] Configurar headers de segurança no .htaccess

### Fase 14: Testes
- [ ] Testar criação de eventos
- [ ] Testar criação de notícias
- [ ] Testar upload de imagens
- [ ] Testar exibição na home
- [ ] Testar responsividade
- [ ] Testar tema claro/escuro
- [ ] Validar que estilos visuais não mudaram

### Fase 15: Documentação
- [ ] Atualizar README.md
- [ ] Criar INSTALLATION.md
- [ ] Criar DATABASE.md
- [ ] Criar ADMIN_GUIDE.md

### Fase 16: Deploy
- [ ] Revisar credenciais de banco
- [ ] Criar .env.example
- [ ] Atualizar .gitignore
- [ ] Commit e push
- [ ] Testar em produção

---

## 📋 PRÓXIMOS PASSOS

1. **Aprovação do Plano** - Validar estrutura proposta
2. **Implementação Fase 1** - Criar infraestrutura base
3. **Implementação Fase 2-4** - Models, helpers e componentes
4. **Implementação Fase 5** - Modificar home (CUIDADO: manter visual)
5. **Implementação Fase 6-16** - Desenvolver sistema completo
6. **Testes e Validação** - Garantir funcionamento
7. **Commit e Push** - Enviar para repositório

---

## 💡 OBSERVAÇÕES IMPORTANTES

### O que será MANTIDO (NÃO ALTERAR)
- ✅ **Estrutura HTML da home** (index.php)
- ✅ **Todos os estilos CSS** (styles.css)
- ✅ **JavaScript existente** (main.js)
- ✅ **Design responsivo**
- ✅ **Tema claro/escuro**
- ✅ **Hero section**
- ✅ **Seção de features**
- ✅ **Tour virtual**
- ✅ **Footer e header**
- ✅ **Configurações do .htaccess**

### O que será MODIFICADO (MÍNIMO)
- 🔧 **Apenas a seção de eventos** - substituir HTML estático por dados dinâmicos do banco
- 🔧 **Estrutura visual permanece IDÊNTICA**

### O que será ADICIONADO (NOVO)
- ➕ Banco de dados completo
- ➕ Sistema de posts/notícias
- ➕ Sistema dinâmico de eventos
- ➕ Painel administrativo
- ➕ Sistema de autenticação
- ➕ CRUDs completos
- ➕ Upload de imagens
- ➕ Páginas de listagem e detalhes
- ➕ API endpoints (para futuro)

---

**Este plano está pronto para ser executado. Aguardando aprovação para iniciar a implementação! 🚀**
