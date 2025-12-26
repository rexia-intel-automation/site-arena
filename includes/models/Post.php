<?php
/**
 * Model: Post (Notícias)
 * Gerencia operações CRUD de posts/notícias
 */

class Post {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Buscar posts publicados
     * @param int|null $limit
     * @param int $offset
     * @return array
     */
    public function getPublicados($limit = null, $offset = 0) {
        $sql = "SELECT p.*,
                       c.nome as categoria_nome,
                       c.cor as categoria_cor,
                       u.nome as autor_nome
                FROM posts p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN usuarios_admin u ON p.autor_id = u.id
                WHERE p.status = 'publicado'
                ORDER BY p.publicado_em DESC";

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
     * Buscar posts em destaque
     * @param int $limit
     * @return array
     */
    public function getDestaques($limit = 3) {
        $sql = "SELECT p.*,
                       c.nome as categoria_nome,
                       c.cor as categoria_cor
                FROM posts p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                WHERE p.status = 'publicado' AND p.destaque = TRUE
                ORDER BY p.publicado_em DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Buscar post por ID
     * @param int $id
     * @return array|false
     */
    public function getById($id) {
        $sql = "SELECT p.*,
                       c.nome as categoria_nome,
                       c.cor as categoria_cor,
                       u.nome as autor_nome
                FROM posts p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN usuarios_admin u ON p.autor_id = u.id
                WHERE p.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Buscar post por slug
     * @param string $slug
     * @return array|false
     */
    public function getBySlug($slug) {
        $sql = "SELECT p.*,
                       c.nome as categoria_nome,
                       c.cor as categoria_cor,
                       u.nome as autor_nome
                FROM posts p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN usuarios_admin u ON p.autor_id = u.id
                WHERE p.slug = :slug AND p.status = 'publicado'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);

        $post = $stmt->fetch();
        if ($post) {
            $this->incrementarVisualizacoes($post['id']);
        }

        return $post;
    }

    /**
     * Buscar todos os posts (admin)
     * @param int|null $limit
     * @param int $offset
     * @param array $filtros
     * @return array
     */
    public function getTodos($limit = null, $offset = 0, $filtros = []) {
        $sql = "SELECT p.*,
                       c.nome as categoria_nome,
                       c.cor as categoria_cor,
                       u.nome as autor_nome
                FROM posts p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN usuarios_admin u ON p.autor_id = u.id
                WHERE 1=1";

        $params = [];

        if (!empty($filtros['status'])) {
            $sql .= " AND p.status = :status";
            $params['status'] = $filtros['status'];
        }

        if (!empty($filtros['categoria_id'])) {
            $sql .= " AND p.categoria_id = :categoria_id";
            $params['categoria_id'] = $filtros['categoria_id'];
        }

        if (!empty($filtros['busca'])) {
            $sql .= " AND (p.titulo LIKE :busca OR p.resumo LIKE :busca OR p.conteudo LIKE :busca)";
            $params['busca'] = '%' . $filtros['busca'] . '%';
        }

        $sql .= " ORDER BY p.criado_em DESC";

        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($sql);

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
     * Criar novo post
     * @param array $dados
     * @return int|false
     */
    public function criar($dados) {
        $sql = "INSERT INTO posts (
                    titulo, slug, resumo, conteudo,
                    categoria_id, autor_id, autor_nome,
                    imagem_destaque, galeria_imagens, video_url,
                    meta_title, meta_description, meta_keywords,
                    status, destaque, permite_comentarios,
                    criado_por, publicado_em
                ) VALUES (
                    :titulo, :slug, :resumo, :conteudo,
                    :categoria_id, :autor_id, :autor_nome,
                    :imagem_destaque, :galeria_imagens, :video_url,
                    :meta_title, :meta_description, :meta_keywords,
                    :status, :destaque, :permite_comentarios,
                    :criado_por, :publicado_em
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'titulo' => $dados['titulo'],
            'slug' => $dados['slug'],
            'resumo' => $dados['resumo'] ?? null,
            'conteudo' => $dados['conteudo'],
            'categoria_id' => $dados['categoria_id'] ?? null,
            'autor_id' => $dados['autor_id'] ?? null,
            'autor_nome' => $dados['autor_nome'] ?? null,
            'imagem_destaque' => $dados['imagem_destaque'],
            'galeria_imagens' => $dados['galeria_imagens'] ?? null,
            'video_url' => $dados['video_url'] ?? null,
            'meta_title' => $dados['meta_title'] ?? null,
            'meta_description' => $dados['meta_description'] ?? null,
            'meta_keywords' => $dados['meta_keywords'] ?? null,
            'status' => $dados['status'] ?? 'rascunho',
            'destaque' => $dados['destaque'] ?? 0,
            'permite_comentarios' => $dados['permite_comentarios'] ?? 1,
            'criado_por' => $dados['criado_por'] ?? null,
            'publicado_em' => ($dados['status'] ?? 'rascunho') === 'publicado' ? date('Y-m-d H:i:s') : null
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Atualizar post
     * @param int $id
     * @param array $dados
     * @return bool
     */
    public function atualizar($id, $dados) {
        $postAtual = $this->getById($id);

        $sql = "UPDATE posts SET
                    titulo = :titulo,
                    slug = :slug,
                    resumo = :resumo,
                    conteudo = :conteudo,
                    categoria_id = :categoria_id,
                    imagem_destaque = :imagem_destaque,
                    galeria_imagens = :galeria_imagens,
                    video_url = :video_url,
                    meta_title = :meta_title,
                    meta_description = :meta_description,
                    meta_keywords = :meta_keywords,
                    status = :status,
                    destaque = :destaque,
                    permite_comentarios = :permite_comentarios,
                    atualizado_por = :atualizado_por,
                    publicado_em = :publicado_em
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'titulo' => $dados['titulo'],
            'slug' => $dados['slug'],
            'resumo' => $dados['resumo'] ?? null,
            'conteudo' => $dados['conteudo'],
            'categoria_id' => $dados['categoria_id'] ?? null,
            'imagem_destaque' => $dados['imagem_destaque'] ?? $postAtual['imagem_destaque'],
            'galeria_imagens' => $dados['galeria_imagens'] ?? null,
            'video_url' => $dados['video_url'] ?? null,
            'meta_title' => $dados['meta_title'] ?? null,
            'meta_description' => $dados['meta_description'] ?? null,
            'meta_keywords' => $dados['meta_keywords'] ?? null,
            'status' => $dados['status'] ?? 'rascunho',
            'destaque' => $dados['destaque'] ?? 0,
            'permite_comentarios' => $dados['permite_comentarios'] ?? 1,
            'atualizado_por' => $dados['atualizado_por'] ?? null,
            'publicado_em' => ($dados['status'] ?? 'rascunho') === 'publicado' && empty($postAtual['publicado_em']) ? date('Y-m-d H:i:s') : $postAtual['publicado_em'],
            'id' => $id
        ]);
    }

    /**
     * Deletar post
     * @param int $id
     * @return bool
     */
    public function deletar($id) {
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Incrementar visualizações
     * @param int $id
     */
    private function incrementarVisualizacoes($id) {
        $sql = "UPDATE posts SET visualizacoes = visualizacoes + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Contar total de posts
     * @param array $filtros
     * @return int
     */
    public function contarTotal($filtros = []) {
        $sql = "SELECT COUNT(*) as total FROM posts WHERE 1=1";

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
            $sql .= " AND (titulo LIKE :busca OR resumo LIKE :busca OR conteudo LIKE :busca)";
            $params['busca'] = '%' . $filtros['busca'] . '%';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }
}
