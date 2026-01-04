<?php
/**
 * Página Individual de Notícia - Arena BRB
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
$slug = $_GET['slug'] ?? null;

if (!$slug) {
    header('Location: noticias');
    exit;
}

// Inicializar o model de Post
$postModel = new Post();

// Buscar a notícia pelo slug
$noticia = $postModel->getBySlug($slug);

// Se não encontrar, redirecionar
if (!$noticia) {
    header('Location: noticias');
    exit;
}

// Formatar data
$dataFormatada = ucfirst(formatarDataPT($noticia['publicado_em']));

// Buscar notícias relacionadas (mesma categoria, exceto a atual)
$noticiasRelacionadas = [];
if ($noticia['categoria_id']) {
    $todasNoticias = $postModel->getPublicados(4);
    foreach ($todasNoticias as $post) {
        if ($post['id'] !== $noticia['id'] && $post['categoria_id'] === $noticia['categoria_id']) {
            $noticiasRelacionadas[] = $post;
            if (count($noticiasRelacionadas) >= 3) break;
        }
    }
}

// Se não houver notícias da mesma categoria, pegar as mais recentes
if (empty($noticiasRelacionadas)) {
    $todasNoticias = $postModel->getPublicados(4);
    foreach ($todasNoticias as $post) {
        if ($post['id'] !== $noticia['id']) {
            $noticiasRelacionadas[] = $post;
            if (count($noticiasRelacionadas) >= 3) break;
        }
    }
}

// Meta tags para SEO
$metaTitle = $noticia['meta_title'] ?? $noticia['titulo'] . ' - Arena BRB';
$metaDescription = $noticia['meta_description'] ?? $noticia['resumo'] ?? substr(strip_tags($noticia['conteudo']), 0, 160);
$metaKeywords = $noticia['meta_keywords'] ?? '';
$imagemDestaque = $noticia['imagem_destaque'] ?? 'https://i.imgur.com/xqyCXoQ.png';
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

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($metaTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDescription) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($imagemDestaque) ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
    <meta property="twitter:title" content="<?= htmlspecialchars($metaTitle) ?>">
    <meta property="twitter:description" content="<?= htmlspecialchars($metaDescription) ?>">
    <meta property="twitter:image" content="<?= htmlspecialchars($imagemDestaque) ?>">

    <title><?= htmlspecialchars($metaTitle) ?></title>
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/pages/noticia.css">
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

    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <div class="breadcrumb">
            <a href="/">Início</a>
            <span class="separator">/</span>
            <a href="noticias">Notícias</a>
            <span class="separator">/</span>
            <span class="current"><?= htmlspecialchars($noticia['titulo']) ?></span>
        </div>
    </div>

    <!-- Article Header -->
    <article class="article-container">
        <header class="article-header">
            <?php if ($noticia['categoria_nome']): ?>
            <span class="article-category"><?= htmlspecialchars($noticia['categoria_nome']) ?></span>
            <?php endif; ?>

            <h1 class="article-title"><?= htmlspecialchars($noticia['titulo']) ?></h1>

            <?php if ($noticia['resumo']): ?>
            <p class="article-lead"><?= htmlspecialchars($noticia['resumo']) ?></p>
            <?php endif; ?>

            <div class="article-meta">
                <div class="meta-item">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <span><?= htmlspecialchars($dataFormatada) ?></span>
                </div>

                <?php if ($noticia['autor_nome']): ?>
                <div class="meta-item">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span><?= htmlspecialchars($noticia['autor_nome']) ?></span>
                </div>
                <?php endif; ?>

                <div class="meta-item">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                    <span><?= number_format($noticia['visualizacoes'], 0, ',', '.') ?> visualizações</span>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        <?php if ($noticia['imagem_destaque']): ?>
        <div class="article-featured-image">
            <img src="<?= htmlspecialchars($noticia['imagem_destaque']) ?>" alt="<?= htmlspecialchars($noticia['titulo']) ?>">
        </div>
        <?php endif; ?>

        <!-- Article Content -->
        <div class="article-content">
            <?= $noticia['conteudo'] ?>
        </div>

        <!-- Video (if available) -->
        <?php if ($noticia['video_url']): ?>
        <div class="article-video">
            <h3>Vídeo relacionado</h3>
            <div class="video-container">
                <iframe src="<?= htmlspecialchars($noticia['video_url']) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <?php endif; ?>

        <!-- Share -->
        <div class="article-share">
            <h4>Compartilhar</h4>
            <div class="share-buttons">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($_SERVER['REQUEST_URI']) ?>" target="_blank" class="share-btn share-facebook" aria-label="Compartilhar no Facebook">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?= urlencode($_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($noticia['titulo']) ?>" target="_blank" class="share-btn share-twitter" aria-label="Compartilhar no Twitter">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </a>
                <a href="https://wa.me/?text=<?= urlencode($noticia['titulo'] . ' - ' . $_SERVER['REQUEST_URI']) ?>" target="_blank" class="share-btn share-whatsapp" aria-label="Compartilhar no WhatsApp">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                </a>
                <a href="mailto:?subject=<?= urlencode($noticia['titulo']) ?>&body=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="share-btn share-email" aria-label="Compartilhar por Email">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Back Button -->
        <div class="article-back">
            <a href="noticias" class="btn-back">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Voltar para Notícias
            </a>
        </div>
    </article>

    <!-- Related News -->
    <?php if (!empty($noticiasRelacionadas)): ?>
    <section class="related-news">
        <div class="container">
            <h2 class="section-title">Notícias Relacionadas</h2>
            <div class="news-grid">
                <?php foreach ($noticiasRelacionadas as $relacionada): ?>
                <div class="news-card">
                    <a href="noticia?slug=<?= htmlspecialchars($relacionada['slug']) ?>" class="news-card-link-wrapper">
                        <div class="news-card-image" style="background-image: url('<?= htmlspecialchars($relacionada['imagem_destaque'] ?? 'https://i.imgur.com/xqyCXoQ.png') ?>');">
                            <?php if ($relacionada['categoria_nome']): ?>
                            <span class="news-card-category"><?= htmlspecialchars($relacionada['categoria_nome']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="news-card-content">
                            <h3 class="news-card-title"><?= htmlspecialchars($relacionada['titulo']) ?></h3>
                            <span class="news-card-date"><?= ucfirst(formatarDataPT($relacionada['publicado_em'])) ?></span>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
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
