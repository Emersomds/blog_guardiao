<?php
require_once '../config/config.php';        // <-- Adicionado
require_once '../config/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/App.php';

// Chama o middleware para verificar possíveis ataques antes de processar a requisição
require_once '../app/Middleware/SecurityMiddleware.php';
SecurityMiddleware::verificarEntrada();

$app = new App();
