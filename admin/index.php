<?php
/**
 * Dashboard - Painel Administrativo Arena BRB
 */

require_once 'includes/auth-check.php';
require_once '../config/database.php';
require_once '../includes/db/Database.php';
require_once '../includes/models/Evento.php';
require_once '../includes/models/Post.php';
require_once '../includes/helpers/functions.php';

$pageTitle = 'Dashboard';

// Buscar estatísticas
$eventoModel = new Evento();
$postModel = new Post();

$totalEventos = $eventoModel->contarTotal(['status' => 'publicado']);
$totalEventosRascunho = $eventoModel->contarTotal(['status' => 'rascunho']);
$totalPosts = $postModel->contarTotal(['status' => 'publicado']);
$totalPostsRascunho = $postModel->contarTotal(['status' => 'rascunho']);

// Próximos eventos
$proximosEventos = $eventoModel->getPublicados(5);

// Últimas notícias
$ultimasPosts = $postModel->getPublicados(5);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - Arena BRB Admin</title>
    <link rel="stylesheet" href="/admin/assets/css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'includes/sidebar.php'; ?>

        <?php include 'includes/header.php'; ?>

        <main class="admin-content">
            <!-- Mensagem de Boas-vindas -->
            <div class="alert alert-success">
                <span>👋</span>
                <div>
                    <strong>Bem-vindo, <?= htmlspecialchars($ADMIN_NOME) ?>!</strong><br>
                    Último login: <?= date('d/m/Y às H:i') ?>
                </div>
            </div>

            <!-- Cards de Estatísticas -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        📅
                    </div>
                    <div class="stat-info">
                        <h3><?= $totalEventos ?></h3>
                        <p>Eventos Publicados</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon warning">
                        📝
                    </div>
                    <div class="stat-info">
                        <h3><?= $totalEventosRascunho ?></h3>
                        <p>Eventos em Rascunho</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon success">
                        📰
                    </div>
                    <div class="stat-info">
                        <h3><?= $totalPosts ?></h3>
                        <p>Notícias Publicadas</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon info">
                        ✍️
                    </div>
                    <div class="stat-info">
                        <h3><?= $totalPostsRascunho ?></h3>
                        <p>Notícias em Rascunho</p>
                    </div>
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Ações Rápidas</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="/admin/eventos/criar.php" class="btn btn-primary">
                            <span>➕</span> Novo Evento
                        </a>
                        <a href="/admin/noticias/criar.php" class="btn btn-success">
                            <span>➕</span> Nova Notícia
                        </a>
                        <a href="/admin/categorias/index.php" class="btn btn-secondary">
                            <span>🏷️</span> Gerenciar Categorias
                        </a>
                        <a href="/admin/locais/index.php" class="btn btn-secondary">
                            <span>📍</span> Gerenciar Locais
                        </a>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <!-- Próximos Eventos -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Próximos Eventos</h2>
                        <a href="/admin/eventos/index.php" class="btn btn-sm btn-primary">Ver Todos</a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($proximosEventos)): ?>
                            <p style="text-align: center; color: #6b7280; padding: 2rem;">
                                Nenhum evento próximo cadastrado.
                            </p>
                        <?php else: ?>
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Evento</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($proximosEventos as $evento): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($evento['titulo']) ?></strong><br>
                                            <small style="color: #6b7280;"><?= htmlspecialchars($evento['local_nome']) ?></small>
                                        </td>
                                        <td>
                                            <?= formatarData($evento['data_evento']) ?><br>
                                            <small><?= formatarHora($evento['hora_evento']) ?></small>
                                        </td>
                                        <td>
                                            <span class="badge status-<?= $evento['status'] ?>">
                                                <?= ucfirst($evento['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Últimas Notícias -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Últimas Notícias</h2>
                        <a href="/admin/noticias/index.php" class="btn btn-sm btn-success">Ver Todas</a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($ultimasPosts)): ?>
                            <p style="text-align: center; color: #6b7280; padding: 2rem;">
                                Nenhuma notícia cadastrada.
                            </p>
                        <?php else: ?>
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ultimasPosts as $post): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($post['titulo']) ?></strong><br>
                                            <small style="color: #6b7280;"><?= htmlspecialchars($post['categoria_nome'] ?? 'Sem categoria') ?></small>
                                        </td>
                                        <td>
                                            <?= formatarDataHora($post['criado_em']) ?>
                                        </td>
                                        <td>
                                            <span class="badge status-<?= $post['status'] ?>">
                                                <?= ucfirst($post['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
