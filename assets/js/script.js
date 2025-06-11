
document.addEventListener('DOMContentLoaded', function() {
    
    // Elementos do DOM
    const modal = document.getElementById('taskModal');
    const modalTitle = document.getElementById('modalTitle');
    const taskForm = document.getElementById('taskForm');
    const closeModal = document.querySelector('.close');
    const addTaskBtn = document.getElementById('addTaskBtn');
    
    // Abrir modal para nova tarefa
    if (addTaskBtn) {
        addTaskBtn.addEventListener('click', function() {
            openModal('Nova Tarefa', 'create');
        });
    }
    
    // Fechar modal
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            closeModalWindow();
        });
    }
    
    // Fechar modal clicando fora dele
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModalWindow();
        }
    });
    
    // Botões de editar tarefa
    document.querySelectorAll('.edit-task').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.dataset.id;
            const taskTitle = this.dataset.title;
            const taskDescription = this.dataset.description;
            const taskStatus = this.dataset.status;
            
            openModal('Editar Tarefa', 'update', {
                id: taskId,
                title: taskTitle,
                description: taskDescription,
                status: taskStatus
            });
        });
    });
    
    // Botões de excluir tarefa
    document.querySelectorAll('.delete-task').forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.dataset.id;
            const taskTitle = this.dataset.title;
            
            if (confirm(`Tem certeza que deseja excluir a tarefa "${taskTitle}"?`)) {
                deleteTask(taskId);
            }
        });
    });
    
    // Função para abrir modal
    function openModal(title, action, taskData = null) {
        modalTitle.textContent = title;
        
        // Limpar formulário
        taskForm.reset();
        
        // Configurar ação do formulário
        document.getElementById('action').value = action;
        
        // Se for edição, preencher dados
        if (taskData) {
            document.getElementById('taskId').value = taskData.id;
            document.getElementById('title').value = taskData.title;
            document.getElementById('description').value = taskData.description;
            document.getElementById('status').value = taskData.status;
        } else {
            document.getElementById('taskId').value = '';
        }
        
        // Mostrar modal
        modal.style.display = 'block';
        
        // Focar no campo título
        setTimeout(() => {
            document.getElementById('title').focus();
        }, 100);
    }
    
    // Função para fechar modal
    function closeModalWindow() {
        modal.style.display = 'none';
        taskForm.reset();
    }
    
    // Função para excluir tarefa
    function deleteTask(taskId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'actions.php';
        
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'delete';
        
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'id';
        idInput.value = taskId;
        
        form.appendChild(actionInput);
        form.appendChild(idInput);
        document.body.appendChild(form);
        form.submit();
    }
    
    // Validação do formulário
    if (taskForm) {
        taskForm.addEventListener('submit', function(event) {
            const title = document.getElementById('title').value.trim();
            
            if (!title) {
                event.preventDefault();
                alert('O título da tarefa é obrigatório!');
                document.getElementById('title').focus();
                return false;
            }
        });
    }
    
    // Auto-hide alerts após 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
    
    // Animação suave para cards de tarefa
    const taskCards = document.querySelectorAll('.task-card');
    taskCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Filtro de tarefas por status
    function filterTasks(status) {
        const tasks = document.querySelectorAll('.task-card');
        
        tasks.forEach(task => {
            const taskStatus = task.querySelector('.task-status').dataset.status;
            
            if (status === 'all' || taskStatus === status) {
                task.style.display = 'block';
            } else {
                task.style.display = 'none';
            }
        });
    }
    
    // Adicionar listeners para filtros se existirem
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const status = this.dataset.status;
            filterTasks(status);
            
            // Atualizar botão ativo
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Teclas de atalho
    document.addEventListener('keydown', function(event) {
        // Ctrl/Cmd + N para nova tarefa
        if ((event.ctrlKey || event.metaKey) && event.key === 'n') {
            event.preventDefault();
            if (addTaskBtn) {
                addTaskBtn.click();
            }
        }
        
        // Escape para fechar modal
        if (event.key === 'Escape' && modal.style.display === 'block') {
            closeModalWindow();
        }
    });
    
    // Tooltip simples
    function showTooltip(element, text) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = text;
        tooltip.style.cssText = `
            position: absolute;
            background: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            z-index: 1000;
            pointer-events: none;
        `;
        
        document.body.appendChild(tooltip);
        
        const rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + 'px';
        tooltip.style.top = (rect.top - tooltip.offsetHeight - 5) + 'px';
        
        setTimeout(() => {
            tooltip.remove();
        }, 2000);
    }
    
    // Adicionar tooltips aos botões
    document.querySelectorAll('[data-tooltip]').forEach(element => {
        element.addEventListener('mouseenter', function() {
            showTooltip(this, this.dataset.tooltip);
        });
    });
});

// Função para atualizar estatísticas em tempo real
function updateStats() {
    const totalTasks = document.querySelectorAll('.task-card').length;
    const pendingTasks = document.querySelectorAll('.status-pending').length;
    const completedTasks = document.querySelectorAll('.status-completed').length;
    
    // Atualizar elementos de estatística se existirem
    const totalElement = document.getElementById('totalTasks');
    const pendingElement = document.getElementById('pendingTasks');
    const completedElement = document.getElementById('completedTasks');
    
    if (totalElement) totalElement.textContent = totalTasks;
    if (pendingElement) pendingElement.textContent = pendingTasks;
    if (completedElement) completedElement.textContent = completedTasks;
}

