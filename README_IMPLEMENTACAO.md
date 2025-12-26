# 📋 GUIA DE IMPLEMENTAÇÃO - ARENA BRB

## ✅ STATUS ATUAL (Implementado)

### Backend Completo
- ✅ Configuração de banco de dados com validações rígidas
- ✅ Schema SQL completo (eventos, posts, categorias, locais, usuários, logs)
- ✅ Seeds com dados iniciais
- ✅ Classe Database (Singleton PDO)
- ✅ Models completos (Evento, Post, Categoria, Local, Usuario)
- ✅ Helpers completos (security, slugify, upload, functions)
- ✅ Sistema de autenticação (login, logout, verificação)

### Validações Rígidas Implementadas
- ✅ **Imagem de evento:** EXATAMENTE 475x180px (rejeita se diferente)
- ✅ **Campos obrigatórios:** Data, Hora, Local (lista fixa), Categoria (lista fixa), Preço, Link
- ✅ **Upload seguro:** Validação de MIME, tamanho, dimensões

---

## 🚀 PRÓXIMOS PASSOS (A Implementar)

### 1. Criar Banco de Dados
```bash
# Acessar MySQL
mysql -u root -p

# Criar banco e executar schema
source /caminho/para/database/schema.sql

# Executar seeds
source /caminho/para/database/seeds/001_usuario_admin.sql
source /caminho/para/database/seeds/002_categorias.sql
source /caminho/para/database/seeds/003_locais.sql
source /caminho/para/database/seeds/004_eventos_iniciais.sql
```

### 2. Criar Painel Admin - Dashboard (admin/index.php)

```php
<?php
require_once 'includes/auth-check.php';
require_once '../config/database.php';
require_once '../includes/db/Database.php';
require_once '../includes/models/Evento.php';
require_once '../includes/models/Post.php';
require_once '../includes/models/Categoria.php';
require_once '../includes/models/Local.php';

$eventoModel = new Evento();
$postModel = new Post();

$totalEventos = $eventoModel->contarTotal(['status' => 'publicado']);
$totalPosts = $postModel->contarTotal(['status' => 'publicado']);
$eventosProximos = $eventoModel->getPublicados(5);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Arena BRB Admin</title>
    <!-- Adicionar estilos do admin -->
</head>
<body>
    <h1>Dashboard</h1>
    <div class="stats">
        <div class="stat-card">
            <h3><?= $totalEventos ?></h3>
            <p>Eventos Ativos</p>
        </div>
        <div class="stat-card">
            <h3><?= $totalPosts ?></h3>
            <p>Notícias Publicadas</p>
        </div>
    </div>
    <!-- Adicionar mais conteúdo -->
</body>
</html>
```

### 3. Criar CRUD de Categorias (admin/categorias/index.php)

**Funcionalidades:**
- Listar categorias
- Criar nova categoria
- Editar categoria
- Deletar categoria (com verificação de uso)
- Campos: nome, slug, descrição, tipo, cor, ícone, ordem

