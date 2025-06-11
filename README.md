# Lista de Tarefas - Aplicação CRUD PHP/MySQL

## 📋 Descrição

Esta é uma aplicação web completa desenvolvida em PHP com banco de dados MySQL que implementa as 4 operações básicas CRUD (Create, Read, Update, Delete) para gerenciamento de uma lista de tarefas (To Do List).

## ✨ Características Principais

- **Interface Moderna**: Design responsivo com gradientes e animações
- **Operações CRUD Completas**: Criar, Ler, Atualizar e Excluir tarefas
- **Segurança**: Uso de prepared statements para prevenir SQL Injection
- **Responsividade**: Compatível com desktop e dispositivos móveis
- **Feedback Visual**: Mensagens de sucesso/erro e estatísticas em tempo real
- **Filtros**: Visualização por status (Todas, Pendentes, Concluídas)

## 🛠️ Tecnologias Utilizadas

### Backend
- **PHP 8.1**: Linguagem de programação principal
- **MySQLi**: Extensão para conexão com banco de dados
- **Prepared Statements**: Segurança contra SQL Injection

### Frontend
- **HTML5**: Estrutura semântica
- **CSS3**: Estilização moderna com Grid e Flexbox
- **JavaScript**: Interatividade e validações

### Banco de Dados
- **MySQL 8.0**: Sistema de gerenciamento de banco de dados

## 📁 Estrutura do Projeto

```
todolist-app/
├── index.php                 # Página principal
├── actions.php              # Processamento das ações CRUD
├── config/
│   └── database.php         # Configuração de conexão
├── includes/
│   ├── TaskManager.php      # Classe para operações CRUD
│   └── functions.php        # Funções auxiliares
├── assets/
│   ├── css/
│   │   └── style.css        # Estilos da aplicação
│   └── js/
│       └── script.js        # JavaScript para interatividade
├── README.md                # Documentação
└── RELATORIO_TESTES.md      # Relatório de testes
```

## 🗄️ Estrutura do Banco de Dados

### Tabela: `tasks`

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `id` | INT AUTO_INCREMENT | Chave primária |
| `title` | VARCHAR(255) NOT NULL | Título da tarefa |
| `description` | TEXT | Descrição detalhada |
| `status` | ENUM('pendente','concluida') | Status da tarefa |
| `created_at` | TIMESTAMP | Data de criação |
| `updated_at` | TIMESTAMP | Data da última atualização |

## 🚀 Instalação e Configuração

### Pré-requisitos
- PHP 8.1 ou superior
- MySQL 8.0 ou superior
- Servidor web (Apache/Nginx)

### Passos de Instalação

1. **Clone ou baixe os arquivos** para o diretório do servidor web

2. **Configure o banco de dados**:
   ```sql
   CREATE DATABASE todolist;
   USE todolist;
   
   CREATE TABLE tasks (
       id INT AUTO_INCREMENT PRIMARY KEY,
       title VARCHAR(255) NOT NULL,
       description TEXT,
       status ENUM('pendente', 'concluida') DEFAULT 'pendente',
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   );
   
   CREATE USER 'todoapp'@'localhost' IDENTIFIED BY 'todopass123';
   GRANT ALL PRIVILEGES ON todolist.* TO 'todoapp'@'localhost';
   FLUSH PRIVILEGES;
   ```

3. **Configure a conexão** no arquivo `config/database.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'todoapp');
   define('DB_PASS', 'todopass123');
   define('DB_NAME', 'todolist');
   ```

4. **Acesse a aplicação** através do navegador

## 📖 Como Usar

### Criar Nova Tarefa
1. Clique no botão "➕ Nova Tarefa"
2. Preencha o título (obrigatório)
3. Adicione uma descrição (opcional)
4. Selecione o status
5. Clique em "Salvar Tarefa"

### Visualizar Tarefas
- As tarefas são exibidas em cards na página principal
- Use os filtros para visualizar por status
- Estatísticas são atualizadas automaticamente

### Editar Tarefa
1. Clique no botão "✏️ Editar" na tarefa desejada
2. Modifique os campos necessários
3. Clique em "Salvar Tarefa"

### Alterar Status
- Clique em "✅ Concluir" para marcar como concluída
- Clique em "⏳ Reabrir" para marcar como pendente

### Excluir Tarefa
1. Clique no botão "🗑️ Excluir"
2. Confirme a exclusão no diálogo

## 🔒 Segurança

### Prepared Statements
Todas as consultas SQL utilizam prepared statements:
```php
$stmt = $this->connection->prepare($sql);
$stmt->bind_param("sss", $title, $description, $status);
$stmt->execute();
```

### Escape de HTML
Todos os dados exibidos são escapados:
```php
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
```

### Validação de Dados
- Validação no frontend (JavaScript)
- Validação no backend (PHP)
- Sanitização de entradas

## 🎨 Design e Interface

### Características do Design
- **Gradientes**: Cores modernas e atrativas
- **Cards**: Layout em cards para melhor organização
- **Responsividade**: Adaptável a diferentes tamanhos de tela
- **Animações**: Transições suaves e micro-interações
- **Tipografia**: Fontes legíveis e hierarquia visual clara

### Paleta de Cores
- **Primária**: Azul (#4facfe) a Ciano (#00f2fe)
- **Sucesso**: Verde (#56ab2f) a Verde claro (#a8e6cf)
- **Aviso**: Rosa (#f093fb) a Vermelho (#f5576c)
- **Erro**: Vermelho (#ff6b6b) a Vermelho escuro (#ee5a52)

## 🧪 Testes Realizados

### Operações CRUD
- ✅ **CREATE**: Criação de tarefas funcionando
- ✅ **READ**: Listagem e visualização funcionando
- ✅ **UPDATE**: Edição de tarefas funcionando
- ✅ **DELETE**: Exclusão com confirmação funcionando

### Interface
- ✅ **Responsividade**: Testado em diferentes resoluções
- ✅ **Navegação**: Fluxo intuitivo e funcional
- ✅ **Validações**: Campos obrigatórios e feedback

### Segurança
- ✅ **SQL Injection**: Proteção via prepared statements
- ✅ **XSS**: Escape de HTML implementado
- ✅ **Validação**: Dados validados no frontend e backend

## 📝 Funcionalidades Implementadas

### Obrigatórias (Atendidas)
- ✅ Formulário para inserção de dados
- ✅ Página de listagem (consulta) dos dados
- ✅ Funcionalidades para edição de registros
- ✅ Funcionalidades para exclusão de registros
- ✅ Interface funcional, clara e de fácil navegação
- ✅ Uso correto de prepare(), bind_param() e fetch_assoc()

### Extras Implementadas
- ✅ Estatísticas em tempo real
- ✅ Filtros por status
- ✅ Design responsivo moderno
- ✅ Animações e transições
- ✅ Mensagens de feedback
- ✅ Validação de formulários
- ✅ Confirmação de exclusão
- ✅ Mudança rápida de status

## 🤝 Suporte

Para dúvidas ou problemas:
1. Verifique se todos os pré-requisitos estão instalados
2. Confirme as configurações do banco de dados
3. Verifique as permissões dos arquivos
4. Consulte os logs de erro do servidor web

## 📄 Licença

Este projeto foi desenvolvido para fins educacionais e demonstração de conceitos de desenvolvimento web com PHP e MySQL.

---

**Desenvolvido com ❤️ usando PHP, MySQL e tecnologias web modernas**

