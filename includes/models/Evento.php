<?php
/**
 * Model: Evento
 * Gerencia operações CRUD de eventos
 */

class Evento {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Validar dados de evento (VALIDAÇÃO RÍGIDA)
     * @param array $dados
     * @return array Erros encontrados (vazio se válido)
     */
    public function validar($dados, $isEdicao = false) {
        $erros = [];

        // Título (OBRIGATÓRIO)
        if (empty($dados['titulo'])) {
            $erros[] = "Título é obrigatório";
        }

        // Data do evento (OBRIGATÓRIO)
        if (empty($dados['data_evento'])) {
            $erros[] = "Data do evento é obrigatória";
        } else {
            // Validar formato de data
            $d = DateTime::createFromFormat('Y-m-d', $dados['data_evento']);
            if (!$d || $d->format('Y-m-d') !== $dados['data_evento']) {
                $erros[] = "Data do evento inválida";
            }
        }

        // Hora do evento (OBRIGATÓRIO)
        if (empty($dados['hora_evento'])) {
            $erros[] = "Hora do evento é obrigatória";
        }

        // Local (OBRIGATÓRIO)
        if (empty($dados['local_id'])) {
            $erros[] = "Local é obrigatório";
        }

        // Categoria (OBRIGATÓRIO)
        if (empty($dados['categoria_id'])) {
            $erros[] = "Categoria é obrigatória";
        }

        // Preço mínimo (OBRIGATÓRIO)
        if (!isset($dados['preco_minimo']) || $dados['preco_minimo'] === '') {
            $erros[] = "Preço mínimo é obrigatório";
        } elseif (!is_numeric($dados['preco_minimo']) || $dados['preco_minimo'] < 0) {
            $erros[] = "Preço mínimo deve ser um valor numérico válido";
        }

        // Link de ingressos (OBRIGATÓRIO)
        if (empty($dados['link_ingressos'])) {
            $erros[] = "Link de compra de ingressos é obrigatório";
        } elseif (!filter_var($dados['link_ingressos'], FILTER_VALIDATE_URL)) {
            $erros[] = "Link de ingressos deve ser uma URL válida";
        }

        // Imagem destaque (OBRIGATÓRIO - exceto em edição se já existe)
        if (!$isEdicao && empty($dados['imagem_destaque'])) {
            $erros[] = "Imagem de destaque é obrigatória (475x180px)";
        }

        return $erros;
    }

