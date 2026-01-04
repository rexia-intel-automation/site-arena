<?php /** Mídia Kit e Materiais - Arena BRB */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mídia Kit e Materiais da Arena BRB Mané Garrincha">
    <title>Mídia Kit e Materiais - Arena BRB Mané Garrincha</title>
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/pages/legal-pages.css">
    <style>
        .media-kit-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px 80px;
            position: relative;
            z-index: 1;
        }

        .media-section {
            margin-bottom: 60px;
        }

        .media-section h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--color-text-primary);
            margin-bottom: 12px;
        }

        .media-section p {
            color: var(--color-text-secondary);
            margin-bottom: 30px;
        }

        .download-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .download-card {
            background: var(--color-card-bg);
            border: 1px solid var(--color-border);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .download-card:hover {
            border-color: var(--color-primary);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .download-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .download-card h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--color-text-primary);
            margin-bottom: 8px;
        }

        .download-card .description {
            font-size: 0.9rem;
            color: var(--color-text-secondary);
            margin-bottom: 12px;
        }

        .download-card .file-info {
            font-size: 0.85rem;
            color: var(--color-text-secondary);
            margin-bottom: 16px;
        }

        .download-btn {
            background: var(--color-primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .download-btn:hover {
            background: var(--color-secondary);
            transform: translateY(-2px);
        }

        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            position: relative;
            aspect-ratio: 16/9;
            background: var(--color-card-bg);
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover {
            transform: scale(1.05);
        }

        .gallery-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(168, 85, 247, 0.1));
        }

        .gallery-item-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 16px;
            color: white;
        }

        .gallery-item-title {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .gallery-item-size {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .download-all-btn {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            color: white;
            border: none;
            padding: 16px 40px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }

        .download-all-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }

        @media (max-width: 768px) {
            .download-grid, .image-gallery {
                grid-template-columns: 1fr;
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
            <li><a href="noticias">Notícias</a></li>
            <li><a href="tour">Tour</a></li>
            <li><a href="contato">Contato</a></li>
        </ul>
        <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span></span><span></span><span></span>
        </div>
    </nav>

    <section class="page-header">
        <h1 class="page-title">Mídia Kit e Materiais</h1>
        <p class="page-subtitle">Recursos visuais e documentação oficial da Arena BRB</p>
    </section>

    <div class="media-kit-container">
        <div class="highlight-box" style="margin-bottom: 40px;">
            <p><strong>Para jornalistas e veículos de comunicação:</strong> Todos os materiais disponíveis nesta página podem ser utilizados livremente para fins editoriais, desde que creditados à Arena BRB Mané Garrincha. Para uso comercial, entre em contato com nossa <a href="imprensa" style="color: var(--color-primary); font-weight: 600;">assessoria de imprensa</a>.</p>
        </div>

        <!-- Logotipos -->
        <div class="media-section">
            <h2>Logotipos Oficiais</h2>
            <p>Logotipos em alta resolução nos formatos PNG, SVG e AI</p>

            <div class="download-grid">
                <div class="download-card" onclick="downloadFile('logo-completo')">
                    <div class="download-icon">
                        <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                    <h3>Logo Completo</h3>
                    <p class="description">Logotipo principal com naming</p>
                    <p class="file-info">PNG, SVG, AI • 2.4 MB</p>
                    <button class="download-btn">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download
                    </button>
                </div>

                <div class="download-card" onclick="downloadFile('logo-simbolo')">
                    <div class="download-icon">
                        <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 6v6l4 2"/>
                        </svg>
                    </div>
                    <h3>Símbolo</h3>
                    <p class="description">Versão reduzida para ícone</p>
                    <p class="file-info">PNG, SVG • 1.2 MB</p>
                    <button class="download-btn">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download
                    </button>
                </div>

                <div class="download-card" onclick="downloadFile('logo-horizontal')">
                    <div class="download-icon">
                        <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="7" width="20" height="10" rx="2"/>
                        </svg>
                    </div>
                    <h3>Versão Horizontal</h3>
                    <p class="description">Para aplicações em largura</p>
                    <p class="file-info">PNG, SVG, AI • 2.1 MB</p>
                    <button class="download-btn">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download
                    </button>
                </div>

                <div class="download-card" onclick="downloadFile('manual-marca')">
                    <div class="download-icon">
                        <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                    </div>
                    <h3>Manual de Marca</h3>
                    <p class="description">Guia completo de aplicação</p>
                    <p class="file-info">PDF • 8.5 MB</p>
                    <button class="download-btn">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download
                    </button>
                </div>
            </div>
        </div>

        <!-- Fotos Oficiais -->
        <div class="media-section">
            <h2>Fotos Oficiais</h2>
            <p>Imagens em alta resolução do complexo Arena BRB</p>

            <div class="image-gallery">
                <div class="gallery-item" onclick="downloadFile('foto-1')">
                    <div class="gallery-placeholder">
                        <svg width="80" height="80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                    <div class="gallery-item-info">
                        <div class="gallery-item-title">Vista Aérea Estádio</div>
                        <div class="gallery-item-size">4K • 12 MB • JPG</div>
                    </div>
                </div>

                <div class="gallery-item" onclick="downloadFile('foto-2')">
                    <div class="gallery-placeholder">
                        <svg width="80" height="80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                    <div class="gallery-item-info">
                        <div class="gallery-item-title">Fachada Principal</div>
                        <div class="gallery-item-size">4K • 10 MB • JPG</div>
                    </div>
                </div>

                <div class="gallery-item" onclick="downloadFile('foto-3')">
                    <div class="gallery-placeholder">
                        <svg width="80" height="80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                    <div class="gallery-item-info">
                        <div class="gallery-item-title">Interior Ginásio</div>
                        <div class="gallery-item-size">4K • 11 MB • JPG</div>
                    </div>
                </div>

                <div class="gallery-item" onclick="downloadFile('foto-4')">
                    <div class="gallery-placeholder">
                        <svg width="80" height="80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                    <div class="gallery-item-info">
                        <div class="gallery-item-title">Arquibancadas</div>
                        <div class="gallery-item-size">4K • 9 MB • JPG</div>
                    </div>
                </div>

                <div class="gallery-item" onclick="downloadFile('foto-5')">
                    <div class="gallery-placeholder">
                        <svg width="80" height="80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                    <div class="gallery-item-info">
                        <div class="gallery-item-title">Esfera Cultural</div>
                        <div class="gallery-item-size">4K • 13 MB • JPG</div>
                    </div>
                </div>

                <div class="gallery-item" onclick="downloadFile('foto-6')">
                    <div class="gallery-placeholder">
                        <svg width="80" height="80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                    <div class="gallery-item-info">
                        <div class="gallery-item-title">Vista Noturna</div>
                        <div class="gallery-item-size">4K • 14 MB • JPG</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documentação Técnica -->
        <div class="media-section">
            <h2>Documentação Técnica e Institucional</h2>
            <p>Informações oficiais, releases e materiais informativos</p>

            <div class="download-grid">
                <div class="download-card" onclick="downloadFile('fact-sheet')">
                    <div class="download-icon">
                        <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                    </div>
                    <h3>Fact Sheet</h3>
                    <p class="description">Dados técnicos do complexo</p>
                    <p class="file-info">PDF • 2.1 MB</p>
                    <button class="download-btn">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download
                    </button>
                </div>

                <div class="download-card" onclick="downloadFile('apresentacao')">
                    <div class="download-icon">
                        <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                            <line x1="8" y1="21" x2="16" y2="21"/>
                            <line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                    </div>
                    <h3>Apresentação Institucional</h3>
                    <p class="description">Deck completo sobre a Arena</p>
                    <p class="file-info">PDF • 15.3 MB</p>
                    <button class="download-btn">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download
                    </button>
                </div>

                <div class="download-card" onclick="downloadFile('historico')">
                    <div class="download-icon">
                        <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <h3>Histórico e Conquistas</h3>
                    <p class="description">Linha do tempo da Arena BRB</p>
                    <p class="file-info">PDF • 5.7 MB</p>
                    <button class="download-btn">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download
                    </button>
                </div>

                <div class="download-card" onclick="downloadFile('releases')">
                    <div class="download-icon">
                        <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 19l7-7 3 3-7 7-3-3z"/>
                            <path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/>
                            <path d="M2 2l7.586 7.586"/>
                            <circle cx="11" cy="11" r="2"/>
                        </svg>
                    </div>
                    <h3>Releases Recentes</h3>
                    <p class="description">Últimas notas à imprensa</p>
                    <p class="file-info">ZIP • 4.2 MB</p>
                    <button class="download-btn">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download
                    </button>
                </div>
            </div>
        </div>

        <!-- Download Completo -->
        <div style="text-align: center; margin-top: 60px; padding: 40px; background: var(--color-card-bg); border-radius: 16px; border: 1px solid var(--color-border);">
            <h2 style="margin-bottom: 16px;">Download Completo do Mídia Kit</h2>
            <p style="color: var(--color-text-secondary); margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
                Baixe todos os materiais de uma vez em um arquivo compactado
            </p>
            <button onclick="downloadFile('midia-kit-completo')" class="download-all-btn">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Download Mídia Kit Completo (52 MB)
            </button>
        </div>

        <!-- Informações Adicionais -->
        <div class="info-box" style="margin-top: 40px;">
            <h4>Precisa de mais materiais?</h4>
            <p>Se você precisa de imagens específicas, vídeos, entrevistas ou outros materiais não disponíveis aqui, entre em contato com nossa assessoria de imprensa:</p>
            <p style="margin-top: 12px;">
                <strong>E-mail:</strong> <a href="mailto:imprensa@arenabrb.com.br" style="color: var(--color-primary); font-weight: 600;">imprensa@arenabrb.com.br</a><br>
                <strong>Telefone:</strong> (61) 3333-4444<br>
                <a href="imprensa" style="color: var(--color-primary); font-weight: 600;">Formulário de contato →</a>
            </p>
        </div>
    </div>

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
            <div class="footer-col"><h4>Operação</h4><ul><li><a href="contato">Contato Comercial</a></li><li><a href="regulamento-acesso">Regulamento de Acesso</a></li><li><a href="codigo-conduta">Código de Conduta</a></li></ul></div>
            <div class="footer-col"><h4>Legal</h4><ul><li><a href="termos-uso">Termos de Uso</a></li><li><a href="politica-privacidade">Política de Privacidade</a></li><li><a href="politica-cookies">Política de Cookies</a></li></ul></div>
        </div>
        <div class="footer-bottom"><p>&copy; <?php echo date('Y'); ?> Arena BRB. Todos os direitos reservados.</p></div>
    </footer>

    <script src="assets/js/main.js"></script>
    <script>
        function downloadFile(fileId) {
            // TODO: Implementar download real dos arquivos
            console.log('Download do arquivo:', fileId);
            alert('Download iniciado!\n\nArquivo: ' + fileId + '\n\nEm produção, este arquivo será baixado automaticamente.');
        }
    </script>
</body>
</html>
