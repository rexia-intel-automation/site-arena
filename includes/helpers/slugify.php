<?php
/**
 * Helper: Slugify
 * Converte strings em slugs amigáveis para URLs
 */

/**
 * Converte uma string em slug
 * @param string $text
 * @return string
 */
function slugify($text) {
    // Substituir caracteres acentuados
    $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);

    // Converter para minúsculas
    $text = strtolower($text);

    // Substituir espaços e caracteres especiais por hífen
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);

    // Remover hífens duplicados
    $text = preg_replace('/-+/', '-', $text);

    // Remover hífens do início e fim
    $text = trim($text, '-');

    return $text;
}

/**
 * Gerar slug único verificando no banco de dados
 * @param string $text
 * @param string $table
 * @param int|null $excluirId
 * @return string
 */
function slugifyUnique($text, $table, $excluirId = null) {
    $db = Database::getInstance()->getConnection();
    $slug = slugify($text);
    $slugOriginal = $slug;
    $contador = 1;

    while (true) {
        $sql = "SELECT COUNT(*) as total FROM {$table} WHERE slug = :slug";

        if ($excluirId) {
            $sql .= " AND id != :id";
        }

        $stmt = $db->prepare($sql);
        $params = ['slug' => $slug];

        if ($excluirId) {
            $params['id'] = $excluirId;
        }

        $stmt->execute($params);
        $result = $stmt->fetch();

        if ($result['total'] == 0) {
            return $slug;
        }

        $slug = $slugOriginal . '-' . $contador;
        $contador++;
    }
}
