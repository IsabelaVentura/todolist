<?php
/**
 * Processamento de ações CRUD
 * Lista de Tarefas - Aplicação CRUD PHP/MySQL
 */

require_once 'includes/TaskManager.php';

// Inicia sessão para mensagens de feedback
session_start();

$taskManager = new TaskManager();

// Verifica se foi enviada uma ação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    switch ($action) {
        case 'create':
            // CREATE - Criar nova tarefa
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = $_POST['status'] ?? 'pendente';
            
            if (!empty($title)) {
                if ($taskManager->createTask($title, $description, $status)) {
                    $_SESSION['success'] = 'Tarefa criada com sucesso!';
                } else {
                    $_SESSION['error'] = 'Erro ao criar tarefa. Tente novamente.';
                }
            } else {
                $_SESSION['error'] = 'O título da tarefa é obrigatório.';
            }
            break;
            
        case 'update':
            // UPDATE - Atualizar tarefa existente
            $id = intval($_POST['id'] ?? 0);
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $status = $_POST['status'] ?? 'pendente';
            
            if ($id > 0 && !empty($title)) {
                if ($taskManager->updateTask($id, $title, $description, $status)) {
                    $_SESSION['success'] = 'Tarefa atualizada com sucesso!';
                } else {
                    $_SESSION['error'] = 'Erro ao atualizar tarefa. Tente novamente.';
                }
            } else {
                $_SESSION['error'] = 'Dados inválidos para atualização.';
            }
            break;
            
        case 'delete':
            // DELETE - Excluir tarefa
            $id = intval($_POST['id'] ?? 0);
            
            if ($id > 0) {
                if ($taskManager->deleteTask($id)) {
                    $_SESSION['success'] = 'Tarefa excluída com sucesso!';
                } else {
                    $_SESSION['error'] = 'Erro ao excluir tarefa. Tente novamente.';
                }
            } else {
                $_SESSION['error'] = 'ID da tarefa inválido.';
            }
            break;
            
        default:
            $_SESSION['error'] = 'Ação não reconhecida.';
            break;
    }
}

// Redireciona de volta para a página principal
header('Location: index.php');
exit;
?>

