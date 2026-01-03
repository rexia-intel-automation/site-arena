<?php
/**
 * Helper: Upload
 * Gerenciamento de upload de arquivos com redimensionamento automático
 */

/**
 * Validar e fazer upload de imagem de evento com REDIMENSIONAMENTO AUTOMÁTICO
 * Aceita qualquer tamanho e redimensiona para 475x180px com crop center
 * @param array $file Array do $_FILES
 * @param string $nomeEvento Nome do evento para nomear o arquivo
 * @return array ['success' => bool, 'message' => string, 'file_path' => string|null]
 */
function uploadImagemEvento($file, $nomeEvento) {
    // Verificar se houve erro no upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [
            'success' => false,
            'message' => 'Erro no upload do arquivo',
            'file_path' => null
        ];
    }

    // Verificar tamanho do arquivo
    if ($file['size'] > EVENT_IMAGE_MAX_SIZE) {
        $maxMB = EVENT_IMAGE_MAX_SIZE / (1024 * 1024);
        return [
            'success' => false,
            'message' => "Arquivo muito grande. Tamanho máximo: {$maxMB}MB",
            'file_path' => null
        ];
    }

    // Verificar tipo MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, UPLOAD_ALLOWED_TYPES)) {
        return [
            'success' => false,
            'message' => 'Tipo de arquivo não permitido. Use apenas JPEG, PNG ou WebP',
            'file_path' => null
        ];
    }

    // Obter dimensões da imagem
    $imageInfo = getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return [
            'success' => false,
            'message' => 'Arquivo não é uma imagem válida',
            'file_path' => null
        ];
    }

    list($width, $height) = $imageInfo;

    // Validar dimensão mínima (não fazer upscale)
    if ($width < EVENT_IMAGE_WIDTH || $height < EVENT_IMAGE_HEIGHT) {
        return [
            'success' => false,
            'message' => "Imagem muito pequena. Dimensões mínimas: " . EVENT_IMAGE_WIDTH . "x" . EVENT_IMAGE_HEIGHT . "px. Imagem enviada: {$width}x{$height}px",
            'file_path' => null
        ];
    }

    // Gerar nome único para o arquivo
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $slug = slugify($nomeEvento);
    $fileName = $slug . '-' . time() . '.' . $extension;

    // Diretório de destino
    $uploadDir = UPLOAD_PATH . 'eventos/';

    // Criar diretório se não existir
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $tempPath = $uploadDir . 'temp_' . $fileName;
    $finalPath = $uploadDir . $fileName;

    // Mover arquivo temporário
    if (!move_uploaded_file($file['tmp_name'], $tempPath)) {
        return [
            'success' => false,
            'message' => 'Erro ao salvar arquivo no servidor',
            'file_path' => null
        ];
    }

    // Redimensionar com crop center
    $resizeResult = redimensionarImagemComCrop(
        $tempPath,
        $finalPath,
        EVENT_IMAGE_WIDTH,
        EVENT_IMAGE_HEIGHT
    );

    // Deletar arquivo temporário
    if (file_exists($tempPath)) {
        unlink($tempPath);
    }

    if (!$resizeResult) {
        return [
            'success' => false,
            'message' => 'Erro ao redimensionar imagem',
            'file_path' => null
        ];
    }

    // Retornar caminho relativo para o banco de dados
    $relativePath = '/public/assets/uploads/eventos/' . $fileName;

    $message = 'Upload realizado com sucesso';
    if ($width != EVENT_IMAGE_WIDTH || $height != EVENT_IMAGE_HEIGHT) {
        $message .= " (imagem redimensionada de {$width}x{$height}px para " . EVENT_IMAGE_WIDTH . "x" . EVENT_IMAGE_HEIGHT . "px)";
    }

    return [
        'success' => true,
        'message' => $message,
        'file_path' => $relativePath
    ];
}

/**
 * Validar e fazer upload de imagem de notícia com REDIMENSIONAMENTO AUTOMÁTICO
 * Aceita qualquer tamanho e redimensiona para 800x450px com crop center
 * @param array $file Array do $_FILES
 * @param string $tituloNoticia Título da notícia para nomear o arquivo
 * @return array ['success' => bool, 'message' => string, 'file_path' => string|null]
 */
