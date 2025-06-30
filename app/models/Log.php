<?php
require_once __DIR__ . '/../../config/database.php';

class Log
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function registrar($user_id, $acao)
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconhecido';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'desconhecido';

        $stmt = $this->pdo->prepare("INSERT INTO logs (user_id, acao, ip, user_agent) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $acao, $ip, $user_agent]);
    }

    public function getPaginados($limite, $offset)
    {
        $stmt = $this->pdo->prepare("
            SELECT logs.*, users.nome AS nome_usuario
            FROM logs
            LEFT JOIN users ON users.id = logs.user_id
            ORDER BY logs.data_hora DESC
            LIMIT :limite OFFSET :offset
        ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarLogs()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM logs");
        return $stmt->fetchColumn();
    }

    public function getTodos()
    {
        $stmt = $this->pdo->query("SELECT logs.*, users.nome FROM logs 
        LEFT JOIN users ON logs.user_id = users.id 
        ORDER BY data_hora DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
