<?php
/**
 * Exibe mensagens de feedback (sucesso ou erro)
 */
function displayMessages() {
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
        unset($_SESSION['success']);
    }
    
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);
    }
}

/**
 * Formata data para exibição
 */
function formatDate($date) {
    return date('d/m/Y H:i', strtotime($date));
}

/**
 * Escapa HTML para segurança
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Retorna classe CSS baseada no status da tarefa
 */
function getStatusClass($status) {
    switch ($status) {
        case 'concluida':
            return 'status-completed';
        case 'pendente':
        default:
            return 'status-pending';
    }
}

/**
 * Retorna texto formatado do status
 */
function getStatusText($status) {
    switch ($status) {
        case 'concluida':
            return 'Concluída';
        case 'pendente':
        default:
            return 'Pendente';
    }
}

/**
 * Trunca texto para exibição
 */
function truncateText($text, $length = 100) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}
?>