function uploadImagemNoticia($file, $tituloNoticia) {
    // Verificar se houve erro no upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [
            'success' => false,
            'message' => 'Erro no upload do arquivo',
            'file_path' => null
        ];
    }

    // Verificar tamanho do arquivo
    if ($file['size'] > NEWS_IMAGE_MAX_SIZE) {
        $maxMB = NEWS_IMAGE_MAX_SIZE / (1024 * 1024);
        return [
            'success' => false,
            'message' => "Arquivo muito grande. Tamanho máximo: {$maxMB}MB",
            'file_path' => null
        ];
    }

    // Verificar tipo MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, UPLOAD_ALLOWED_TYPES)) {
        return [
            'success' => false,
            'message' => 'Tipo de arquivo não permitido. Use apenas JPEG, PNG ou WebP',
            'file_path' => null
        ];
    }

    // Obter dimensões da imagem
    $imageInfo = getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return [
            'success' => false,
            'message' => 'Arquivo não é uma imagem válida',
            'file_path' => null
        ];
    }

    list($width, $height) = $imageInfo;

    // Validar dimensão mínima (não fazer upscale)
    if ($width < NEWS_IMAGE_WIDTH || $height < NEWS_IMAGE_HEIGHT) {
        return [
            'success' => false,
            'message' => "Imagem muito pequena. Dimensões mínimas: " . NEWS_IMAGE_WIDTH . "x" . NEWS_IMAGE_HEIGHT . "px. Imagem enviada: {$width}x{$height}px",
            'file_path' => null
        ];
    }

    // Gerar nome único para o arquivo
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $slug = slugify($tituloNoticia);
    $fileName = $slug . '-' . time() . '.' . $extension;

    // Diretório de destino
    $uploadDir = UPLOAD_PATH . 'noticias/';

    // Criar diretório se não existir
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $tempPath = $uploadDir . 'temp_' . $fileName;
    $finalPath = $uploadDir . $fileName;

    // Mover arquivo temporário
    if (!move_uploaded_file($file['tmp_name'], $tempPath)) {
        return [
            'success' => false,
            'message' => 'Erro ao salvar arquivo no servidor',
            'file_path' => null
        ];
    }

    // Redimensionar com crop center
    $resizeResult = redimensionarImagemComCrop(
        $tempPath,
        $finalPath,
        NEWS_IMAGE_WIDTH,
        NEWS_IMAGE_HEIGHT
    );

    // Deletar arquivo temporário
    if (file_exists($tempPath)) {
        unlink($tempPath);
    }

    if (!$resizeResult) {
        return [
            'success' => false,
            'message' => 'Erro ao redimensionar imagem',
            'file_path' => null
        ];
    }

    // Retornar caminho relativo para o banco de dados
    $relativePath = '/public/assets/uploads/noticias/' . $fileName;

    $message = 'Upload realizado com sucesso';
    if ($width != NEWS_IMAGE_WIDTH || $height != NEWS_IMAGE_HEIGHT) {
        $message .= " (imagem redimensionada de {$width}x{$height}px para " . NEWS_IMAGE_WIDTH . "x" . NEWS_IMAGE_HEIGHT . "px)";
    }

    return [
        'success' => true,
        'message' => $message,
        'file_path' => $relativePath
    ];
}

/**
 * Deletar arquivo de imagem
 * @param string $filePath Caminho relativo do arquivo
 * @return bool
 */
function deletarImagem($filePath) {
    if (empty($filePath)) {
        return false;
    }

    // Converter caminho relativo para absoluto
    $absolutePath = __DIR__ . '/../../' . ltrim($filePath, '/');

    if (file_exists($absolutePath)) {
        return unlink($absolutePath);
    }

    return false;
}

/**
 * Redimensionar imagem para dimensões específicas com CROP CENTER
 * Mantém a proporção e corta o centro da imagem para preencher exatamente as dimensões
 * @param string $sourcePath Caminho da imagem original
 * @param string $destPath Caminho da imagem redimensionada
 * @param int $targetWidth Largura desejada
 * @param int $targetHeight Altura desejada
 * @return bool
 */
