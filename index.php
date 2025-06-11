<?php
/**
 * Página principal - Lista de Tarefas
 * Aplicação CRUD PHP/MySQL
 */

session_start();
require_once 'includes/TaskManager.php';
require_once 'includes/functions.php';

$taskManager = new TaskManager();

// Buscar todas as tarefas
$tasks = $taskManager->getAllTasks();

// Estatísticas
$totalTasks = $taskManager->getTotalTasks();
$pendingTasks = $taskManager->getTasksByStatus('pendente');
$completedTasks = $taskManager->getTasksByStatus('concluida');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas - CRUD PHP/MySQL</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <h1>📝 Lista de Tarefas</h1>
            <p>Gerencie suas tarefas de forma simples e eficiente</p>
        </header>

        <!-- Estatísticas -->
        <section class="stats">
            <div class="stat-card">
                <div class="stat-number" id="totalTasks"><?php echo $totalTasks; ?></div>
                <div class="stat-label">Total de Tarefas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="pendingTasks"><?php echo $pendingTasks; ?></div>
                <div class="stat-label">Tarefas Pendentes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="completedTasks"><?php echo $completedTasks; ?></div>
                <div class="stat-label">Tarefas Concluídas</div>
            </div>
        </section>

        <!-- Mensagens de feedback -->
        <?php displayMessages(); ?>

        <!-- Seção de ações -->
        <section class="form-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>Gerenciar Tarefas</h2>
                <button type="button" class="btn btn-primary" id="addTaskBtn" data-tooltip="Ctrl+N">
                    ➕ Nova Tarefa
                </button>
            </div>
            
            <!-- Filtros -->
            <div style="margin-bottom: 20px;">
                <button type="button" class="btn btn-sm filter-btn active" data-status="all">Todas</button>
                <button type="button" class="btn btn-sm filter-btn" data-status="pendente">Pendentes</button>
                <button type="button" class="btn btn-sm filter-btn" data-status="concluida">Concluídas</button>
            </div>
        </section>

        <!-- Lista de tarefas -->
        <section class="tasks-section">
            <h2>Suas Tarefas</h2>
            
            <?php if (empty($tasks)): ?>
                <div class="empty-state">
                    <h3>📋 Nenhuma tarefa encontrada</h3>
                    <p>Que tal criar sua primeira tarefa?</p>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('addTaskBtn').click()">
                        Criar Primeira Tarefa
                    </button>
                </div>
            <?php else: ?>
                <div class="tasks-grid">
                    <?php foreach ($tasks as $task): ?>
                        <div class="task-card">
                            <div class="task-header">
                                <h3 class="task-title"><?php echo e($task['title']); ?></h3>
                                <span class="task-status <?php echo getStatusClass($task['status']); ?>" data-status="<?php echo $task['status']; ?>">
                                    <?php echo getStatusText($task['status']); ?>
                                </span>
                            </div>
                            
                            <?php if (!empty($task['description'])): ?>
                                <div class="task-description">
                                    <?php echo nl2br(e($task['description'])); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="task-meta">
                                <strong>Criada em:</strong> <?php echo formatDate($task['created_at']); ?>
                                <?php if ($task['updated_at'] !== $task['created_at']): ?>
                                    <br><strong>Atualizada em:</strong> <?php echo formatDate($task['updated_at']); ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="task-actions">
                                <button type="button" 
                                        class="btn btn-sm btn-warning edit-task" 
                                        data-id="<?php echo $task['id']; ?>"
                                        data-title="<?php echo e($task['title']); ?>"
                                        data-description="<?php echo e($task['description']); ?>"
                                        data-status="<?php echo $task['status']; ?>"
                                        data-tooltip="Editar tarefa">
                                    ✏️ Editar
                                </button>
                                
                                <button type="button" 
                                        class="btn btn-sm btn-danger delete-task" 
                                        data-id="<?php echo $task['id']; ?>"
                                        data-title="<?php echo e($task['title']); ?>"
                                        data-tooltip="Excluir tarefa">
                                    🗑️ Excluir
                                </button>
                                
                                <?php if ($task['status'] === 'pendente'): ?>
                                    <form method="POST" action="actions.php" style="display: inline;">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                        <input type="hidden" name="title" value="<?php echo e($task['title']); ?>">
                                        <input type="hidden" name="description" value="<?php echo e($task['description']); ?>">
                                        <input type="hidden" name="status" value="concluida">
                                        <button type="submit" class="btn btn-sm btn-success" data-tooltip="Marcar como concluída">
                                            ✅ Concluir
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" action="actions.php" style="display: inline;">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                        <input type="hidden" name="title" value="<?php echo e($task['title']); ?>">
                                        <input type="hidden" name="description" value="<?php echo e($task['description']); ?>">
                                        <input type="hidden" name="status" value="pendente">
                                        <button type="submit" class="btn btn-sm btn-warning" data-tooltip="Marcar como pendente">
                                            ⏳ Reabrir
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <!-- Modal para criar/editar tarefa -->
    <div id="taskModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle" class="modal-title">Nova Tarefa</h2>
                <span class="close">&times;</span>
            </div>
            
            <form id="taskForm" method="POST" action="actions.php">
                <input type="hidden" id="action" name="action" value="create">
                <input type="hidden" id="taskId" name="id" value="">
                
                <div class="form-group">
                    <label for="title">Título da Tarefa *</label>
                    <input type="text" id="title" name="title" class="form-control" required maxlength="255">
                </div>
                
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <textarea id="description" name="description" class="form-control" rows="4" placeholder="Descreva os detalhes da tarefa..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="pendente">Pendente</option>
                        <option value="concluida">Concluída</option>
                    </select>
                </div>
                
                <div style="text-align: right; margin-top: 30px;">
                    <button type="button" class="btn" onclick="document.querySelector('.close').click()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Tarefa</button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>