**Validações:**
- Nome obrigatório
- Slug único
- Tipo: evento, noticia ou ambos
- Cor em hexadecimal (#RRGGBB)

### 4. Criar CRUD de Locais (admin/locais/index.php)

**Funcionalidades:**
- Listar locais
- Criar novo local
- Editar local
- Deletar local (com verificação de uso)
- Campos: nome, slug, descrição, endereço, capacidade, tipo

**Validações:**
- Nome obrigatório
- Slug único
- Verificar se local está em uso antes de deletar

### 5. Criar CRUD de Eventos (admin/eventos/)

**admin/eventos/index.php** - Listar eventos
```php
<?php
require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Evento.php';

$eventoModel = new Evento();
$eventos = $eventoModel->getTodos(20, 0);
?>
<!-- Tabela de eventos -->
```

**admin/eventos/criar.php** - Formulário de criação
```php
<?php
require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Evento.php';
require_once '../../includes/models/Categoria.php';
require_once '../../includes/models/Local.php';
require_once '../../includes/helpers/slugify.php';
require_once '../../includes/helpers/upload.php';
require_once '../../includes/helpers/security.php';

$eventoModel = new Evento();
$categoriaModel = new Categoria();
$localModel = new Local();

// Buscar categorias e locais para os selects
$categorias = $categoriaModel->getByTipo('evento');
$locais = $localModel->getTodosAtivos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar upload de imagem (VALIDAÇÃO RÍGIDA: 475x180px)
    $imagemResult = uploadImagemEvento($_FILES['imagem_destaque'], $_POST['titulo']);

    if (!$imagemResult['success']) {
        $erro = $imagemResult['message'];
    } else {
        $dados = [
            'titulo' => $_POST['titulo'],
            'slug' => slugifyUnique($_POST['titulo'], 'eventos'),
            'descricao' => $_POST['descricao'],
            'conteudo' => $_POST['conteudo'],
            'data_evento' => $_POST['data_evento'], // OBRIGATÓRIO
            'hora_evento' => $_POST['hora_evento'], // OBRIGATÓRIO
            'local_id' => $_POST['local_id'], // OBRIGATÓRIO
            'categoria_id' => $_POST['categoria_id'], // OBRIGATÓRIO
            'preco_minimo' => $_POST['preco_minimo'], // OBRIGATÓRIO
            'link_ingressos' => $_POST['link_ingressos'], // OBRIGATÓRIO
            'imagem_destaque' => $imagemResult['file_path'], // OBRIGATÓRIO
            'status' => $_POST['status'],
            'destaque' => isset($_POST['destaque']) ? 1 : 0,
            'criado_por' => $ADMIN_ID
        ];

        try {
            $eventoId = $eventoModel->criar($dados);
            registrarLog($ADMIN_ID, 'criar', 'eventos', $eventoId, 'Evento criado: ' . $dados['titulo']);
            header('Location: index.php?msg=criado');
            exit;
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }
    }
}
?>
<!-- Formulário HTML com validações -->
<form method="POST" enctype="multipart/form-data">
    <!-- CAMPOS OBRIGATÓRIOS COM * -->
    <input type="text" name="titulo" required>
    <input type="date" name="data_evento" required>
    <input type="time" name="hora_evento" required>
    <select name="local_id" required>
        <!-- Locais da lista fixa -->
    </select>
    <select name="categoria_id" required>
        <!-- Categorias da lista fixa -->
    </select>
    <input type="number" name="preco_minimo" step="0.01" required>
    <input type="url" name="link_ingressos" required>
    <input type="file" name="imagem_destaque" accept="image/*" required>
    <small>⚠️ Imagem obrigatória: EXATAMENTE 475x180px</small>
</form>
```

**admin/eventos/editar.php** - Similar ao criar, mas com ID

**admin/eventos/deletar.php**
```php
<?php
require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Evento.php';
require_once '../../includes/helpers/security.php';

if (isset($_GET['id'])) {
    $eventoModel = new Evento();
    $evento = $eventoModel->getById($_GET['id']);

    if ($evento && $eventoModel->deletar($_GET['id'])) {
        registrarLog($ADMIN_ID, 'deletar', 'eventos', $_GET['id'], 'Evento deletado: ' . $evento['titulo']);
        header('Location: index.php?msg=deletado');
        exit;
    }
}
?>
```

### 6. Criar CRUD de Notícias (admin/noticias/)

Similar ao CRUD de eventos, mas:
- Imagem: 800x450px (ao invés de 475x180px)
- Usar `uploadImagemNoticia()` ao invés de `uploadImagemEvento()`
- Editor WYSIWYG para conteúdo (TinyMCE)

### 7. Modificar Home para Eventos Dinâmicos

**index.php (atual)** - Modificar seção de eventos

```php
<!-- ANTES (linhas 138-241) -->
<div class="events-grid">
    <!-- 3 eventos hardcoded -->
</div>

<!-- DEPOIS -->
<div class="events-grid">
    <?php
    require_once 'config/database.php';
    require_once 'includes/db/Database.php';
    require_once 'includes/models/Evento.php';
    require_once 'includes/helpers/functions.php';

    $eventoModel = new Evento();
    $eventos = $eventoModel->getDestaques(3);

    foreach ($eventos as $evento):
    ?>
        <div class="event-card">
            <div class="event-img">
                <?php if ($evento['imagem_destaque']): ?>
                    <img src="<?= htmlspecialchars($evento['imagem_destaque']) ?>"
                         alt="<?= htmlspecialchars($evento['titulo']) ?>">
                <?php else: ?>
                    <!-- SVG padrão -->
                <?php endif; ?>

                <div class="event-date">
                    <?= date('d \d\e F', strtotime($evento['data_evento'])) ?>
                </div>

                <span class="event-cat" style="background-color: <?= $evento['categoria_cor'] ?>">
                    <?= htmlspecialchars($evento['categoria_nome']) ?>
                </span>
            </div>

            <div class="event-content">
                <h3 class="event-title"><?= htmlspecialchars($evento['titulo']) ?></h3>
                <p class="event-venue"><?= htmlspecialchars($evento['local_nome']) ?></p>

                <div class="event-footer">
                    <span class="event-price"><?= formatarPreco($evento['preco_minimo']) ?></span>
                    <a href="<?= htmlspecialchars($evento['link_ingressos']) ?>"
                       class="event-btn"
                       target="_blank">
                        Comprar
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
```

**IMPORTANTE:** Manter TODO o CSS e estrutura visual IGUAIS. Apenas trocar dados estáticos por dinâmicos.

### 8. Criar Página Pública de Eventos (public/eventos.php)

```php
<?php
require_once '../config/database.php';
require_once '../includes/db/Database.php';
require_once '../includes/models/Evento.php';
require_once '../includes/helpers/functions.php';

$eventoModel = new Evento();
$eventos = $eventoModel->getPublicados();
?>
<!-- Listagem de todos os eventos -->
```

### 9. Criar Página Pública de Notícias (public/noticias.php)

Similar à página de eventos, mas listando posts.

---

## 🎨 CSS do Painel Admin (admin/assets/css/admin.css)

```css
/* Layout do Admin */
body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: #f5f5f5;
}

/* Header */
.admin-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Sidebar */
.admin-sidebar {
    width: 250px;
    background: #2c3e50;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 60px;
}

.admin-sidebar nav a {
    display: block;
    padding: 1rem 1.5rem;
    color: #ecf0f1;
    text-decoration: none;
    transition: background 0.3s;
}

.admin-sidebar nav a:hover {
    background: #34495e;
}

/* Content */
.admin-content {
    margin-left: 250px;
    margin-top: 60px;
    padding: 2rem;
}

/* Tabelas */
.admin-table {
    width: 100%;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.admin-table th {
    background: #667eea;
    color: white;
    padding: 1rem;
    text-align: left;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid #eee;
}

/* Formulários */
.admin-form {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

/* Botões */
.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    border: none;
    transition: all 0.3s;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-danger {
    background: #e74c3c;
    color: white;
}

/* Badges */
.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.875rem;
    color: white;
}

.status-publicado { background: #27ae60; }
.status-rascunho { background: #f39c12; }
.status-cancelado { background: #e74c3c; }
```

---

## 🔒 Segurança

### Validações a Implementar em Todos os Formulários

1. **CSRF Protection**
```php
// No topo do formulário
$csrfToken = gerarCSRFToken();

// No HTML
<input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

// Ao processar
if (!verificarCSRFToken($_POST['csrf_token'])) {
    die('Token CSRF inválido');
}
```

2. **Sanitização de Inputs**
```php
$titulo = sanitizeString($_POST['titulo']);
$conteudo = sanitizeHTML($_POST['conteudo']);
```

3. **Validação de Upload (já implementada)**
- Verificar tipo MIME
- Verificar tamanho
- **VALIDAR DIMENSÕES EXATAS (475x180px para eventos)**

---

## 📝 Checklist Final de Implementação

### Backend ✅
- [x] Configuração de banco de dados
- [x] Schema SQL
- [x] Seeds
- [x] Models
- [x] Helpers
- [x] Sistema de autenticação

### Admin (A Fazer)
- [ ] Dashboard (index.php)
- [ ] CRUD de categorias
- [ ] CRUD de locais
- [ ] CRUD de eventos (com validações rígidas)
- [ ] CRUD de notícias
- [ ] CSS do admin
- [ ] JavaScript do admin

### Frontend (A Fazer)
- [ ] Modificar home (eventos dinâmicos)
- [ ] Página de listagem de eventos
- [ ] Página de evento individual
- [ ] Página de listagem de notícias
- [ ] Página de notícia individual

### Testes
- [ ] Testar login/logout
- [ ] Testar criação de evento (validar 475x180px)
- [ ] Testar criação de notícia
- [ ] Testar seleção de locais fixos
- [ ] Testar seleção de categorias fixas
- [ ] Verificar se home mantém visual idêntico

---

## 🚀 Deploy

1. Fazer upload dos arquivos para servidor
2. Criar banco de dados e executar migrations
3. Configurar permissões da pasta `public/assets/uploads/` (755)
4. Alterar credenciais em `config/database.php`
5. Alterar senha padrão do admin após primeiro login
6. Em produção, desabilitar `display_errors` em `config/database.php`

---

## 📞 Suporte

Para dúvidas sobre implementação, consulte:
- PLANO_MODULARIZACAO_ARENA_BRB.md (plano completo)
- Código dos Models (validações implementadas)
- Helpers (funções auxiliares)
