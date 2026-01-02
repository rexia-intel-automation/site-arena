<?php
/**
 * Arena BRB Mané Garrincha - Página Individual
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Arena BRB Mané Garrincha - Estádio multiuso com capacidade para 72 mil pessoas">
    <title>Arena BRB Mané Garrincha - Arena BRB</title>
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
        <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <section class="espaco-hero">
        <div class="espaco-hero-image">
            <img src="https://i.imgur.com/BPnRSBE.jpeg" alt="Arena BRB Mané Garrincha">
        </div>
        <div class="espaco-hero-content">
            <div class="breadcrumb">
                <a href="../espacos">Espaços</a>
                <span>/</span>
                <span>Mané Garrincha</span>
            </div>
            <h1 class="espaco-hero-title">Arena BRB Mané Garrincha</h1>
            <p class="espaco-hero-desc">O maior e mais moderno estádio multiuso do Centro-Oeste brasileiro</p>
        </div>
    </section>

    <section class="espaco-info">
        <div class="info-container">
            <div class="info-main">
                <h2>Sobre o Espaço</h2>
                <p>Inaugurado em 2013 para a Copa das Confederações, o Estádio Nacional Mané Garrincha é um dos mais modernos e completos complexos esportivos da América Latina. Com capacidade para 72 mil pessoas, o estádio foi palco de jogos históricos da Copa do Mundo de 2014 e continua recebendo os maiores eventos esportivos, shows e festivais do país.</p>

                <p>Além das partidas de futebol, a Arena BRB Mané Garrincha se consolidou como um dos principais destinos para grandes shows internacionais, tendo recebido artistas como Paul McCartney, Beyoncé, The Weeknd, entre outros.</p>

                <h3>Infraestrutura de Classe Mundial</h3>
                <ul class="feature-list">
                    <li>Certificação FIFA padrão internacional</li>
                    <li>Cobertura metálica moderna e sustentável</li>
                    <li>Sistema de som e iluminação de última geração</li>
                    <li>76 camarotes VIP</li>
                    <li>Estacionamento para 8.800 veículos</li>
                    <li>Acessibilidade total</li>
                </ul>

                <h3>Eventos Realizados</h3>
                <p>O estádio já recebeu mais de 500 eventos desde sua inauguração, incluindo jogos da Copa do Mundo 2014, shows internacionais, festivais, eventos corporativos e competições esportivas de diversas modalidades.</p>
            </div>

            <aside class="info-sidebar">
                <div class="info-card">
                    <h3>Especificações</h3>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <span class="spec-label">Capacidade</span>
                            <span class="spec-value">72.788 pessoas</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Inauguração</span>
                            <span class="spec-value">18/05/2013</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Área Total</span>
                            <span class="spec-value">830.000 m²</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Padrão</span>
                            <span class="spec-value">FIFA 5 Estrelas</span>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <h3>Solicite um Orçamento</h3>
                    <p>Interessado em realizar seu evento na Arena BRB Mané Garrincha?</p>
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
            <div class="footer-col">
                <h4>Arena</h4>
                <ul>
                    <li><a href="../eventos">Agenda</a></li>
                    <li><a href="../espacos">Espaços</a></li>
                    <li><a href="../tour">Tour Virtual</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Operação</h4>
                <ul>
                    <li><a href="../contato">Contato Comercial</a></li>
                    <li><a href="#">Manual do Evento</a></li>
                    <li><a href="#">Políticas de Acesso</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Conecte-se</h4>
                <ul>
                    <li><a href="https://www.instagram.com/arenabsb/" target="_blank">Instagram</a></li>
                    <li><a href="https://www.youtube.com/@arenabsb" target="_blank">YouTube</a></li>
                    <li><a href="#" target="_blank">LinkedIn</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Arena BRB. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="../assets/js/main.js"></script>
</body>
</html>