function redimensionarImagemComCrop($sourcePath, $destPath, $targetWidth, $targetHeight) {
    // Obter informações da imagem
    $imageInfo = getimagesize($sourcePath);
    if ($imageInfo === false) {
        return false;
    }

    list($sourceWidth, $sourceHeight, $imageType) = $imageInfo;

    // Criar imagem a partir do arquivo original
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_WEBP:
            $sourceImage = imagecreatefromwebp($sourcePath);
            break;
        default:
            return false;
    }

    if ($sourceImage === false) {
        return false;
    }

    // Calcular proporções
    $sourceRatio = $sourceWidth / $sourceHeight;
    $targetRatio = $targetWidth / $targetHeight;

    // Calcular dimensões para crop center
    if ($sourceRatio > $targetRatio) {
        // Imagem mais larga - cortar lados
        $cropHeight = $sourceHeight;
        $cropWidth = $sourceHeight * $targetRatio;
        $cropX = ($sourceWidth - $cropWidth) / 2;
        $cropY = 0;
    } else {
        // Imagem mais alta - cortar topo/base
        $cropWidth = $sourceWidth;
        $cropHeight = $sourceWidth / $targetRatio;
        $cropX = 0;
        $cropY = ($sourceHeight - $cropHeight) / 2;
    }

    // Criar nova imagem com dimensões desejadas
    $destImage = imagecreatetruecolor($targetWidth, $targetHeight);

    // Preservar transparência para PNG e WebP
    if ($imageType === IMAGETYPE_PNG || $imageType === IMAGETYPE_WEBP) {
        imagealphablending($destImage, false);
        imagesavealpha($destImage, true);
        $transparent = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
        imagefilledrectangle($destImage, 0, 0, $targetWidth, $targetHeight, $transparent);
    }

    // Redimensionar com crop center
    imagecopyresampled(
        $destImage,      // Imagem destino
        $sourceImage,    // Imagem origem
        0, 0,           // Posição destino (x, y)
        $cropX, $cropY, // Posição origem (x, y) - crop center
        $targetWidth, $targetHeight,  // Dimensões destino
        $cropWidth, $cropHeight       // Dimensões origem (área cropada)
    );

    // Salvar imagem redimensionada
    $result = false;
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $result = imagejpeg($destImage, $destPath, 90);
            break;
        case IMAGETYPE_PNG:
            $result = imagepng($destImage, $destPath, 9);
            break;
        case IMAGETYPE_WEBP:
            $result = imagewebp($destImage, $destPath, 90);
            break;
    }

    // Liberar memória
    imagedestroy($sourceImage);
    imagedestroy($destImage);

    return $result;
}

/**
 * Redimensionar imagem para dimensões específicas (VERSÃO ANTIGA - mantida por compatibilidade)
 * Distorce a imagem se necessário para preencher as dimensões exatas
 * @param string $sourcePath Caminho da imagem original
 * @param string $destPath Caminho da imagem redimensionada
 * @param int $width Largura desejada
 * @param int $height Altura desejada
 * @return bool
 */
function redimensionarImagem($sourcePath, $destPath, $width, $height) {
    // Obter informações da imagem
    $imageInfo = getimagesize($sourcePath);
    if ($imageInfo === false) {
        return false;
    }

    list($sourceWidth, $sourceHeight, $imageType) = $imageInfo;

    // Criar imagem a partir do arquivo original
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_WEBP:
            $sourceImage = imagecreatefromwebp($sourcePath);
            break;
        default:
            return false;
    }

    if ($sourceImage === false) {
        return false;
    }

    // Criar nova imagem com dimensões desejadas
    $destImage = imagecreatetruecolor($width, $height);

    // Preservar transparência para PNG e WebP
    if ($imageType === IMAGETYPE_PNG || $imageType === IMAGETYPE_WEBP) {
        imagealphablending($destImage, false);
        imagesavealpha($destImage, true);
        $transparent = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
        imagefilledrectangle($destImage, 0, 0, $width, $height, $transparent);
    }

    // Redimensionar
    imagecopyresampled(
        $destImage,
        $sourceImage,
        0, 0, 0, 0,
        $width,
        $height,
        $sourceWidth,
        $sourceHeight
    );

    // Salvar imagem redimensionada
    $result = false;
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $result = imagejpeg($destImage, $destPath, 90);
            break;
        case IMAGETYPE_PNG:
            $result = imagepng($destImage, $destPath, 9);
            break;
        case IMAGETYPE_WEBP:
            $result = imagewebp($destImage, $destPath, 90);
            break;
    }

    // Liberar memória
    imagedestroy($sourceImage);
    imagedestroy($destImage);

    return $result;
}

/**
 * Validar dimensões de imagem sem fazer upload
 * @param array $file Array do $_FILES
 * @param int $expectedWidth Largura esperada
 * @param int $expectedHeight Altura esperada
 * @return array ['valid' => bool, 'width' => int, 'height' => int, 'message' => string]
 */
function validarDimensoesImagem($file, $expectedWidth, $expectedHeight) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return [
            'valid' => false,
            'width' => 0,
            'height' => 0,
            'message' => 'Erro no upload do arquivo'
        ];
    }

    $imageInfo = getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return [
            'valid' => false,
            'width' => 0,
            'height' => 0,
            'message' => 'Arquivo não é uma imagem válida'
        ];
    }

    list($width, $height) = $imageInfo;

    if ($width !== $expectedWidth || $height !== $expectedHeight) {
        return [
            'valid' => false,
            'width' => $width,
            'height' => $height,
            'message' => "Dimensões inválidas. Esperado: {$expectedWidth}x{$expectedHeight}px. Recebido: {$width}x{$height}px"
        ];
    }

    return [
        'valid' => true,
        'width' => $width,
        'height' => $height,
        'message' => 'Dimensões válidas'
    ];
}
