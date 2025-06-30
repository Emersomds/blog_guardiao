<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'guardiao_db';

try {
    // Conecta ao servidor MySQL (sem banco definido)
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o banco existe
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbname'");
    if ($stmt->rowCount() === 0) {
        // Cria banco de dados
        $pdo->exec("CREATE DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Banco de dados '$dbname' criado com sucesso.<br>";
    } else {
        echo "Banco de dados '$dbname' já existe.<br>";
    }

    // Usa o banco criado/existente
    $pdo->exec("USE `$dbname`");

    // Cria tabela 'users'
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(150) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            senha VARCHAR(255) NOT NULL,
            criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;
    ");
    echo "Tabela 'users' criada ou já existia.<br>";

    // Cria tabela 'posts'
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(255) NOT NULL,
            conteudo TEXT NOT NULL,
            data_publicacao DATETIME DEFAULT CURRENT_TIMESTAMP,
            imagem VARCHAR(255) DEFAULT NULL,
            autor_id INT,
            FOREIGN KEY (autor_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB;
    ");
    echo "Tabela 'posts' criada ou já existia.<br>";

    // Cria tabela 'logs'
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT DEFAULT NULL,
            acao VARCHAR(255) NOT NULL,
            data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
            ip VARCHAR(45) DEFAULT NULL,
            FOREIGN KEY (usuario_id) REFERENCES users(id) ON DELETE SET NULL
        ) ENGINE=InnoDB;
    ");
    echo "Tabela 'logs' criada ou já existia.<br>";

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}