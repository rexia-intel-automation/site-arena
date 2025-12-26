<?php
/**
 * Model: Usuario
 * Gerencia operações de usuários administrativos
 */

class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Autenticar usuário
     * @param string $email
     * @param string $senha
     * @return array|false Dados do usuário ou false
     */
    public function autenticar($email, $senha) {
        $sql = "SELECT * FROM usuarios_admin
                WHERE email = :email AND ativo = TRUE
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            // Atualizar último login
            $this->atualizarUltimoLogin($usuario['id']);

            // Remover senha do retorno
            unset($usuario['senha_hash']);

            return $usuario;
        }

        return false;
    }

    /**
     * Buscar usuário por ID
     * @param int $id
     * @return array|false
     */
    public function getById($id) {
        $sql = "SELECT id, nome, email, nivel_acesso, ativo, ultimo_login, criado_em
                FROM usuarios_admin
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Buscar todos os usuários
     * @return array
     */
    public function getTodos() {
        $sql = "SELECT id, nome, email, nivel_acesso, ativo, ultimo_login, criado_em
                FROM usuarios_admin
                ORDER BY nome ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Criar novo usuário
     * @param array $dados
     * @return int|false
     */
    public function criar($dados) {
        $sql = "INSERT INTO usuarios_admin (
                    nome, email, senha_hash, nivel_acesso, ativo
                ) VALUES (
                    :nome, :email, :senha_hash, :nivel_acesso, :ativo
                )";

        $senhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'senha_hash' => $senhaHash,
            'nivel_acesso' => $dados['nivel_acesso'] ?? 'editor',
            'ativo' => $dados['ativo'] ?? 1
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Atualizar usuário
     * @param int $id
     * @param array $dados
     * @return bool
     */
    public function atualizar($id, $dados) {
        $sql = "UPDATE usuarios_admin SET
                    nome = :nome,
                    email = :email,
                    nivel_acesso = :nivel_acesso,
                    ativo = :ativo";

        $params = [
            'nome' => $dados['nome'],
            'email' => $dados['email'],
            'nivel_acesso' => $dados['nivel_acesso'],
            'ativo' => $dados['ativo'],
            'id' => $id
        ];

        // Se foi fornecida uma nova senha, atualizar
        if (!empty($dados['senha'])) {
            $sql .= ", senha_hash = :senha_hash";
            $params['senha_hash'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Deletar usuário
     * @param int $id
     * @return bool
     */
    public function deletar($id) {
        $sql = "DELETE FROM usuarios_admin WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Atualizar último login
     * @param int $id
     */
    private function atualizarUltimoLogin($id) {
        $sql = "UPDATE usuarios_admin
                SET ultimo_login = NOW()
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Verificar se email já existe
     * @param string $email
     * @param int|null $excluirId ID para excluir da verificação (edição)
     * @return bool
     */
    public function emailExiste($email, $excluirId = null) {
        $sql = "SELECT COUNT(*) as total FROM usuarios_admin WHERE email = :email";

        if ($excluirId) {
            $sql .= " AND id != :id";
        }

        $stmt = $this->db->prepare($sql);

        $params = ['email' => $email];
        if ($excluirId) {
            $params['id'] = $excluirId;
        }

        $stmt->execute($params);
        $result = $stmt->fetch();

        return $result['total'] > 0;
    }

    /**
     * Contar total de usuários
     * @return int
     */
    public function contarTotal() {
        $sql = "SELECT COUNT(*) as total FROM usuarios_admin";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['total'];
    }
}
