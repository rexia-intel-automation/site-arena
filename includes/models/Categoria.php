<?php
/**
 * Model: Categoria
 * Gerencia operações CRUD de categorias
 */

class Categoria {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Buscar categorias ativas por tipo
     * @param string $tipo ('evento', 'noticia', 'ambos')
     * @return array
     */
    public function getByTipo($tipo = 'ambos') {
        $sql = "SELECT * FROM categorias
                WHERE ativo = TRUE
                AND (tipo = :tipo OR tipo = 'ambos')
                ORDER BY ordem ASC, nome ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['tipo' => $tipo]);
        return $stmt->fetchAll();
    }

    /**
     * Buscar todas as categorias (admin)
     * @return array
     */
    public function getTodas() {
        $sql = "SELECT * FROM categorias
                ORDER BY tipo ASC, ordem ASC, nome ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Buscar categoria por ID
     * @param int $id
     * @return array|false
     */
    public function getById($id) {
        $sql = "SELECT * FROM categorias WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Criar nova categoria
     * @param array $dados
     * @return int|false
     */
    public function criar($dados) {
        $sql = "INSERT INTO categorias (
                    nome, slug, descricao, tipo, cor, icone, ordem, ativo
                ) VALUES (
                    :nome, :slug, :descricao, :tipo, :cor, :icone, :ordem, :ativo
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nome' => $dados['nome'],
            'slug' => $dados['slug'],
            'descricao' => $dados['descricao'] ?? null,
            'tipo' => $dados['tipo'] ?? 'ambos',
            'cor' => $dados['cor'] ?? '#8e44ad',
            'icone' => $dados['icone'] ?? null,
            'ordem' => $dados['ordem'] ?? 0,
            'ativo' => $dados['ativo'] ?? 1
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Atualizar categoria
     * @param int $id
     * @param array $dados
     * @return bool
     */
    public function atualizar($id, $dados) {
        $sql = "UPDATE categorias SET
                    nome = :nome,
                    slug = :slug,
                    descricao = :descricao,
                    tipo = :tipo,
                    cor = :cor,
                    icone = :icone,
                    ordem = :ordem,
                    ativo = :ativo
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nome' => $dados['nome'],
            'slug' => $dados['slug'],
            'descricao' => $dados['descricao'] ?? null,
            'tipo' => $dados['tipo'] ?? 'ambos',
            'cor' => $dados['cor'] ?? '#8e44ad',
            'icone' => $dados['icone'] ?? null,
            'ordem' => $dados['ordem'] ?? 0,
            'ativo' => $dados['ativo'] ?? 1,
            'id' => $id
        ]);
    }

    /**
     * Deletar categoria
     * @param int $id
     * @return bool
     */
    public function deletar($id) {
        // Verificar se há eventos ou posts usando esta categoria
        $sqlCheckEventos = "SELECT COUNT(*) as total FROM eventos WHERE categoria_id = :id";
        $stmtCheck = $this->db->prepare($sqlCheckEventos);
        $stmtCheck->execute(['id' => $id]);
        $resultEventos = $stmtCheck->fetch();

        $sqlCheckPosts = "SELECT COUNT(*) as total FROM posts WHERE categoria_id = :id";
        $stmtCheck2 = $this->db->prepare($sqlCheckPosts);
        $stmtCheck2->execute(['id' => $id]);
        $resultPosts = $stmtCheck2->fetch();

        $total = $resultEventos['total'] + $resultPosts['total'];

        if ($total > 0) {
            throw new Exception("Não é possível deletar esta categoria pois existem {$total} registro(s) vinculado(s) a ela.");
        }

        $sql = "DELETE FROM categorias WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Contar total de categorias
     * @return int
     */
    public function contarTotal() {
        $sql = "SELECT COUNT(*) as total FROM categorias";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['total'];
    }
}