    /**
     * Buscar todos os eventos publicados
     * @param int|null $limit
     * @param int $offset
     * @return array
     */
    public function getPublicados($limit = null, $offset = 0) {
        $sql = "SELECT e.*,
                       c.nome as categoria_nome,
                       c.cor as categoria_cor,
                       l.nome as local_nome
                FROM eventos e
                LEFT JOIN categorias c ON e.categoria_id = c.id
                LEFT JOIN locais l ON e.local_id = l.id
                WHERE e.status = 'publicado'
                AND e.data_evento >= CURDATE()
                ORDER BY e.data_evento ASC, e.hora_evento ASC";

        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($sql);

        if ($limit) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Buscar eventos em destaque para a home
     * @param int $limit
     * @return array
     */
    public function getDestaques($limit = 3) {
        $sql = "SELECT e.*,
                       c.nome as categoria_nome,
                       c.cor as categoria_cor,
                       l.nome as local_nome
                FROM eventos e
                LEFT JOIN categorias c ON e.categoria_id = c.id
                LEFT JOIN locais l ON e.local_id = l.id
                WHERE e.status = 'publicado'
                AND e.destaque = TRUE
                AND e.data_evento >= CURDATE()
                ORDER BY e.data_evento ASC, e.hora_evento ASC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Buscar evento por ID
     * @param int $id
     * @return array|false
     */
    public function getById($id) {
        $sql = "SELECT e.*,
                       c.nome as categoria_nome,
                       c.cor as categoria_cor,
                       l.nome as local_nome,
                       l.endereco as local_endereco
                FROM eventos e
                LEFT JOIN categorias c ON e.categoria_id = c.id
                LEFT JOIN locais l ON e.local_id = l.id
                WHERE e.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Buscar evento por slug
     * @param string $slug
     * @return array|false
     */
    public function getBySlug($slug) {
        $sql = "SELECT e.*,
                       c.nome as categoria_nome,
                       c.cor as categoria_cor,
                       l.nome as local_nome,
                       l.endereco as local_endereco,
                       u.nome as autor_nome
                FROM eventos e
                LEFT JOIN categorias c ON e.categoria_id = c.id
                LEFT JOIN locais l ON e.local_id = l.id
                LEFT JOIN usuarios_admin u ON e.criado_por = u.id
                WHERE e.slug = :slug AND e.status = 'publicado'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);

        $evento = $stmt->fetch();
        if ($evento) {
            $this->incrementarVisualizacoes($evento['id']);
        }

        return $evento;
    }

    /**
     * Buscar todos os eventos (admin)
     * @param int|null $limit
     * @param int $offset
     * @param array $filtros
     * @return array
     */
    public function getTodos($limit = null, $offset = 0, $filtros = []) {
        $sql = "SELECT e.*,
                       c.nome as categoria_nome,
                       c.cor as categoria_cor,
                       l.nome as local_nome
                FROM eventos e
                LEFT JOIN categorias c ON e.categoria_id = c.id
                LEFT JOIN locais l ON e.local_id = l.id
                WHERE 1=1";

        // Aplicar filtros
        $params = [];

        if (!empty($filtros['status'])) {
            $sql .= " AND e.status = :status";
            $params['status'] = $filtros['status'];
        }

        if (!empty($filtros['categoria_id'])) {
            $sql .= " AND e.categoria_id = :categoria_id";
            $params['categoria_id'] = $filtros['categoria_id'];
        }

        if (!empty($filtros['busca'])) {
            $sql .= " AND (e.titulo LIKE :busca OR e.descricao LIKE :busca)";
            $params['busca'] = '%' . $filtros['busca'] . '%';
        }

        if (!empty($filtros['local_id'])) {
            $sql .= " AND e.local_id = :local_id";
            $params['local_id'] = $filtros['local_id'];
        }

        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND e.data_evento >= :data_inicio";
            $params['data_inicio'] = $filtros['data_inicio'];
        }

        if (!empty($filtros['data_fim'])) {
            $sql .= " AND e.data_evento < :data_fim";
            $params['data_fim'] = $filtros['data_fim'];
        }

        $sql .= " ORDER BY e.data_evento ASC, e.criado_em DESC";

        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($sql);

        // Bind params
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        if ($limit) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Criar novo evento
     * @param array $dados
     * @return int|false ID do evento criado ou false
     */
    public function criar($dados) {
        // Validar dados
        $erros = $this->validar($dados);
        if (!empty($erros)) {
            throw new Exception(implode(", ", $erros));
        }

        $sql = "INSERT INTO eventos (
                    titulo, slug, descricao, conteudo,
                    data_evento, hora_evento, data_fim, hora_fim,
                    local_id, local_detalhes,
                    categoria_id, tipo_evento,
                    preco_minimo, preco_maximo, link_ingressos, lotacao_maxima,
                    imagem_destaque, galeria_imagens, video_url,
                    meta_title, meta_description, meta_keywords,
                    status, destaque, criado_por, publicado_em
                ) VALUES (
                    :titulo, :slug, :descricao, :conteudo,
                    :data_evento, :hora_evento, :data_fim, :hora_fim,
                    :local_id, :local_detalhes,
                    :categoria_id, :tipo_evento,
                    :preco_minimo, :preco_maximo, :link_ingressos, :lotacao_maxima,
                    :imagem_destaque, :galeria_imagens, :video_url,
                    :meta_title, :meta_description, :meta_keywords,
                    :status, :destaque, :criado_por, :publicado_em
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'titulo' => $dados['titulo'],
            'slug' => $dados['slug'],
            'descricao' => $dados['descricao'] ?? null,
            'conteudo' => $dados['conteudo'] ?? null,
            'data_evento' => $dados['data_evento'],
            'hora_evento' => $dados['hora_evento'],
            'data_fim' => $dados['data_fim'] ?? null,
            'hora_fim' => $dados['hora_fim'] ?? null,
            'local_id' => $dados['local_id'],
            'local_detalhes' => $dados['local_detalhes'] ?? null,
            'categoria_id' => $dados['categoria_id'],
            'tipo_evento' => $dados['tipo_evento'] ?? null,
            'preco_minimo' => $dados['preco_minimo'],
            'preco_maximo' => $dados['preco_maximo'] ?? null,
            'link_ingressos' => $dados['link_ingressos'],
            'lotacao_maxima' => $dados['lotacao_maxima'] ?? null,
            'imagem_destaque' => $dados['imagem_destaque'],
            'galeria_imagens' => $dados['galeria_imagens'] ?? null,
            'video_url' => $dados['video_url'] ?? null,
            'meta_title' => $dados['meta_title'] ?? null,
            'meta_description' => $dados['meta_description'] ?? null,
            'meta_keywords' => $dados['meta_keywords'] ?? null,
            'status' => $dados['status'] ?? 'rascunho',
            'destaque' => $dados['destaque'] ?? 0,
            'criado_por' => $dados['criado_por'] ?? null,
            'publicado_em' => ($dados['status'] ?? 'rascunho') === 'publicado' ? date('Y-m-d H:i:s') : null
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Atualizar evento
     * @param int $id
     * @param array $dados
     * @return bool
     */
    public function atualizar($id, $dados) {
        // Validar dados
        $eventoAtual = $this->getById($id);
        $erros = $this->validar($dados, true);

        // Se não enviou nova imagem, manter a atual
        if (empty($dados['imagem_destaque']) && !empty($eventoAtual['imagem_destaque'])) {
            $dados['imagem_destaque'] = $eventoAtual['imagem_destaque'];
        }

        if (!empty($erros)) {
            throw new Exception(implode(", ", $erros));
        }

        $sql = "UPDATE eventos SET
                    titulo = :titulo,
                    slug = :slug,
                    descricao = :descricao,
                    conteudo = :conteudo,
                    data_evento = :data_evento,
                    hora_evento = :hora_evento,
                    data_fim = :data_fim,
                    hora_fim = :hora_fim,
                    local_id = :local_id,
                    local_detalhes = :local_detalhes,
                    categoria_id = :categoria_id,
                    tipo_evento = :tipo_evento,
                    preco_minimo = :preco_minimo,
                    preco_maximo = :preco_maximo,
                    link_ingressos = :link_ingressos,
                    lotacao_maxima = :lotacao_maxima,
                    imagem_destaque = :imagem_destaque,
                    galeria_imagens = :galeria_imagens,
                    video_url = :video_url,
                    meta_title = :meta_title,
                    meta_description = :meta_description,
                    meta_keywords = :meta_keywords,
                    status = :status,
                    destaque = :destaque,
                    atualizado_por = :atualizado_por,
                    publicado_em = :publicado_em
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'titulo' => $dados['titulo'],
            'slug' => $dados['slug'],
            'descricao' => $dados['descricao'] ?? null,
            'conteudo' => $dados['conteudo'] ?? null,
            'data_evento' => $dados['data_evento'],
            'hora_evento' => $dados['hora_evento'],
            'data_fim' => $dados['data_fim'] ?? null,
            'hora_fim' => $dados['hora_fim'] ?? null,
            'local_id' => $dados['local_id'],
            'local_detalhes' => $dados['local_detalhes'] ?? null,
            'categoria_id' => $dados['categoria_id'],
            'tipo_evento' => $dados['tipo_evento'] ?? null,
            'preco_minimo' => $dados['preco_minimo'],
            'preco_maximo' => $dados['preco_maximo'] ?? null,
            'link_ingressos' => $dados['link_ingressos'],
            'lotacao_maxima' => $dados['lotacao_maxima'] ?? null,
            'imagem_destaque' => $dados['imagem_destaque'],
            'galeria_imagens' => $dados['galeria_imagens'] ?? null,
            'video_url' => $dados['video_url'] ?? null,
            'meta_title' => $dados['meta_title'] ?? null,
            'meta_description' => $dados['meta_description'] ?? null,
            'meta_keywords' => $dados['meta_keywords'] ?? null,
            'status' => $dados['status'] ?? 'rascunho',
            'destaque' => $dados['destaque'] ?? 0,
            'atualizado_por' => $dados['atualizado_por'] ?? null,
            'publicado_em' => ($dados['status'] ?? 'rascunho') === 'publicado' && empty($eventoAtual['publicado_em']) ? date('Y-m-d H:i:s') : $eventoAtual['publicado_em'],
            'id' => $id
        ]);
    }

    /**
     * Deletar evento
     * @param int $id
     * @return bool
     */
    public function deletar($id) {
        $sql = "DELETE FROM eventos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Incrementar visualizações
     * @param int $id
     */
    private function incrementarVisualizacoes($id) {
        $sql = "UPDATE eventos SET visualizacoes = visualizacoes + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Contar total de eventos
     * @param array $filtros
     * @return int
     */
    public function contarTotal($filtros = []) {
        $sql = "SELECT COUNT(*) as total FROM eventos WHERE 1=1";

        $params = [];

        if (!empty($filtros['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filtros['status'];
        }

        if (!empty($filtros['categoria_id'])) {
            $sql .= " AND categoria_id = :categoria_id";
            $params['categoria_id'] = $filtros['categoria_id'];
        }

        if (!empty($filtros['busca'])) {
            $sql .= " AND (titulo LIKE :busca OR descricao LIKE :busca)";
            $params['busca'] = '%' . $filtros['busca'] . '%';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }
}
