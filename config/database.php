<?php
/**
 * Configurações de Banco de Dados
 * Arena BRB - Sistema de Gerenciamento
 */

// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'arena_brb');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Configurações de sessão
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Mudar para 1 em produção com HTTPS

// Configurações de erro (desabilitar em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configurações de upload
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024); // 5MB
define('UPLOAD_ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/webp']);
define('UPLOAD_PATH', __DIR__ . '/../public/assets/uploads/');

// Configurações de imagens de eventos (VALIDAÇÃO RÍGIDA)
define('EVENT_IMAGE_WIDTH', 475);
define('EVENT_IMAGE_HEIGHT', 180);
define('EVENT_IMAGE_MAX_SIZE', 2 * 1024 * 1024); // 2MB

// Configurações de imagens de notícias
define('NEWS_IMAGE_WIDTH', 800);
define('NEWS_IMAGE_HEIGHT', 450);
define('NEWS_IMAGE_MAX_SIZE', 3 * 1024 * 1024); // 3MB
