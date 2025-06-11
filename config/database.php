<?php
// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'todolist');

/**
 * Classe para gerenciar conexão com banco de dados usando mysqli
 */
class Database {
    private $connection;
    
    public function __construct() {
        $this->connect();
    }
    
    /**
     * Estabelece conexão com o banco de dados
     */
    private function connect() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Verifica se houve erro na conexão
        if ($this->connection->connect_error) {
            die("Erro na conexão com o banco de dados: " . $this->connection->connect_error);
        }
        
        // Define charset para UTF-8
        $this->connection->set_charset("utf8");
    }
    
    /**
     * Retorna a conexão mysqli
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Fecha a conexão com o banco de dados
     */
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
    
    /**
     * Destrutor - fecha conexão automaticamente
     */
    public function __destruct() {
        $this->close();
    }
}
?>

