<?php /** Página de Tour Virtual - Arena BRB */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Conheça a Arena BRB através de um tour virtual 360°">
    <title>Tour Virtual - Arena BRB Mané Garrincha</title>
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/pages/tour.css">
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
            <li><a href="noticias">Notícias</a></li>
            <li><a href="tour" class="active">Tour</a></li>
            <li><a href="contato">Contato</a></li>
        </ul>
        <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <section class="page-header">
        <h1 class="page-title">Tour Virtual</h1>
        <p class="page-subtitle">Explore a Arena BRB sem sair de casa</p>
    </section>

    <!-- Bento Gallery -->
    <section class="bento-section">
        <div class="bento-grid">
            <!-- Main Large -->
            <div class="bento-item bento-large" data-title="Visão Panorâmica do Estádio">
                <div class="bento-placeholder">
                    <svg width="80" height="80" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path d="m3 16 5-5 5 5"/>
                        <path d="M14 14l1-1 2 2"/>
                    </svg>
                    <p>Imagem em breve</p>
                </div>
            </div>

            <!-- Medium -->
            <div class="bento-item bento-medium" data-title="Gramado e Campo">
                <div class="bento-placeholder">
                    <svg width="60" height="60" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path d="m3 16 5-5 5 5"/>
                    </svg>
                    <p>Imagem em breve</p>
                </div>
            </div>

            <!-- Small -->
            <div class="bento-item bento-small" data-title="Arquibancadas">
                <div class="bento-placeholder">
                    <svg width="50" height="50" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="m3 16 5-5 5 5"/>
                    </svg>
                    <p>Imagem em breve</p>
                </div>
            </div>

            <!-- Small -->
            <div class="bento-item bento-small" data-title="Camarotes VIP">
                <div class="bento-placeholder">
                    <svg width="50" height="50" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="m3 16 5-5 5 5"/>
                    </svg>
                    <p>Imagem em breve</p>
                </div>
            </div>

            <!-- Tall -->
            <div class="bento-item bento-tall" data-title="Estrutura Moderna">
                <div class="bento-placeholder">
                    <svg width="70" height="70" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path d="m3 16 5-5 5 5"/>
                    </svg>
                    <p>Imagem em breve</p>
                </div>
            </div>

            <!-- Medium -->
            <div class="bento-item bento-medium" data-title="Áreas Externas">
                <div class="bento-placeholder">
                    <svg width="60" height="60" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <path d="m3 16 5-5 5 5"/>
                    </svg>
                    <p>Imagem em breve</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tour Guiado CTA -->
    <section class="tour-cta-section">
        <div class="tour-cta-card">
            <div class="tour-cta-content">
                <h2 class="tour-cta-title">Quer conhecer pessoalmente?</h2>
                <p class="tour-cta-desc">Agende um tour presencial guiado com nossa equipe e conheça todos os detalhes e bastidores da Arena BRB Mané Garrincha.</p>
                <a href="https://www.instagram.com/nosso.mane/" target="_blank" rel="noopener" class="tour-cta-btn">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                    </svg>
                    Falar com Nosso Mané Tours
                </a>
                <p class="tour-cta-note">Tour oficial da Arena BRB Mané Garrincha</p>
            </div>
            <div class="tour-cta-image">
                <div class="tour-placeholder">
                    <svg width="100" height="100" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
            </div>
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
