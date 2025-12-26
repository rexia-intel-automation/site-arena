<?php
/**
 * Classe Database - Singleton
 * Gerencia a conexão com o banco de dados
 */

class Database {
    private static $instance = null;
    private $pdo;

    /**
     * Construtor privado - Singleton pattern
     */
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
            ];

            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

        } catch (PDOException $e) {
            // Em produção, logar o erro ao invés de exibir
            die("Erro de conexão com o banco de dados: " . $e->getMessage());
        }
    }

    /**
     * Retorna a instância única da classe (Singleton)
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Retorna a conexão PDO
     * @return PDO
     */
    public function getConnection() {
        return $this->pdo;
    }

    /**
     * Prevenir clonagem da instância
     */
    private function __clone() {}

    /**
     * Prevenir unserialize da instância
     */
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}
