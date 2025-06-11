<?php

require_once 'config/database.php';

class TaskManager {
    private $db;
    private $connection;
    
    public function __construct() {
        $this->db = new Database();
        $this->connection = $this->db->getConnection();
    }
    
    /**
     * CREATE - Inserir nova tarefa
     */
    public function createTask($title, $description = '', $status = 'pendente') {
        $sql = "INSERT INTO tasks (title, description, status) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("sss", $title, $description, $status);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
    
    /**
     * READ - Listar todas as tarefas
     */
    public function getAllTasks() {
        $sql = "SELECT id, title, description, status, created_at, updated_at FROM tasks ORDER BY created_at DESC";
        $stmt = $this->connection->prepare($sql);
        
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $tasks = [];
            
            while ($row = $result->fetch_assoc()) {
                $tasks[] = $row;
            }
            
            $stmt->close();
            return $tasks;
        }
        return [];
    }
    
    /**
     * READ - Buscar tarefa por ID
     */
    public function getTaskById($id) {
        $sql = "SELECT id, title, description, status, created_at, updated_at FROM tasks WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $task = $result->fetch_assoc();
            $stmt->close();
            return $task;
        }
        return null;
    }
    
    /**
     * UPDATE - Atualizar tarefa existente
     */
    public function updateTask($id, $title, $description = '', $status = 'pendente') {
        $sql = "UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("sssi", $title, $description, $status, $id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
    
    /**
     * DELETE - Excluir tarefa
     */
    public function deleteTask($id) {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }
        return false;
    }
    
    /**
     * Contar total de tarefas
     */
    public function getTotalTasks() {
        $sql = "SELECT COUNT(*) as total FROM tasks";
        $stmt = $this->connection->prepare($sql);
        
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['total'];
        }
        return 0;
    }
    
    /**
     * Contar tarefas por status
     */
    public function getTasksByStatus($status) {
        $sql = "SELECT COUNT(*) as total FROM tasks WHERE status = ?";
        $stmt = $this->connection->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['total'];
        }
        return 0;
    }
}
?>

