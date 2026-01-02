<?php /** Página de Contato - Arena BRB */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Entre em contato com a Arena BRB Mané Garrincha">
    <title>Contato - Arena BRB Mané Garrincha</title>
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/pages/contato.css">
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
            <li><a href="tour">Tour</a></li>
            <li><a href="contato" class="active">Contato</a></li>
        </ul>
        <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <section class="page-header">
        <h1 class="page-title">Contato</h1>
        <p class="page-subtitle">Estamos aqui para atender você</p>
    </section>

    <!-- Contatos Principais -->
    <section class="contact-section">
        <div class="contact-grid">
            <!-- Comercial -->
            <div class="contact-card">
                <div class="contact-icon contact-icon-primary">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 5a2 2 0 0 1 2-2h3.28a1 1 0 0 1 .948.684l1.498 4.493a1 1 0 0 1-.502 1.21l-2.257 1.13a11.042 11.042 0 0 0 5.516 5.516l1.13-2.257a1 1 0 0 1 1.21-.502l4.493 1.498a1 1 0 0 1 .684.949V19a2 2 0 0 1-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h3 class="contact-title">Comercial e Eventos</h3>
                <p class="contact-desc">Para locação de espaços e realização de eventos</p>
                <a href="mailto:comercial@arenabrb.com.br" class="contact-link">comercial@arenabrb.com.br</a>
                <a href="tel:+556133333333" class="contact-link">(61) 3333-3333</a>
            </div>

            <!-- Ouvidoria -->
            <div class="contact-card">
                <div class="contact-icon contact-icon-info">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <h3 class="contact-title">Ouvidoria</h3>
                <p class="contact-desc">Elogios, sugestões e reclamações</p>
                <a href="mailto:ouvidoria@arenabrb.com.br" class="contact-link">ouvidoria@arenabrb.com.br</a>
                <a href="tel:08001234567" class="contact-link">0800 123 4567</a>
            </div>

            <!-- Imprensa -->
            <div class="contact-card">
                <div class="contact-icon contact-icon-success">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 3h-2a2 2 0 0 0-2 2v2h8V5a2 2 0 0 0-2-2h-2z"/>
                    </svg>
                </div>
                <h3 class="contact-title">Assessoria de Imprensa</h3>
                <p class="contact-desc">Informações para jornalistas e mídia</p>
                <a href="mailto:imprensa@arenabrb.com.br" class="contact-link">imprensa@arenabrb.com.br</a>
                <a href="tel:+556133334444" class="contact-link">(61) 3333-4444</a>
            </div>

            <!-- Trabalhe Conosco -->
            <div class="contact-card">
                <div class="contact-icon contact-icon-warning">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h3 class="contact-title">Trabalhe Conosco</h3>
                <p class="contact-desc">Faça parte da nossa equipe</p>
                <a href="mailto:rh@arenabrb.com.br" class="contact-link">rh@arenabrb.com.br</a>
                <a href="#" class="contact-btn">Ver Vagas Abertas</a>
            </div>
        </div>
    </section>

    <!-- Redes Sociais -->
    <section class="social-section">
        <h2 class="section-title">Redes Sociais</h2>
        <p class="section-desc">Siga-nos para acompanhar todas as novidades</p>
        <div class="social-grid">
            <a href="https://www.instagram.com/arenabsb/" target="_blank" class="social-card">
                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                </svg>
                <span>@arenabsb</span>
            </a>
            <a href="https://www.facebook.com/arenabsb" target="_blank" class="social-card">
                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
                <span>/arenabsb</span>
            </a>
            <a href="https://www.youtube.com/@arenabsb" target="_blank" class="social-card">
                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
                <span>@arenabsb</span>
            </a>
            <a href="https://twitter.com/arenabsb" target="_blank" class="social-card">
                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                </svg>
                <span>@arenabsb</span>
            </a>
        </div>
    </section>

    <!-- Páginas Legais -->
    <section class="legal-section">
        <h2 class="section-title">Informações Legais</h2>
        <div class="legal-grid">
            <a href="#" class="legal-link">Termos e Condições de Uso</a>
            <a href="#" class="legal-link">Política de Privacidade</a>
            <a href="#" class="legal-link">Política de Cookies</a>
            <a href="#" class="legal-link">Regulamento de Acesso</a>
            <a href="mailto:imprensa@arenabrb.com.br" class="legal-link">Fale com a Imprensa</a>
            <a href="#" class="legal-link">Mídia Kit e Materiais</a>
            <a href="#" class="legal-link">Trabalhe Conosco</a>
            <a href="#" class="legal-link">Código de Conduta</a>
        </div>
    </section>

    <!-- Endereço -->
    <section class="address-section">
        <div class="address-card">
            <h3 class="address-title">Endereço</h3>
            <p class="address-text">
                Arena BRB Mané Garrincha<br>
                SRPN - Setor de Recreação Pública Norte<br>
                Brasília - DF, 70070-900
            </p>
            <a href="https://www.google.com/maps/search/?api=1&query=Arena+BRB+Mané+Garrincha" target="_blank" class="address-btn">Ver no Mapa</a>
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
