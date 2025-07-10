<?php

require_once __DIR__ . '/../../config/Database.php';


class ApiController
{
    public function logs_ataques()
    {
        header('Content-Type: application/json');

        if (!isset($_GET['token']) || $_GET['token'] !== 'meuTokenSegur0') {
            http_response_code(403);
            echo json_encode(["erro" => "Acesso negado."]);
            return;
        }

        try {
            $pdo = Database::getConnection();

            $stmt = $pdo->query("SELECT ip, tipo, rota, user_agent, data FROM logs_ataques ORDER BY data DESC LIMIT 100");
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["erro" => "Erro ao conectar ao banco de dados: " . $e->getMessage()]);
        }
    }
}
