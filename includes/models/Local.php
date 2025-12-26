<?php
/**
 * Model: Local
 * Gerencia operações CRUD de locais
 */

class Local {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Buscar todos os locais ativos
     * @return array
     */
    public function getTodosAtivos() {
        $sql = "SELECT * FROM locais
                WHERE ativo = TRUE
                ORDER BY ordem ASC, nome ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Buscar todos os locais (admin)
     * @return array
     */
    public function getTodos() {
        $sql = "SELECT * FROM locais
                ORDER BY ordem ASC, nome ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Buscar local por ID
     * @param int $id
     * @return array|false
     */
    public function getById($id) {
        $sql = "SELECT * FROM locais WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Criar novo local
     * @param array $dados
     * @return int|false
     */
    public function criar($dados) {
        $sql = "INSERT INTO locais (
                    nome, slug, descricao, endereco, capacidade, tipo, ordem, ativo
                ) VALUES (
                    :nome, :slug, :descricao, :endereco, :capacidade, :tipo, :ordem, :ativo
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nome' => $dados['nome'],
            'slug' => $dados['slug'],
            'descricao' => $dados['descricao'] ?? null,
            'endereco' => $dados['endereco'] ?? null,
            'capacidade' => $dados['capacidade'] ?? null,
            'tipo' => $dados['tipo'] ?? 'arena',
            'ordem' => $dados['ordem'] ?? 0,
            'ativo' => $dados['ativo'] ?? 1
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Atualizar local
     * @param int $id
     * @param array $dados
     * @return bool
     */
    public function atualizar($id, $dados) {
        $sql = "UPDATE locais SET
                    nome = :nome,
                    slug = :slug,
                    descricao = :descricao,
                    endereco = :endereco,
                    capacidade = :capacidade,
                    tipo = :tipo,
                    ordem = :ordem,
                    ativo = :ativo
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nome' => $dados['nome'],
            'slug' => $dados['slug'],
            'descricao' => $dados['descricao'] ?? null,
            'endereco' => $dados['endereco'] ?? null,
            'capacidade' => $dados['capacidade'] ?? null,
            'tipo' => $dados['tipo'] ?? 'arena',
            'ordem' => $dados['ordem'] ?? 0,
            'ativo' => $dados['ativo'] ?? 1,
            'id' => $id
        ]);
    }

    /**
     * Deletar local
     * @param int $id
     * @return bool
     */
    public function deletar($id) {
        // Verificar se há eventos usando este local
        $sqlCheck = "SELECT COUNT(*) as total FROM eventos WHERE local_id = :id";
        $stmtCheck = $this->db->prepare($sqlCheck);
        $stmtCheck->execute(['id' => $id]);
        $result = $stmtCheck->fetch();

        if ($result['total'] > 0) {
            throw new Exception("Não é possível deletar este local pois existem {$result['total']} evento(s) vinculado(s) a ele.");
        }

        $sql = "DELETE FROM locais WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Contar total de locais
     * @return int
     */
    public function contarTotal() {
        $sql = "SELECT COUNT(*) as total FROM locais";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['total'];
    }
}
