<?php
/**
 * Seed: Categorias Padrão
 * Execute este arquivo uma vez para popular o banco com as categorias padrão
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/db/Database.php';
require_once __DIR__ . '/../../includes/models/Categoria.php';
require_once __DIR__ . '/../../includes/helpers/slugify.php';

$categoriaModel = new Categoria();

// Categorias padrão para eventos
$categoriasPadrao = [
    [
        'nome' => 'Show',
        'slug' => 'show',
        'descricao' => 'Shows musicais e apresentações artísticas',
        'tipo' => 'evento',
        'cor' => '#e74c3c',
        'icone' => 'music',
        'ordem' => 1,
        'ativo' => 1
    ],
    [
        'nome' => 'Futebol',
        'slug' => 'futebol',
        'descricao' => 'Jogos e campeonatos de futebol',
        'tipo' => 'evento',
        'cor' => '#27ae60',
        'icone' => 'football',
        'ordem' => 2,
        'ativo' => 1
    ],
    [
        'nome' => 'Basquete',
        'slug' => 'basquete',
        'descricao' => 'Jogos e campeonatos de basquete',
        'tipo' => 'evento',
        'cor' => '#f39c12',
        'icone' => 'basketball',
        'ordem' => 3,
        'ativo' => 1
    ],
    [
        'nome' => 'Festa',
        'slug' => 'festa',
        'descricao' => 'Festas e celebrações',
        'tipo' => 'evento',
        'cor' => '#9b59b6',
        'icone' => 'party-popper',
        'ordem' => 4,
        'ativo' => 1
    ],
    [
        'nome' => 'Festival',
        'slug' => 'festival',
        'descricao' => 'Festivais culturais e artísticos',
        'tipo' => 'evento',
        'cor' => '#e67e22',
        'icone' => 'music-2',
        'ordem' => 5,
        'ativo' => 1
    ],
    [
        'nome' => 'Feira',
        'slug' => 'feira',
        'descricao' => 'Feiras comerciais e exposições',
        'tipo' => 'evento',
        'cor' => '#16a085',
        'icone' => 'store',
        'ordem' => 6,
        'ativo' => 1
    ],
    [
        'nome' => 'Religioso',
        'slug' => 'religioso',
        'descricao' => 'Eventos religiosos e espirituais',
        'tipo' => 'evento',
        'cor' => '#3498db',
        'icone' => 'church',
        'ordem' => 7,
        'ativo' => 1
    ],
    [
        'nome' => 'Corporativo',
        'slug' => 'corporativo',
        'descricao' => 'Eventos corporativos e empresariais',
        'tipo' => 'evento',
        'cor' => '#34495e',
        'icone' => 'briefcase',
        'ordem' => 8,
        'ativo' => 1
    ],
    [
        'nome' => 'Institucional',
        'slug' => 'institucional',
        'descricao' => 'Eventos institucionais e governamentais',
        'tipo' => 'evento',
        'cor' => '#2c3e50',
        'icone' => 'landmark',
        'ordem' => 9,
        'ativo' => 1
    ],
    [
        'nome' => 'Beneficente',
        'slug' => 'beneficente',
        'descricao' => 'Eventos beneficentes e solidários',
        'tipo' => 'evento',
        'cor' => '#e91e63',
        'icone' => 'heart',
        'ordem' => 10,
        'ativo' => 1
    ],
    [
        'nome' => 'Automotivo',
        'slug' => 'automotivo',
        'descricao' => 'Eventos automotivos e esportivos a motor',
        'tipo' => 'evento',
        'cor' => '#607d8b',
        'icone' => 'car',
        'ordem' => 11,
        'ativo' => 1
    ],
    [
        'nome' => 'Promocional',
        'slug' => 'promocional',
        'descricao' => 'Eventos promocionais e de marketing',
        'tipo' => 'evento',
        'cor' => '#ff9800',
        'icone' => 'megaphone',
        'ordem' => 12,
        'ativo' => 1
    ],
    [
        'nome' => 'Infantil',
        'slug' => 'infantil',
        'descricao' => 'Eventos infantis e para toda a família',
        'tipo' => 'evento',
        'cor' => '#ff5722',
        'icone' => 'baby',
        'ordem' => 13,
        'ativo' => 1
    ]
];

$sucesso = 0;
$erros = 0;
$jaExiste = 0;

echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Seed Categorias - Arena BRB</title>
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #f5f5f5;
        }
        .card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #3498db;
            padding-bottom: 0.5rem;
        }
        .log {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 4px;
            margin: 1rem 0;
            border-left: 4px solid #3498db;
        }
        .success {
            border-left-color: #27ae60;
            background: #d4edda;
        }
        .error {
            border-left-color: #e74c3c;
            background: #f8d7da;
        }
        .warning {
            border-left-color: #f39c12;
            background: #fff3cd;
        }
        .summary {
            background: #e8f4f8;
            padding: 1.5rem;
            border-radius: 6px;
            margin-top: 2rem;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 1rem;
        }
        .btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class='card'>
        <h1>🌱 Seed de Categorias Padrão</h1>
        <p>Inserindo categorias padrão no banco de dados...</p>\n\n";

foreach ($categoriasPadrao as $cat) {
    try {
        // Verificar se a categoria já existe (por slug)
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM categorias WHERE slug = :slug");
        $stmt->execute(['slug' => $cat['slug']]);
        $existe = $stmt->fetch();

        if ($existe) {
            echo "<div class='log warning'>⚠️ <strong>{$cat['nome']}</strong> - Já existe (pulando)</div>\n";
            $jaExiste++;
        } else {
            $categoriaModel->criar($cat);
            echo "<div class='log success'>✓ <strong>{$cat['nome']}</strong> - Criada com sucesso!</div>\n";
            $sucesso++;
        }
    } catch (Exception $e) {
        echo "<div class='log error'>❌ <strong>{$cat['nome']}</strong> - Erro: " . htmlspecialchars($e->getMessage()) . "</div>\n";
        $erros++;
    }
}

echo "
        <div class='summary'>
            <h2>📊 Resumo da Operação</h2>
            <ul>
                <li><strong>✅ Criadas:</strong> {$sucesso} categoria(s)</li>
                <li><strong>⚠️ Já existiam:</strong> {$jaExiste} categoria(s)</li>
                <li><strong>❌ Erros:</strong> {$erros} categoria(s)</li>
                <li><strong>📝 Total processado:</strong> " . count($categoriasPadrao) . " categoria(s)</li>
            </ul>
        </div>

        <div style='margin-top: 2rem; text-align: center;'>
            <a href='/admin/categorias/index.php' class='btn'>Ver Categorias no Admin</a>
        </div>
    </div>
</body>
</html>";
