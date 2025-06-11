# Lista de Tarefas - Aplicação CRUD PHP/MySQL

## Descrição

Esta é uma aplicação web completa desenvolvida em PHP com banco de dados MySQL que implementa as 4 operações básicas CRUD (Create, Read, Update, Delete) para gerenciamento de uma lista de tarefas (To Do List).

**Configure o banco de dados**:
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
Membros:
Isabela Ventura 
Jonas Gomes 
Matheus Covizzi
