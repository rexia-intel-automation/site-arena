<?php
/**
 * Página de Notícias - Arena BRB
 */

// Placeholder data - em produção virá do banco de dados
$noticiaDestaque = [
    'titulo' => 'Arena BRB anuncia temporada de shows internacionais para 2026',
    'descricao' => 'Grandes nomes da música mundial confirmam apresentações no complexo. Line-up traz artistas de diversos gêneros e promete movimentar a capital federal.',
    'data' => '15 de Dezembro de 2025',
    'categoria' => 'Shows',
    'imagem' => 'https://i.imgur.com/BPnRSBE.jpeg'
];

$noticiasDoMes = [
    [
        'titulo' => 'Final do Campeonato Brasiliense será na Arena BRB',
        'data' => '12 de Dezembro de 2025',
        'categoria' => 'Esportes'
    ],
    [
        'titulo' => 'Novo espaço para eventos corporativos inaugurado',
        'data' => '10 de Dezembro de 2025',
        'categoria' => 'Infraestrutura'
    ],
    [
        'titulo' => 'Arena BRB recebe certificação de sustentabilidade',
        'data' => '08 de Dezembro de 2025',
        'categoria' => 'Sustentabilidade'
    ],
    [
        'titulo' => 'Festival de Música Eletrônica confirmado para março',
        'data' => '05 de Dezembro de 2025',
        'categoria' => 'Eventos'
    ],
    [
        'titulo' => 'Tour virtual 360° já disponível no site',
        'data' => '03 de Dezembro de 2025',
        'categoria' => 'Tecnologia'
    ],
    [
        'titulo' => 'Arena BRB completa 12 anos de história',
        'data' => '01 de Dezembro de 2025',
        'categoria' => 'Institucional'
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Últimas notícias da Arena BRB - Fique por dentro dos principais acontecimentos">
    <title>Notícias - Arena BRB Mané Garrincha</title>
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/pages/noticias.css">
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

    <section class="page-header">
        <h1 class="page-title">Notícias</h1>
        <p class="page-subtitle">Fique por dentro de tudo que acontece na Arena BRB</p>
    </section>

    <!-- Notícia em Destaque -->
    <section class="featured-news-section">
        <div class="featured-news-card">
            <div class="featured-news-image" style="background-image: url('<?= htmlspecialchars($noticiaDestaque['imagem']) ?>');">
                <div class="featured-news-badge"><?= htmlspecialchars($noticiaDestaque['categoria']) ?></div>
            </div>
            <div class="featured-news-content">
                <span class="featured-news-date"><?= htmlspecialchars($noticiaDestaque['data']) ?></span>
                <h2 class="featured-news-title"><?= htmlspecialchars($noticiaDestaque['titulo']) ?></h2>
                <p class="featured-news-desc"><?= htmlspecialchars($noticiaDestaque['descricao']) ?></p>
                <a href="#" class="featured-news-btn">Ler Matéria Completa</a>
            </div>
        </div>
    </section>

    <!-- Notícias do Mês -->
    <section class="news-month-section">
        <div class="section-header">
            <h2 class="section-title">Notícias do Mês</h2>
            <p class="section-subtitle">Dezembro de 2025</p>
        </div>

        <div class="news-grid">
            <?php foreach ($noticiasDoMes as $noticia): ?>
            <div class="news-card">
                <div class="news-card-image">
                    <div class="placeholder-icon">
                        <svg width="60" height="60" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                </div>
                <div class="news-card-content">
                    <span class="news-card-category"><?= htmlspecialchars($noticia['categoria']) ?></span>
                    <h3 class="news-card-title"><?= htmlspecialchars($noticia['titulo']) ?></h3>
                    <span class="news-card-date"><?= htmlspecialchars($noticia['data']) ?></span>
                    <a href="#" class="news-card-link">Leia mais</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Newsletter CTA -->
    <section class="newsletter-section">
        <div class="newsletter-card">
            <h2 class="newsletter-title">Receba as notícias em primeira mão</h2>
            <p class="newsletter-desc">Assine nossa newsletter e fique por dentro de todos os eventos e novidades da Arena BRB</p>
            <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Newsletter em desenvolvimento!');">
                <input type="email" class="newsletter-input" placeholder="Seu melhor e-mail" required>
                <button type="submit" class="newsletter-btn">Assinar Newsletter</button>
            </form>
            <p class="newsletter-privacy">Respeitamos sua privacidade. Sem spam, apenas conteúdo relevante.</p>
        </div>
    </section>

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
