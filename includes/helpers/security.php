<?php
/**
 * Helper: Security
 * Funções de segurança (XSS, CSRF, validações)
 */

/**
 * Sanitizar string para prevenir XSS
 * @param string $string
 * @return string
 */
function sanitizeString($string) {
    return htmlspecialchars(strip_tags(trim($string)), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitizar HTML (permitir tags seguras)
 * @param string $html
 * @return string
 */
function sanitizeHTML($html) {
    // Lista de tags permitidas
    $allowed_tags = '<p><br><strong><b><em><i><u><a><ul><ol><li><h1><h2><h3><h4><h5><h6><img><blockquote><code><pre>';

    $html = strip_tags($html, $allowed_tags);

    // Remover atributos perigosos
    $html = preg_replace('/<([^>]+) on\w+="[^"]*"/i', '<$1', $html);

    return $html;
}

/**
 * Validar email
 * @param string $email
 * @return bool
 */
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validar URL
 * @param string $url
 * @return bool
 */
function validarURL($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

/**
 * Validar data (formato Y-m-d)
 * @param string $date
 * @return bool
 */
function validarData($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

/**
 * Validar hora (formato H:i ou H:i:s)
 * @param string $time
 * @return bool
 */
function validarHora($time) {
    $t1 = DateTime::createFromFormat('H:i', $time);
    $t2 = DateTime::createFromFormat('H:i:s', $time);
    return ($t1 && $t1->format('H:i') === $time) || ($t2 && $t2->format('H:i:s') === $time);
}

/**
 * Gerar token CSRF
 * @return string
 */
function gerarCSRFToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/**
 * Verificar token CSRF
 * @param string $token
 * @return bool
 */
function verificarCSRFToken($token) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token'])) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Limpar token CSRF
 */
function limparCSRFToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION['csrf_token']);
}

/**
 * Obter IP do cliente
 * @return string
 */
function getClientIP() {
    $ip = '';

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    }

    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

/**
 * Obter User Agent do cliente
 * @return string
 */
function getClientUserAgent() {
    return $_SERVER['HTTP_USER_AGENT'] ?? '';
}

/**
 * Registrar log de atividade
 * @param int $usuarioId
 * @param string $acao
 * @param string|null $tabela
 * @param int|null $registroId
 * @param string|null $detalhes
 */
function registrarLog($usuarioId, $acao, $tabela = null, $registroId = null, $detalhes = null) {
    try {
        $db = Database::getInstance()->getConnection();

        $sql = "INSERT INTO logs_atividade (
                    usuario_id, acao, tabela, registro_id, detalhes, ip, user_agent
                ) VALUES (
                    :usuario_id, :acao, :tabela, :registro_id, :detalhes, :ip, :user_agent
                )";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            'usuario_id' => $usuarioId,
            'acao' => $acao,
            'tabela' => $tabela,
            'registro_id' => $registroId,
            'detalhes' => $detalhes,
            'ip' => getClientIP(),
            'user_agent' => getClientUserAgent()
        ]);
    } catch (Exception $e) {
        // Falha silenciosa no log para não interromper a aplicação
        error_log("Erro ao registrar log: " . $e->getMessage());
    }
}

/**
 * Verificar se usuário está autenticado
 * @return bool
 */
function isAuthenticated() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return !empty($_SESSION['admin_id']);
}

/**
 * Verificar nível de acesso do usuário
 * @param string $nivelRequerido ('admin', 'editor', 'moderador')
 * @return bool
 */
function verificarNivelAcesso($nivelRequerido) {
    if (!isAuthenticated()) {
        return false;
    }

    $niveis = [
        'moderador' => 1,
        'editor' => 2,
        'admin' => 3
    ];

    $nivelUsuario = $niveis[$_SESSION['admin_nivel']] ?? 0;
    $nivelNecessario = $niveis[$nivelRequerido] ?? 999;

    return $nivelUsuario >= $nivelNecessario;
}

/**
 * Redirecionar para página
 * @param string $url
 * @param int $statusCode
 */
function redirect($url, $statusCode = 302) {
    header("Location: {$url}", true, $statusCode);
    exit;
}

/**
 * Definir mensagem flash
 * @param string $tipo ('success', 'error', 'warning', 'info')
 * @param string $mensagem
 */
function setFlashMessage($tipo, $mensagem) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['flash_message'] = [
        'tipo' => $tipo,
        'mensagem' => $mensagem
    ];
}

/**
 * Obter e limpar mensagem flash
 * @return array|null
 */
function getFlashMessage() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }

    return null;
}
