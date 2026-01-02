<?php
/**
 * Página de Eventos - Arena BRB
 * Listagem completa de eventos com filtros avançados
 */

require_once 'config/database.php';
require_once 'includes/db/Database.php';
require_once 'includes/models/Evento.php';
require_once 'includes/models/Categoria.php';
require_once 'includes/models/Local.php';
require_once 'includes/helpers/functions.php';

$eventoModel = new Evento();
$categoriaModel = new Categoria();
$localModel = new Local();

// Parâmetros de filtro
$periodoFiltro = isset($_GET['periodo']) ? $_GET['periodo'] : 'semana'; // dia, semana, mes
$categoriaFiltro = isset($_GET['categoria']) ? (int)$_GET['categoria'] : null;
$localFiltro = isset($_GET['local']) ? (int)$_GET['local'] : null;
$ordenacao = isset($_GET['ordem']) ? $_GET['ordem'] : 'data'; // data, nome

// Buscar evento em destaque
$eventoDestaque = $eventoModel->getDestaques(1);
$eventoDestaque = !empty($eventoDestaque) ? $eventoDestaque[0] : null;

// Calcular período de datas
$hoje = new DateTime();
$dataInicio = clone $hoje;
$dataFim = clone $hoje;

switch ($periodoFiltro) {
    case 'dia':
        // Hoje
        $dataFim->modify('+1 day');
        break;
    case 'semana':
        // Próximos 7 dias
        $dataFim->modify('+7 days');
        break;
    case 'mes':
        // Próximos 30 dias
        $dataFim->modify('+30 days');
        break;
}

// Preparar filtros para busca
$filtros = [
    'status' => 'publicado',
    'data_inicio' => $dataInicio->format('Y-m-d'),
    'data_fim' => $dataFim->format('Y-m-d')
];

if ($categoriaFiltro) {
    $filtros['categoria_id'] = $categoriaFiltro;
}

if ($localFiltro) {
    $filtros['local_id'] = $localFiltro;
}

// Buscar eventos do período
$eventos = $eventoModel->getTodos(null, 0, $filtros);

// Ordenação
if ($ordenacao === 'nome') {
    usort($eventos, function($a, $b) {
        return strcmp($a['titulo'], $b['titulo']);
    });
} else {
    // Já vem ordenado por data do banco
}

// Buscar categorias e locais para filtros
$categorias = $categoriaModel->getByTipo('evento');
$locais = $localModel->getTodosAtivos();

// Meses em português
$mesesPt = [
    1 => 'JAN', 2 => 'FEV', 3 => 'MAR', 4 => 'ABR',
    5 => 'MAI', 6 => 'JUN', 7 => 'JUL', 8 => 'AGO',
    9 => 'SET', 10 => 'OUT', 11 => 'NOV', 12 => 'DEZ'
];

