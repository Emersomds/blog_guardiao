<?php
class SecurityMiddleware
{
    public static function verificarEntrada()
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $rota = $_SERVER['REQUEST_URI'] ?? 'desconhecida';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'indefinido';

        $entrada = json_encode($_REQUEST); // Combina GET e POST
        $tipo = null;

        // Verifica padrões maliciosos básicos
        if (preg_match('/(UNION|SELECT|DROP|--|OR 1=1|sleep\()|(\%27)|(\')/i', $entrada)) {
            $tipo = 'SQLi';
        } elseif (preg_match('/<script>|onerror=|alert\(|<img/i', $entrada)) {
            $tipo = 'XSS';
        }

        // Se detectar algo, registra
        if ($tipo) {
            self::registrarLog($ip, $tipo, $rota, $user_agent);
        }
    }

    private static function registrarLog($ip, $tipo, $rota, $user_agent)
    {
        require_once __DIR__ . '/../../config/Database.php';

        try {
            $pdo = Database::getConnection();

            $stmt = $pdo->prepare("INSERT INTO logs_ataques (ip, tipo, rota, user_agent) VALUES (?, ?, ?, ?)");
            $stmt->execute([$ip, $tipo, $rota, $user_agent]);
        } catch (PDOException $e) {
            error_log("Erro ao registrar log no banco: " . $e->getMessage());
        }

        // Grava no arquivo de texto
        $linha = "[" . date("Y-m-d H:i:s") . "] [$ip] [$tipo] $rota" . PHP_EOL;
        $path = __DIR__ . '/../../storage/logs_ataques.txt';

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        file_put_contents($path, $linha, FILE_APPEND);
    }
}
