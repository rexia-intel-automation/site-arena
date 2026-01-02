<?php /** Complexo Arena BRB */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complexo Arena BRB - Arena BRB</title>
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/pages/espaco-detail.css">
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
            <li><a href="../eventos">Eventos</a></li>
            <li><a href="../espacos" class="active">Espaços</a></li>
        </ul>
        <a href="/" class="logo">
            <img src="https://i.imgur.com/51FYi3K.png" alt="Arena BRB" class="logo-img logo-dark">
            <img src="https://i.imgur.com/qAvyaL0.png" alt="Arena BRB" class="logo-img logo-light">
        </a>
        <ul class="nav-links nav-links-right">
            <li><a href="../noticias">Notícias</a></li>
            <li><a href="../tour">Tour</a></li>
            <li><a href="../contato">Contato</a></li>
        </ul>
        <div class="mobile-menu-toggle" onclick="toggleMobileMenu()"><span></span><span></span><span></span></div>
    </nav>
    <section class="espaco-hero">
        <div class="espaco-hero-image">
            <div style="background: linear-gradient(135deg, var(--primary), var(--accent)); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                <svg width="120" height="120" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24" style="opacity: 0.3;">
                    <path d="M3 9l9-6 9 6-9 6-9-6z"/><path d="M3 15l9 6 9-6"/>
                </svg>
            </div>
        </div>
        <div class="espaco-hero-content">
            <div class="breadcrumb"><a href="../espacos">Espaços</a><span>/</span><span>Complexo</span></div>
            <h1 class="espaco-hero-title">Complexo Arena BRB</h1>
            <p class="espaco-hero-desc">Múltiplos espaços modulares para eventos de todos os portes</p>
        </div>
    </section>
    <section class="espaco-info">
        <div class="info-container">
            <div class="info-main">
                <h2>Sobre o Complexo</h2>
                <p>O Complexo Arena BRB é um conjunto integrado de espaços que oferece flexibilidade total para a realização de eventos corporativos, feiras, exposições, convenções e celebrações. Com mais de 830 mil m² de área total, o complexo permite configurações personalizadas que vão desde pequenos encontros até grandes congressos internacionais.</p>
                <h3>Espaços Disponíveis</h3>
                <ul class="feature-list">
                    <li>Salas de convenções com capacidade variável</li>
                    <li>Lounges VIP e áreas exclusivas</li>
                    <li>Espaços para exposições e feiras</li>
                    <li>Auditórios equipados</li>
                    <li>Áreas externas para eventos</li>
                    <li>Camarotes e áreas premium</li>
                </ul>
                <h3>Serviços e Infraestrutura</h3>
                <p>Todo o complexo conta com infraestrutura completa de internet de alta velocidade, sistema de som e iluminação profissional, climatização, acessibilidade, estacionamento amplo e equipes especializadas de apoio para garantir o sucesso do seu evento.</p>
            </div>
            <aside class="info-sidebar">
                <div class="info-card">
                    <h3>Especificações</h3>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <span class="spec-label">Área Total</span>
                            <span class="spec-value">830.000 m²</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Espaços</span>
                            <span class="spec-value">20+ ambientes</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Configurações</span>
                            <span class="spec-value">Modulares</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Tipo</span>
                            <span class="spec-value">Multiuso</span>
                        </div>
                    </div>
                </div>
                <div class="info-card">
                    <h3>Solicite um Orçamento</h3>
                    <p>Interessado em realizar seu evento no Complexo Arena BRB?</p>
                    <a href="../contato" class="contact-btn">Falar com Comercial</a>
                </div>
            </aside>
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
            <div class="footer-col"><h4>Arena</h4><ul><li><a href="../eventos">Agenda</a></li><li><a href="../espacos">Espaços</a></li><li><a href="../tour">Tour Virtual</a></li></ul></div>
            <div class="footer-col"><h4>Operação</h4><ul><li><a href="../contato">Contato Comercial</a></li><li><a href="#">Manual do Evento</a></li><li><a href="#">Políticas de Acesso</a></li></ul></div>
            <div class="footer-col"><h4>Conecte-se</h4><ul><li><a href="https://www.instagram.com/arenabsb/" target="_blank">Instagram</a></li><li><a href="https://www.youtube.com/@arenabsb" target="_blank">YouTube</a></li><li><a href="#" target="_blank">LinkedIn</a></li></ul></div>
        </div>
        <div class="footer-bottom"><p>&copy; <?php echo date('Y'); ?> Arena BRB. Todos os direitos reservados.</p></div>
    </footer>
    <script src="../assets/js/main.js"></script>
</body>
</html>
