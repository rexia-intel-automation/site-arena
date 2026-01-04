<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Erro interno do servidor - Arena BRB Mané Garrincha">
    <meta name="robots" content="noindex, nofollow">

    <title>500 - Erro interno | Arena BRB</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/styles.css">

    <style>
        .error-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 140px 20px 80px;
            text-align: center;
        }

        .error-code {
            font-size: clamp(120px, 20vw, 280px);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        .error-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.1) 0%, rgba(239, 68, 68, 0.1) 100%);
            border: 2px solid rgba(220, 38, 38, 0.2);
            border-radius: 24px;
            animation: shake 3s ease-in-out infinite;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0) rotate(0deg);
            }
            10%, 30%, 50%, 70%, 90% {
                transform: translateX(-2px) rotate(-1deg);
            }
            20%, 40%, 60%, 80% {
                transform: translateX(2px) rotate(1deg);
            }
        }

        .error-title {
            font-size: clamp(28px, 5vw, 48px);
            font-weight: 700;
            margin-bottom: 16px;
            color: var(--text);
        }

        .error-description {
            font-size: clamp(16px, 2.5vw, 20px);
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 40px;
            line-height: 1.6;
        }

        .error-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 40px;
        }

        .error-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .error-btn-primary {
            background: var(--brb-blue);
            color: white;
            border: 2px solid var(--brb-blue);
        }

        .error-btn-primary:hover {
            background: var(--brb-dark);
            border-color: var(--brb-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 71, 187, 0.3);
        }

        .error-btn-secondary {
            background: transparent;
            color: var(--text);
            border: 2px solid var(--border);
        }

        .error-btn-secondary:hover {
            background: var(--card-bg);
            border-color: var(--brb-blue);
            transform: translateY(-2px);
        }

        body.light-mode .error-btn-secondary {
            border-color: var(--light-border);
        }

        body.light-mode .error-btn-secondary:hover {
            background: rgba(0, 71, 187, 0.05);
        }

        .error-info {
            margin-top: 60px;
            padding: 32px;
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            max-width: 800px;
            width: 100%;
            backdrop-filter: blur(20px);
        }

        .error-info h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--text);
        }

        .info-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            text-align: left;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .info-icon {
            flex-shrink: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brb-blue);
        }

        .info-content {
            flex: 1;
        }

        .info-content p {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin: 0;
        }

        @media (max-width: 768px) {
            .error-actions {
                flex-direction: column;
                width: 100%;
                max-width: 400px;
            }

            .error-btn {
                width: 100%;
                justify-content: center;
            }

            .error-icon {
                width: 80px;
                height: 80px;
            }
        }
    </style>
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
            <li><a href="/eventos">Eventos</a></li>
            <li><a href="/espacos">Espaços</a></li>
        </ul>

        <a href="/" class="logo">
            <img src="https://i.imgur.com/51FYi3K.png" alt="Arena BRB" class="logo-img logo-dark" id="logo-dark">
            <img src="https://i.imgur.com/qAvyaL0.png" alt="Arena BRB" class="logo-img logo-light" id="logo-light">
        </a>

        <ul class="nav-links nav-links-right">
            <li><a href="/noticias">Notícias</a></li>
            <li><a href="/tour">Tour</a></li>
            <li><a href="/contato">Contato</a></li>
        </ul>

        <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Error Container -->
    <div class="error-container">
        <div class="error-icon">
            <svg width="60" height="60" fill="none" stroke="#DC2626" stroke-width="2" viewBox="0 0 24 24">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>

        <div class="error-code">500</div>
        <h1 class="error-title">Erro interno do servidor</h1>
        <p class="error-description">
            Algo deu errado em nossos sistemas. Nossa equipe técnica já foi notificada e está trabalhando para resolver o problema o mais rápido possível.
        </p>

        <div class="error-actions">
            <a href="/" class="error-btn error-btn-primary">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Voltar para o Início
            </a>
            <button onclick="location.reload()" class="error-btn error-btn-secondary">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="23 4 23 10 17 10"/>
                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                </svg>
                Tentar Novamente
            </button>
        </div>

        <div class="error-info">
            <h3>O que você pode fazer:</h3>
            <div class="info-list">
                <div class="info-item">
                    <div class="info-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="23 4 23 10 17 10"/>
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <p><strong>Aguarde alguns instantes</strong> e tente recarregar a página. Muitas vezes o problema é temporário e se resolve rapidamente.</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <p><strong>Volte para a página inicial</strong> e navegue novamente para a seção desejada.</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <div class="info-content">
                        <p><strong>Se o problema persistir</strong>, entre em contato com nossa equipe de suporte através da página de contato.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    <li><a href="/eventos">Agenda</a></li>
                    <li><a href="/espacos">Espaços</a></li>
                    <li><a href="/tour">Tour Virtual</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Operação</h4>
                <ul>
                    <li><a href="/contato">Contato Comercial</a></li>
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
    <script src="/assets/js/main.js"></script>
</body>
</html>