$mesesCompletos = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Confira todos os eventos da Arena BRB Mané Garrincha - Shows, jogos e experiências imperdíveis em Brasília">
    <meta name="keywords" content="Arena BRB, eventos, shows, Brasília, ingressos">
    <meta name="author" content="Arena BRB Mané Garrincha">

    <title>Eventos - Arena BRB Mané Garrincha</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://i.imgur.com/xqyCXoQ.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/eventos.css">
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
            <li><a href="eventos" class="active">Eventos</a></li>
            <li><a href="espacos">Espaços</a></li>
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
        <h1 class="page-title">Eventos</h1>
    </section>

    <!-- Evento em Destaque -->
    <?php if ($eventoDestaque): ?>
        <?php
        $dataDestaque = new DateTime($eventoDestaque['data_evento']);
        $diaDestaque = $dataDestaque->format('d');
        $mesDestaque = $mesesCompletos[(int)$dataDestaque->format('m')];
        $anoDestaque = $dataDestaque->format('Y');
        ?>
        <section class="featured-event-section">
            <div class="featured-event-card">
                <div class="featured-event-image <?= empty($eventoDestaque['imagem_destaque']) ? 'no-image' : '' ?>" <?= !empty($eventoDestaque['imagem_destaque']) ? 'style="background-image: url(\'/' . htmlspecialchars($eventoDestaque['imagem_destaque']) . '\');"' : '' ?>>
                    <?php if (empty($eventoDestaque['imagem_destaque'])): ?>
                        <svg class="placeholder-icon" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="2" y="7" width="20" height="15" rx="2"/>
                            <path d="M17 2l-3 5-3-5M9 22v-5M15 22v-5"/>
                        </svg>
                    <?php endif; ?>
                </div>
                <div class="featured-event-content">
                    <h2 class="featured-event-title"><?= htmlspecialchars($eventoDestaque['titulo']) ?></h2>
                    <div class="featured-event-badges">
                        <span class="featured-badge featured-badge-category" style="background: <?= htmlspecialchars($eventoDestaque['categoria_cor'] ?? '#8e44ad') ?>;">
                            <?= htmlspecialchars($eventoDestaque['categoria_nome']) ?>
                        </span>
                        <span class="featured-badge featured-badge-date">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <path d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                            <?= $diaDestaque ?> de <?= $mesDestaque ?>, <?= $anoDestaque ?>
                        </span>
                    </div>
                    <?php if ($eventoDestaque['descricao']): ?>
                        <p class="featured-event-description">
                            <?= htmlspecialchars($eventoDestaque['descricao']) ?>
                        </p>
                    <?php endif; ?>
                    <a href="<?= htmlspecialchars($eventoDestaque['link_ingressos']) ?>" target="_blank" class="featured-event-cta">
                        Comprar Ingressos
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Filtros -->
    <section class="filters-section">
        <form action="eventos" method="GET" class="filters-container">
            <div class="filter-group">
                <label class="filter-label">Período</label>
                <select name="periodo" class="filter-select" onchange="this.form.submit()">
                    <option value="dia" <?= $periodoFiltro === 'dia' ? 'selected' : '' ?>>Hoje</option>
                    <option value="semana" <?= $periodoFiltro === 'semana' ? 'selected' : '' ?>>Esta Semana</option>
                    <option value="mes" <?= $periodoFiltro === 'mes' ? 'selected' : '' ?>>Este Mês</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Tipo</label>
                <select name="categoria" class="filter-select" onchange="this.form.submit()">
                    <option value="">Todas as categorias</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $categoriaFiltro == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Local</label>
                <select name="local" class="filter-select" onchange="this.form.submit()">
                    <option value="">Todos os locais</option>
                    <?php foreach ($locais as $local): ?>
                        <option value="<?= $local['id'] ?>" <?= $localFiltro == $local['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($local['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">Ordenar por</label>
                <select name="ordem" class="filter-select" onchange="this.form.submit()">
                    <option value="data" <?= $ordenacao === 'data' ? 'selected' : '' ?>>Data</option>
                    <option value="nome" <?= $ordenacao === 'nome' ? 'selected' : '' ?>>Nome</option>
                </select>
            </div>

            <div class="filter-group" style="display: flex; align-items: flex-end;">
                <a href="eventos" class="filter-select" style="text-align: center; text-decoration: none; padding: 0.75rem; background: var(--border); cursor: pointer;">
                    Limpar Filtros
                </a>
            </div>
        </form>
    </section>

    <!-- Lista de Eventos -->
    <section class="events-list-section">
        <div class="section-title-bar">
            <h2>
                <?php
                if ($periodoFiltro === 'dia') {
                    echo 'Eventos de Hoje';
                } elseif ($periodoFiltro === 'semana') {
                    echo 'Eventos da Semana';
                } else {
                    echo 'Eventos do Mês';
                }
                ?>
            </h2>
            <span class="count"><?= count($eventos) ?> evento(s) encontrado(s)</span>
        </div>

        <?php if (!empty($eventos)): ?>
            <div class="events-grid">
                <?php foreach ($eventos as $evento): ?>
                    <?php
                    $dataEvento = new DateTime($evento['data_evento']);
                    $dia = $dataEvento->format('d');
                    $mesNum = (int)$dataEvento->format('m');
                    $mes = $mesesPt[$mesNum];
                    ?>
                    <div class="event-card">
                        <div class="event-img <?= empty($evento['imagem_destaque']) ? 'no-image' : '' ?>" <?= !empty($evento['imagem_destaque']) ? 'style="background-image: url(\'/' . htmlspecialchars($evento['imagem_destaque']) . '\');"' : '' ?>>
                            <?php if (empty($evento['imagem_destaque'])): ?>
                                <svg class="placeholder-icon" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                                    <rect x="2" y="7" width="20" height="15" rx="2"/>
                                    <path d="M17 2l-3 5-3-5M9 22v-5M15 22v-5"/>
                                </svg>
                            <?php endif; ?>
                            <div class="event-date">
                                <span class="day"><?= $dia ?></span>
                                <span class="month"><?= $mes ?></span>
                            </div>
                            <span class="event-cat" style="background: <?= htmlspecialchars($evento['categoria_cor'] ?? '#8e44ad') ?>;">
                                <?= htmlspecialchars($evento['categoria_nome']) ?>
                            </span>
                        </div>
                        <div class="event-content">
                            <h3 class="event-title"><?= htmlspecialchars($evento['titulo']) ?></h3>
                            <p class="event-venue">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                <?= htmlspecialchars($evento['local_nome']) ?>
                            </p>
                            <?php if ($evento['descricao']): ?>
                                <p class="event-desc">
                                    <?= htmlspecialchars($evento['descricao']) ?>
                                </p>
                            <?php endif; ?>
                            <div class="event-footer">
                                <span class="event-price">
                                    A partir de
                                    <strong>R$ <?= number_format($evento['preco_minimo'], 2, ',', '.') ?></strong>
                                </span>
                                <a href="<?= htmlspecialchars($evento['link_ingressos']) ?>" target="_blank" class="event-btn">Comprar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-events">
                <svg class="no-events-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                <h3>Nenhum evento encontrado</h3>
                <p>Não há eventos programados para este período. Tente ajustar os filtros ou volte mais tarde.</p>
                <a href="eventos" class="btn-primary">Ver todos os eventos</a>
            </div>
        <?php endif; ?>
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
