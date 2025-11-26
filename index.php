<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Arena BRB Mané Garrincha - O maior complexo de entretenimento e eventos do Brasil em Brasília">
    <meta name="keywords" content="Arena BRB, Mané Garrincha, Brasília, eventos, shows, estádio">
    <meta name="author" content="Arena BRB Mané Garrincha">

    <title>Arena BRB Mané Garrincha - Onde Brasília vive suas maiores experiências</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Background Effects -->
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <!-- Navigation -->
<nav id="navbar">
    <div class="logo">
        <img src="https://i.imgur.com/51FYi3K.png" alt="Arena BRB" class="logo-img logo-dark" id="logo-dark">
        <img src="https://i.imgur.com/qAvyaL0.png" alt="Arena BRB" class="logo-img logo-light" id="logo-light">
    </div>

    <ul class="nav-links">
        <li><a href="#eventos">Eventos</a></li>
        <li><a href="#espacos">Espaços</a></li>
        <li><a href="#tour">Tour Virtual</a></li>
        <li><a href="#contato">Contato</a></li>
    </ul>

    <a href="#" class="nav-cta">Comprar Ingressos</a>

    <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Toggle AGORA DENTRO DO NAV -->
    <button class="theme-toggle" onclick="toggleTheme()" aria-label="Alternar tema">
        <span id="theme-icon">☀️</span>
    </button>
    
</nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">
                Maior complexo de eventos do Brasil
            </div>
            <h1>Onde <span class="gradient">Brasília</span> vive suas maiores experiências</h1>
            <p class="hero-desc">Arena BRB: 830 mil metros quadrados de entretenimento, esporte e cultura no coração da capital.</p>
            <div class="hero-btns">
                <a href="#eventos" class="btn-primary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    Ver Próximos Eventos
                </a>
                <a href="#tour" class="btn-secondary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polygon points="5 3 19 12 5 21"/>
                    </svg>
                    Tour Virtual 360º
                </a>
            </div>
        </div>

        <div class="hero-visual">
            <div class="stadium-card">
                <div class="stadium-inner">
                    <div class="stadium-img">
                        <svg width="120" height="120" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                            <ellipse cx="12" cy="12" rx="10" ry="4"/>
                            <path d="M2 12v4c0 2.2 4.5 4 10 4s10-1.8 10-4v-4"/>
                            <path d="M2 8v4M22 8v4"/>
                            <ellipse cx="12" cy="8" rx="10" ry="4"/>
                        </svg>
                    </div>
                    <div class="stadium-info">
                        <h3 class="stadium-title">Arena BRB Mané Garrincha</h3>
                        <p class="stadium-sub">Brasília, Distrito Federal</p>
                        <div class="stadium-stats">
                            <div>
                                <span class="stat-val">72K</span>
                                <span class="stat-label">Capacidade</span>
                            </div>
                            <div>
                                <span class="stat-val">2013</span>
                                <span class="stat-label">Inauguração</span>
                            </div>
                            <div>
                                <span class="stat-val">FIFA</span>
                                <span class="stat-label">Padrão</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="float-card float-card-1">
                <div class="float-icon">
                    <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <div class="float-info">
                    <h4>Próximo Evento</h4>
                    <p>Em 3 dias</p>
                </div>
            </div>

            <div class="float-card float-card-2">
                <div class="float-icon">
                    <svg width="18" height="18" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <div class="float-info">
                    <h4>+2M Visitantes</h4>
                    <p>Por ano</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="events" id="eventos">
        <div class="section-header">
            <div>
                <h2 class="section-title">Próximos <span>Eventos</span></h2>
                <p class="section-sub">Shows, jogos e experiências imperdíveis</p>
            </div>
            <a href="#" class="view-all">
                Ver todos
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="events-grid">
            <!-- Event Card 1 -->
            <div class="event-card">
                <div class="event-img">
                    <svg width="60" height="60" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M9 18V5l12-2v13"/>
                        <circle cx="6" cy="18" r="3"/>
                        <circle cx="18" cy="16" r="3"/>
                    </svg>
                    <div class="event-date">
                        <span class="day">15</span>
                        <span class="month">DEZ</span>
                    </div>
                    <span class="event-cat">Show</span>
                </div>
                <div class="event-content">
                    <h3 class="event-title">Turma do Pagode + Rodriguinho</h3>
                    <p class="event-venue">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        Arena BRB Mané Garrincha
                    </p>
                    <div class="event-footer">
                        <span class="event-price">A partir de <strong>R$ 80</strong></span>
                        <a href="#" class="event-btn">Comprar</a>
                    </div>
                </div>
            </div>

            <!-- Event Card 2 -->
            <div class="event-card">
                <div class="event-img">
                    <svg width="60" height="60" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 2a15 15 0 000 20M2 12h20"/>
                    </svg>
                    <div class="event-date">
                        <span class="day">18</span>
                        <span class="month">DEZ</span>
                    </div>
                    <span class="event-cat">Basquete</span>
                </div>
                <div class="event-content">
                    <h3 class="event-title">Brasília Basquete vs Flamengo</h3>
                    <p class="event-venue">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        Arena BRB Nilson Nelson
                    </p>
                    <div class="event-footer">
                        <span class="event-price">A partir de <strong>R$ 50</strong></span>
                        <a href="#" class="event-btn">Comprar</a>
                    </div>
                </div>
            </div>

            <!-- Event Card 3 -->
            <div class="event-card">
                <div class="event-img">
                    <svg width="60" height="60" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M4 6h16v12H4z"/>
                        <path d="M4 10h16"/>
                    </svg>
                    <div class="event-date">
                        <span class="day">22</span>
                        <span class="month">DEZ</span>
                    </div>
                    <span class="event-cat">Festival</span>
                </div>
                <div class="event-content">
                    <h3 class="event-title">Festival de Verão Brasília</h3>
                    <p class="event-venue">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        Gramado - Arena BRB Mané Garrincha
                    </p>
                    <div class="event-footer">
                        <span class="event-price">A partir de <strong>R$ 120</strong></span>
                        <a href="#" class="event-btn">Comprar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="espacos">
        <div class="section-header">
            <div>
                <h2 class="section-title">Espaços <span>Multiuso</span></h2>
                <p class="section-sub">Infraestrutura modular para eventos esportivos, corporativos e culturais</p>
            </div>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" fill="none" stroke="white" stroke-width="1.8" viewBox="0 0 24 24">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M7 5V3M17 5V3"/>
                    </svg>
                </div>
                <h3 class="feature-title">Arena BRB Mané Garrincha</h3>
                <p class="feature-desc">Estrutura para grandes shows, partidas e eventos de massa, com configurações variáveis de palco e plateia.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" fill="none" stroke="white" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M3 9l9-6 9 6-9 6-9-6z"/>
                        <path d="M3 15l9 6 9-6"/>
                    </svg>
                </div>
                <h3 class="feature-title">Camarotes & Lounges</h3>
                <p class="feature-desc">Ambientes premium para relacionamento com clientes, patrocinadores e convidados especiais.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" fill="none" stroke="white" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M4 5h16v6H4z"/>
                        <path d="M4 15h6v4H4zM14 15h6v4h-6z"/>
                    </svg>
                </div>
                <h3 class="feature-title">Áreas Corporativas</h3>
                <p class="feature-desc">Salas moduláveis para congressos, convenções, lançamentos de produtos e treinamentos.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="24" height="24" fill="none" stroke="white" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M2 12h4M18 12h4M12 2v4M12 18v4M4.2 4.2l2.8 2.8M17 17l2.8 2.8M19 5l-2.8 2.8M7 17L4.2 19.8"/>
                    </svg>
                </div>
                <h3 class="feature-title">Conectividade & Mídia</h3>
                <p class="feature-desc">Infraestrutura pronta para transmissão, ativações digitais, wi-fi de alta densidade e produção de conteúdo.</p>
            </div>
        </div>
    </section>

    <!-- Tour Virtual Section -->
    <section class="tour" id="tour">
        <div class="section-header">
            <div>
                <h2 class="section-title">Tour <span>Virtual 360º</span></h2>
                <p class="section-sub">Em brave: Explore a Arena BRB Mané Garrincha em uma experiência imersiva antes do seu evento</p>
            </div>
        </div>

        <div class="tour-container">
            <div class="stadium-card">
                <div class="stadium-img">
                    <svg width="120" height="120" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <ellipse cx="12" cy="7" rx="9" ry="3"/>
                        <path d="M3 7v6c0 1.7 4 3 9 3s9-1.3 9-3V7"/>
                        <path d="M3 13v4c0 1.7 4 3 9 3s9-1.3 9-3v-4"/>
                    </svg>
                </div>
                <div class="stadium-info">
                    <h3 class="stadium-title">Tour guiado em 360 graus</h3>
                    <p class="stadium-sub">Em breve: visualize cadeiras, camarotes, acessos, circulação e vistas de palco direto do navegador.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="contato">
        <div class="cta-card">
            <div class="cta-content">
                <h2 class="cta-title">Traga seu evento para a Arena BRB</h2>
                <p class="cta-desc">Fale com o nosso time para reservar datas, conhecer configurações de espaço, cotar operações e construir experiências de alto impacto em Brasília.</p>
                <div class="cta-btns">
                    <button class="btn-white" onclick="alert('Em breve você será redirecionado para o formulário de contato!')">Falar com Comercial</button>
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
                    <img src="https://i.imgur.com/xqyCXoQ.png" alt="Arena BSB" class="footer-logo footer-logo-dark" id="footer-logo-arena-dark">
                    <img src="https://i.imgur.com/O0Vv0Y2.png" alt="Arena BSB" class="footer-logo footer-logo-light" id="footer-logo-arena-light">
                    <img src="https://i.imgur.com/sfPqjWD.png" alt="BRB Banco" class="footer-logo footer-logo-dark" id="footer-logo-brb-dark">
                    <img src="https://i.imgur.com/OM1Bshn.png" alt="BRB Banco" class="footer-logo footer-logo-light" id="footer-logo-brb-light">
                </div>
                <p>Complexo multiuso no coração de Brasília, preparado para receber os maiores eventos do país com segurança, experiência e alta performance operacional.</p>
            </div>

            <div class="footer-col">
                <h4>Arena</h4>
                <ul>
                    <li><a href="#eventos">Agenda</a></li>
                    <li><a href="#espacos">Espaços</a></li>
                    <li><a href="#tour">Tour Virtual</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Operação</h4>
                <ul>
                    <li><a href="#contato">Contato Comercial</a></li>
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
