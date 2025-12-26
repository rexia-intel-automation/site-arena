<?php
/**
 * Helper: Functions
 * Funções auxiliares gerais
 */

/**
 * Formatar data para exibição (d/m/Y)
 * @param string $date Data no formato Y-m-d
 * @return string
 */
function formatarData($date) {
    if (empty($date)) {
        return '';
    }

    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d ? $d->format('d/m/Y') : $date;
}

/**
 * Formatar data e hora para exibição
 * @param string $datetime Datetime no formato Y-m-d H:i:s
 * @return string
 */
function formatarDataHora($datetime) {
    if (empty($datetime)) {
        return '';
    }

    $d = DateTime::createFromFormat('Y-m-d H:i:s', $datetime);
    return $d ? $d->format('d/m/Y às H:i') : $datetime;
}

/**
 * Formatar hora para exibição
 * @param string $time Hora no formato H:i:s ou H:i
 * @return string
 */
function formatarHora($time) {
    if (empty($time)) {
        return '';
    }

    $t = DateTime::createFromFormat('H:i:s', $time);
    if (!$t) {
        $t = DateTime::createFromFormat('H:i', $time);
    }

    return $t ? $t->format('H:i') : $time;
}

/**
 * Formatar preço para exibição (R$ 99,99)
 * @param float $preco
 * @return string
 */
function formatarPreco($preco) {
    return 'R$ ' . number_format($preco, 2, ',', '.');
}

/**
 * Truncar texto
 * @param string $text
 * @param int $length
 * @param string $suffix
 * @return string
 */
function truncarTexto($text, $length = 150, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }

    return substr($text, 0, $length) . $suffix;
}

/**
 * Obter iniciais de um nome
 * @param string $nome
 * @return string
 */
function getIniciais($nome) {
    $palavras = explode(' ', $nome);
    $iniciais = '';

    foreach ($palavras as $palavra) {
        if (!empty($palavra)) {
            $iniciais .= mb_strtoupper(mb_substr($palavra, 0, 1));
        }
    }

    return mb_substr($iniciais, 0, 2);
}

/**
 * Calcular tempo decorrido (ex: "há 2 horas")
 * @param string $datetime
 * @return string
 */
function tempoDecorrido($datetime) {
    if (empty($datetime)) {
        return '';
    }

    $agora = new DateTime();
    $data = new DateTime($datetime);
    $intervalo = $agora->diff($data);

    if ($intervalo->y > 0) {
        return $intervalo->y === 1 ? 'há 1 ano' : "há {$intervalo->y} anos";
    }

    if ($intervalo->m > 0) {
        return $intervalo->m === 1 ? 'há 1 mês' : "há {$intervalo->m} meses";
    }

    if ($intervalo->d > 0) {
        return $intervalo->d === 1 ? 'há 1 dia' : "há {$intervalo->d} dias";
    }

    if ($intervalo->h > 0) {
        return $intervalo->h === 1 ? 'há 1 hora' : "há {$intervalo->h} horas";
    }

    if ($intervalo->i > 0) {
        return $intervalo->i === 1 ? 'há 1 minuto' : "há {$intervalo->i} minutos";
    }

    return 'agora mesmo';
}

/**
 * Calcular tempo até um evento futuro (ex: "em 2 dias")
 * @param string $datetime
 * @return string
 */
function tempoAte($datetime) {
    if (empty($datetime)) {
        return '';
    }

    $agora = new DateTime();
    $data = new DateTime($datetime);

    // Se a data já passou, retornar string vazia
    if ($data < $agora) {
        return 'Evento encerrado';
    }

    $intervalo = $agora->diff($data);

    if ($intervalo->y > 0) {
        return $intervalo->y === 1 ? 'em 1 ano' : "em {$intervalo->y} anos";
    }

    if ($intervalo->m > 0) {
        return $intervalo->m === 1 ? 'em 1 mês' : "em {$intervalo->m} meses";
    }

    if ($intervalo->d > 0) {
        return $intervalo->d === 1 ? 'em 1 dia' : "em {$intervalo->d} dias";
    }

    if ($intervalo->h > 0) {
        return $intervalo->h === 1 ? 'em 1 hora' : "em {$intervalo->h} horas";
    }

    if ($intervalo->i > 0) {
        return $intervalo->i === 1 ? 'em 1 minuto' : "em {$intervalo->i} minutos";
    }

    return 'em instantes';
}

/**
 * Gerar paginação HTML
 * @param int $paginaAtual
 * @param int $totalPaginas
 * @param string $baseUrl
 * @return string
 */
function gerarPaginacao($paginaAtual, $totalPaginas, $baseUrl) {
    if ($totalPaginas <= 1) {
        return '';
    }

    $html = '<div class="pagination">';

    // Botão "Anterior"
    if ($paginaAtual > 1) {
        $html .= '<a href="' . $baseUrl . '?pagina=' . ($paginaAtual - 1) . '" class="pagination-btn">« Anterior</a>';
    }

    // Páginas
    $inicio = max(1, $paginaAtual - 2);
    $fim = min($totalPaginas, $paginaAtual + 2);

    if ($inicio > 1) {
        $html .= '<a href="' . $baseUrl . '?pagina=1">1</a>';
        if ($inicio > 2) {
            $html .= '<span class="pagination-ellipsis">...</span>';
        }
    }

    for ($i = $inicio; $i <= $fim; $i++) {
        $active = ($i === $paginaAtual) ? ' class="active"' : '';
        $html .= '<a href="' . $baseUrl . '?pagina=' . $i . '"' . $active . '>' . $i . '</a>';
    }

    if ($fim < $totalPaginas) {
        if ($fim < $totalPaginas - 1) {
            $html .= '<span class="pagination-ellipsis">...</span>';
        }
        $html .= '<a href="' . $baseUrl . '?pagina=' . $totalPaginas . '">' . $totalPaginas . '</a>';
    }

    // Botão "Próximo"
    if ($paginaAtual < $totalPaginas) {
        $html .= '<a href="' . $baseUrl . '?pagina=' . ($paginaAtual + 1) . '" class="pagination-btn">Próximo »</a>';
    }

    $html .= '</div>';

    return $html;
}

/**
 * Debug: Imprimir variável formatada
 * @param mixed $var
 * @param bool $die
 */
function dd($var, $die = true) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';

    if ($die) {
        die();
    }
}

/**
 * Verificar se string contém outra string (case insensitive)
 * @param string $haystack
 * @param string $needle
 * @return bool
 */
function contem($haystack, $needle) {
    return mb_stripos($haystack, $needle) !== false;
}

/**
 * Gerar cor aleatória em hexadecimal
 * @return string
 */
function corAleatoria() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

/**
 * Calcular contraste de cor (retorna 'light' ou 'dark')
 * @param string $hexColor
 * @return string
 */
function contrasteCor($hexColor) {
    // Remover #
    $hex = str_replace('#', '', $hexColor);

    // Converter para RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // Calcular luminosidade
    $luminosity = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

    return $luminosity > 128 ? 'light' : 'dark';
}
