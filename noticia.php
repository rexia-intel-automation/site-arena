<?php
/**
 * Página de Visualização de Notícia Completa - Arena BRB
 */

// Incluir configurações e classes necessárias
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/db/Database.php';
require_once __DIR__ . '/includes/models/Post.php';

/**
 * Função helper para formatar datas em português
 */
function formatarDataPT($data) {
    $meses = [
        1 => 'janeiro', 2 => 'fevereiro', 3 => 'março', 4 => 'abril',
        5 => 'maio', 6 => 'junho', 7 => 'julho', 8 => 'agosto',
        9 => 'setembro', 10 => 'outubro', 11 => 'novembro', 12 => 'dezembro'
    ];

    $timestamp = is_numeric($data) ? $data : strtotime($data);
    $dia = date('d', $timestamp);
    $mes = $meses[(int)date('n', $timestamp)];
    $ano = date('Y', $timestamp);

    return "$dia de $mes de $ano";
}

// Verificar se o slug foi fornecido
if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    header('Location: noticias');
    exit;
}

$slug = $_GET['slug'];

// Buscar a notícia pelo slug
$postModel = new Post();
$noticia = $postModel->getBySlug($slug);

// Se não encontrar a notícia, redirecionar para a página de notícias
if (!$noticia) {
    header('HTTP/1.0 404 Not Found');
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Notícia não encontrada - Arena BRB</title>
        <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body>
        <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
            <div style="text-align: center;">
                <h1 style="font-size: 3rem; margin-bottom: 1rem;">404</h1>
                <p style="font-size: 1.25rem; margin-bottom: 2rem; color: var(--text-secondary);">Notícia não encontrada</p>
                <a href="noticias" style="display: inline-block; padding: 1rem 2rem; background: var(--primary); color: white; text-decoration: none; border-radius: 12px; font-weight: 700;">Voltar para Notícias</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Preparar dados da notícia
$titulo = $noticia['titulo'];
$conteudo = $noticia['conteudo'];
$resumo = $noticia['resumo'] ?? '';
$imagem = $noticia['imagem_destaque'] ?? 'https://i.imgur.com/BPnRSBE.jpeg';
$categoria = $noticia['categoria_nome'] ?? 'Notícias';
$categoriaCor = $noticia['categoria_cor'] ?? '#3B82F6';
$autor = $noticia['autor_nome'] ?? 'Arena BRB';
$dataPublicacao = ucfirst(formatarDataPT($noticia['publicado_em']));
$visualizacoes = $noticia['visualizacoes'] ?? 0;

// Meta tags para SEO
$metaTitle = $noticia['meta_title'] ?? $titulo . ' - Arena BRB';
$metaDescription = $noticia['meta_description'] ?? $resumo;
$metaKeywords = $noticia['meta_keywords'] ?? '';

// Buscar notícias relacionadas (mesma categoria)
$noticiasRelacionadas = [];
if ($noticia['categoria_id']) {
    $todasNoticias = $postModel->getPublicados(4);
    foreach ($todasNoticias as $post) {
        if ($post['id'] !== $noticia['id'] && count($noticiasRelacionadas) < 3) {
            $noticiasRelacionadas[] = [
                'titulo' => $post['titulo'],
                'slug' => $post['slug'],
                'imagem' => $post['imagem_destaque'] ?? null,
                'data' => ucfirst(formatarDataPT($post['publicado_em'])),
                'categoria' => $post['categoria_nome'] ?? 'Notícias'
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">
    <?php if ($metaKeywords): ?>
    <meta name="keywords" content="<?= htmlspecialchars($metaKeywords) ?>">
    <?php endif; ?>
    <title><?= htmlspecialchars($metaTitle) ?></title>
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/pages/noticias.css">
    <style>
        /* Estilos específicos para a página de notícia individual */
        .article-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 140px var(--container-padding) 4rem;
        }

        .article-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .article-breadcrumb a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .article-breadcrumb a:hover {
            color: var(--primary-dark);
        }

        .article-header {
            margin-bottom: 2rem;
        }

        .article-category {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .article-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            color: var(--text);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border);
            margin-bottom: 2rem;
        }

        .article-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.9375rem;
        }

        .article-meta-item svg {
            width: 20px;
            height: 20px;
            opacity: 0.6;
        }

        .article-image {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 3rem;
        }

        .article-content {
            font-size: 1.125rem;
            line-height: 1.8;
            color: var(--text);
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 2.5rem 0 1rem;
            color: var(--text);
        }

        .article-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 2rem 0 1rem;
            color: var(--text);
        }

        .article-content ul, .article-content ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .article-content li {
            margin-bottom: 0.5rem;
        }

        .article-content a {
            color: var(--primary);
            text-decoration: underline;
        }

        .article-content a:hover {
            color: var(--primary-dark);
        }

        .article-footer {
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
        }

        .back-to-news {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: var(--card-bg);
            border: 1px solid var(--border);
            color: var(--text);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .back-to-news:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateX(-4px);
        }

        .related-news-section {
            max-width: var(--container-max);
            margin: 4rem auto;
            padding: 0 var(--container-padding);
        }

        .related-news-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 2rem;
            text-align: center;
        }

        .related-news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        @media (max-width: 768px) {
            .article-container {
                padding: 120px var(--container-padding) 3rem;
            }

            .article-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .article-content {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <button class="theme-toggle-floating" onclick="toggleTheme()" aria-label="Alternar tema">
        <svg id="sun-icon" class="theme-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2m-8.93-8.93 1.41 1.41m12.73 0 1.41-1.41M2 12h2m16 0h2m-14.07 5.07-1.41 1.41m12.73 0-1.41-1.41"/>
        </svg>
        <svg id="moon-icon" class="theme-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
        </svg>
    </button>

    <nav id="navbar">
        <ul class="nav-links nav-links-left">
            <li><a href="/">Início</a></li>
            <li><a href="eventos">Eventos</a></li>
            <li><a href="espacos">Espaços</a></li>
        </ul>
        <a href="/" class="logo">
            <img src="https://i.imgur.com/51FYi3K.png" alt="Arena BRB" class="logo-img logo-dark">
            <img src="https://i.imgur.com/qAvyaL0.png" alt="Arena BRB" class="logo-img logo-light">
        </a>
        <ul class="nav-links nav-links-right">
            <li><a href="noticias" class="active">Notícias</a></li>
            <li><a href="tour">Tour</a></li>
            <li><a href="contato">Contato</a></li>
        </ul>
        <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <article class="article-container">
        <!-- Breadcrumb -->
        <nav class="article-breadcrumb">
            <a href="/">Início</a>
            <span>›</span>
            <a href="noticias">Notícias</a>
            <span>›</span>
            <span><?= htmlspecialchars($titulo) ?></span>
        </nav>

        <!-- Cabeçalho do Artigo -->
        <header class="article-header">
            <span class="article-category" style="background: <?= htmlspecialchars($categoriaCor) ?>;">
                <?= htmlspecialchars($categoria) ?>
            </span>
            <h1 class="article-title"><?= htmlspecialchars($titulo) ?></h1>

            <div class="article-meta">
                <div class="article-meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span><?= htmlspecialchars($dataPublicacao) ?></span>
                </div>
                <div class="article-meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span><?= htmlspecialchars($autor) ?></span>
                </div>
                <div class="article-meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span><?= number_format($visualizacoes, 0, ',', '.') ?> visualizações</span>
                </div>
            </div>
        </header>

        <!-- Imagem de Destaque -->
        <?php if ($imagem): ?>
        <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($titulo) ?>" class="article-image">
        <?php endif; ?>

        <!-- Conteúdo do Artigo -->
        <div class="article-content">
            <?php if ($resumo): ?>
            <p style="font-size: 1.25rem; font-weight: 500; color: var(--text-secondary); margin-bottom: 2rem;">
                <?= htmlspecialchars($resumo) ?>
            </p>
            <?php endif; ?>

            <?= $conteudo ?>
        </div>

        <!-- Rodapé do Artigo -->
        <footer class="article-footer">
            <a href="noticias" class="back-to-news">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar para Notícias
            </a>
        </footer>
    </article>

    <!-- Notícias Relacionadas -->
    <?php if (!empty($noticiasRelacionadas)): ?>
    <section class="related-news-section">
        <h2 class="related-news-title">Notícias Relacionadas</h2>
        <div class="related-news-grid">
            <?php foreach ($noticiasRelacionadas as $relacionada): ?>
            <div class="news-card">
                <div class="news-card-image" <?php if (!empty($relacionada['imagem'])): ?>style="background-image: url('<?= htmlspecialchars($relacionada['imagem']) ?>');"<?php endif; ?>>
                    <?php if (empty($relacionada['imagem'])): ?>
                    <div class="placeholder-icon">
                        <svg width="60" height="60" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="news-card-content">
                    <span class="news-card-category"><?= htmlspecialchars($relacionada['categoria']) ?></span>
                    <h3 class="news-card-title"><?= htmlspecialchars($relacionada['titulo']) ?></h3>
                    <span class="news-card-date"><?= htmlspecialchars($relacionada['data']) ?></span>
                    <a href="noticia?slug=<?= htmlspecialchars($relacionada['slug']) ?>" class="news-card-link">Leia mais</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-logos">
                    <img src="https://i.imgur.com/xqyCXoQ.png" alt="Arena BSB" class="footer-logo footer-logo-dark">
                    <img src="https://i.imgur.com/O0Vv0Y2.png" alt="Arena BSB" class="footer-logo footer-logo-light">
                    <img src="https://i.imgur.com/sfPqjWD.png" alt="BRB Banco" class="footer-logo footer-logo-dark">
                    <img src="https://i.imgur.com/OM1Bshn.png" alt="BRB Banco" class="footer-logo footer-logo-light">
                </div>
                <p>Complexo multiuso no coração de Brasília, preparado para receber os maiores eventos do país.</p>
            </div>
            <div class="footer-col"><h4>Arena</h4><ul><li><a href="eventos">Agenda</a></li><li><a href="espacos">Espaços</a></li><li><a href="tour">Tour Virtual</a></li></ul></div>
            <div class="footer-col"><h4>Operação</h4><ul><li><a href="contato">Contato Comercial</a></li><li><a href="#">Manual do Evento</a></li><li><a href="#">Políticas de Acesso</a></li></ul></div>
            <div class="footer-col"><h4>Conecte-se</h4><ul><li><a href="https://www.instagram.com/arenabsb/" target="_blank">Instagram</a></li><li><a href="https://www.youtube.com/@arenabsb" target="_blank">YouTube</a></li><li><a href="#" target="_blank">LinkedIn</a></li></ul></div>
        </div>
        <div class="footer-bottom"><p>&copy; <?php echo date('Y'); ?> Arena BRB. Todos os direitos reservados.</p></div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
