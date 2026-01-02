<?php
/**
 * Página de Espaços - Arena BRB
 * Listagem de todos os espaços disponíveis
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Conheça os espaços da Arena BRB - Mané Garrincha, Nilson Nelson, Complexo e Esfera">
    <meta name="keywords" content="Arena BRB, espaços, Mané Garrincha, Nilson Nelson, eventos">

    <title>Espaços - Arena BRB Mané Garrincha</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/pages/espacos.css">
</head>
<body>
    <!-- Background Effects -->
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <!-- Theme Toggle Flutuante -->
    <button class="theme-toggle-floating" onclick="toggleTheme()" aria-label="Alternar tema">
        <svg id="sun-icon" class="theme-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="4"/>
            <path d="M12 2v2"/>
            <path d="M12 20v2"/>
            <path d="m4.93 4.93 1.41 1.41"/>
            <path d="m17.66 17.66 1.41 1.41"/>
            <path d="M2 12h2"/>
            <path d="M20 12h2"/>
            <path d="m6.34 17.66-1.41 1.41"/>
            <path d="m19.07 4.93-1.41 1.41"/>
        </svg>
        <svg id="moon-icon" class="theme-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>
        </svg>
    </button>

    <!-- Navigation -->
    <nav id="navbar">
        <ul class="nav-links nav-links-left">
            <li><a href="/">Início</a></li>
            <li><a href="eventos">Eventos</a></li>
            <li><a href="espacos" class="active">Espaços</a></li>
        </ul>

        <a href="/" class="logo">
            <img src="https://i.imgur.com/51FYi3K.png" alt="Arena BRB" class="logo-img logo-dark" id="logo-dark">
            <img src="https://i.imgur.com/qAvyaL0.png" alt="Arena BRB" class="logo-img logo-light" id="logo-light">
        </a>

        <ul class="nav-links nav-links-right">
            <li><a href="noticias">Notícias</a></li>
            <li><a href="tour">Tour</a></li>
            <li><a href="contato">Contato</a></li>
        </ul>

        <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <h1 class="page-title">Nossos Espaços</h1>
        <p class="page-subtitle">Infraestrutura de classe mundial para eventos de todos os portes</p>
    </section>

    <!-- Espaços Grid -->
    <section class="espacos-section">
        <div class="espacos-grid">
            <!-- Arena BRB Mané Garrincha -->
            <div class="espaco-card espaco-large">
                <div class="espaco-image">
                    <img src="https://i.imgur.com/BPnRSBE.jpeg" alt="Arena BRB Mané Garrincha">
                    <div class="espaco-badge">Principal</div>
                </div>
                <div class="espaco-content">
                    <h2 class="espaco-title">Arena BRB Mané Garrincha</h2>
                    <p class="espaco-desc">Estádio multiuso com capacidade para 72 mil pessoas, palco de grandes shows, jogos e eventos esportivos internacionais.</p>
                    <div class="espaco-stats">
                        <div class="stat-item">
                            <span class="stat-number">72K</span>
                            <span class="stat-label">Capacidade</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">2013</span>
                            <span class="stat-label">Inauguração</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">FIFA</span>
                            <span class="stat-label">Padrão</span>
                        </div>
                    </div>
                    <a href="espacos/mane-garrincha" class="espaco-btn">Saiba Mais</a>
                </div>
            </div>

            <!-- Arena BRB Nilson Nelson -->
            <div class="espaco-card">
                <div class="espaco-image">
                    <div class="placeholder-icon">
                        <svg width="80" height="80" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M7 5V3M17 5V3"/>
                        </svg>
                    </div>
                </div>
                <div class="espaco-content">
                    <h2 class="espaco-title">Arena BRB Nilson Nelson</h2>
                    <p class="espaco-desc">Ginásio poliesportivo coberto ideal para eventos corporativos, shows e competições esportivas indoor.</p>
                    <div class="espaco-stats">
                        <div class="stat-item">
                            <span class="stat-number">16K</span>
                            <span class="stat-label">Capacidade</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">1973</span>
                            <span class="stat-label">Inauguração</span>
                        </div>
                    </div>
                    <a href="espacos/nilson-nelson" class="espaco-btn">Saiba Mais</a>
                </div>
            </div>

            <!-- Complexo Arena BRB -->
            <div class="espaco-card">
                <div class="espaco-image">
                    <div class="placeholder-icon">
                        <svg width="80" height="80" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M3 9l9-6 9 6-9 6-9-6z"/>
                            <path d="M3 15l9 6 9-6"/>
                        </svg>
                    </div>
                </div>
                <div class="espaco-content">
                    <h2 class="espaco-title">Complexo Arena BRB</h2>
                    <p class="espaco-desc">Conjunto de espaços modulares incluindo salas de convenções, lounges VIP e áreas para eventos corporativos.</p>
                    <div class="espaco-stats">
                        <div class="stat-item">
                            <span class="stat-number">830K</span>
                            <span class="stat-label">m² de área</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">20+</span>
                            <span class="stat-label">Espaços</span>
                        </div>
                    </div>
                    <a href="espacos/complexo" class="espaco-btn">Saiba Mais</a>
                </div>
            </div>

            <!-- Esfera -->
            <div class="espaco-card">
                <div class="espaco-image">
                    <div class="placeholder-icon">
                        <svg width="80" height="80" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M2 12h20"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                    </div>
                </div>
                <div class="espaco-content">
                    <h2 class="espaco-title">Esfera</h2>
                    <p class="espaco-desc">Espaço inovador para eventos premium, exposições e experiências imersivas com tecnologia de ponta.</p>
                    <div class="espaco-stats">
                        <div class="stat-item">
                            <span class="stat-number">2K</span>
                            <span class="stat-label">Capacidade</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">360°</span>
                            <span class="stat-label">Imersivo</span>
                        </div>
                    </div>
                    <a href="espacos/esfera" class="espaco-btn">Saiba Mais</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-card">
            <div class="cta-content">
                <h2 class="cta-title">Encontre o espaço ideal para seu evento</h2>
                <p class="cta-desc">Nossa equipe comercial está pronta para apresentar as melhores opções e configurações para tornar seu evento um sucesso.</p>
                <div class="cta-btns">
                    <button class="btn-white" onclick="window.location.href='contato'">Falar com Comercial</button>
                    <button class="btn-outline" onclick="alert('Download do mídia kit será disponibilizado em breve!')">Baixar Mídia Kit</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-logos">
                    <img src="https://i.imgur.com/xqyCXoQ.png" alt="Arena BSB" class="footer-logo footer-logo-dark">
                    <img src="https://i.imgur.com/O0Vv0Y2.png" alt="Arena BSB" class="footer-logo footer-logo-light">
                    <img src="https://i.imgur.com/sfPqjWD.png" alt="BRB Banco" class="footer-logo footer-logo-dark">
                    <img src="https://i.imgur.com/OM1Bshn.png" alt="BRB Banco" class="footer-logo footer-logo-light">
                </div>
                <p>Complexo multiuso no coração de Brasília, preparado para receber os maiores eventos do país com segurança, experiência e alta performance operacional.</p>
            </div>

            <div class="footer-col">
                <h4>Arena</h4>
                <ul>
                    <li><a href="eventos">Agenda</a></li>
                    <li><a href="espacos">Espaços</a></li>
                    <li><a href="tour">Tour Virtual</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Operação</h4>
                <ul>
                    <li><a href="contato">Contato Comercial</a></li>
                    <li><a href="#">Manual do Evento</a></li>
                    <li><a href="#">Políticas de Acesso</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Conecte-se</h4>
                <ul>
                    <li><a href="https://www.instagram.com/arenabsb/" target="_blank" rel="noopener">Instagram</a></li>
                    <li><a href="https://www.youtube.com/@arenabsb" target="_blank" rel="noopener">YouTube</a></li>
                    <li><a href="#" target="_blank" rel="noopener">LinkedIn</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Arena BRB Mané Garrincha. Todos os direitos reservados.</p>
            <div class="social-links">
                <a href="https://www.facebook.com/arenabsb" target="_blank" rel="noopener" class="social-link" aria-label="Facebook">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="https://twitter.com/arenabsb" target="_blank" rel="noopener" class="social-link" aria-label="Twitter">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </a>
                <a href="https://www.instagram.com/arenabsb/" target="_blank" rel="noopener" class="social-link" aria-label="Instagram">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                    </svg>
                </a>
                <a href="https://www.youtube.com/@arenabsb" target="_blank" rel="noopener" class="social-link" aria-label="YouTube">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
</body>
</html>
