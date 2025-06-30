<?php
require_once __DIR__ . '/../models/Log.php';  // Importa o model Log

class AuthController extends Controller
{
    public function login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF inválido!');
            }

            $email = trim($_POST['email']);
            $senha = $_POST['senha'];

            $userModel = $this->model('User');
            $user = $userModel->findByEmail($email);

            /*
            var_dump($senha); // senha digitada
            var_dump($user['senha']); // hash do banco
            var_dump(password_verify($senha, $user['senha']));
            exit;
            */

            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nome'] = $user['nome'];
                $_SESSION['user_role'] = $user['role'];

                // Registra log de login bem-sucedido
                $log = new Log();
                $log->registrar($user['id'], 'login bem-sucedido');

                header('Location: /BLOG_GUARDIAO/auth/dashboard');
                exit;
            } else {
                // Registra tentativa de login falha (opcional)
                if ($user) {
                    $log = new Log();
                    $log->registrar($user['id'], 'tentativa de login falhou - senha incorreta');
                } else {
                    $log = new Log();
                    $log->registrar(null, "tentativa de login falhou - email não encontrado: $email");
                }

                $erro = "E-mail ou senha incorretos.";
            }
        }

        // Gera novo token CSRF
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $this->view('auth/login', ['erro' => $erro ?? null, 'csrf_token' => $_SESSION['csrf_token']]);
    }

    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $postModel = $this->model('Post');
        $userModel = $this->model('User');
        $logModel = $this->model('Log');

        $totalPosts = $postModel->contarPosts();
        $totalUsers = $userModel->contarUsers();
        $totalLogs = $logModel->contarLogs();

        $this->view('auth/dashboard', [
            'nome' => $_SESSION['user_nome'],
            'totalPosts' => $totalPosts,
            'totalUsers' => $totalUsers,
            'totalLogs' => $totalLogs
        ]);
    }

    public function logout()
    {
        session_start();

        if (isset($_SESSION['user_id'])) {
            $log = new Log();
            $log->registrar($_SESSION['user_id'], 'logout');
        }

        session_destroy();
        header('Location: /BLOG_GUARDIAO/auth/login');
        exit;
    }

    public function logs()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/auth/login");
            exit;
        }

        $logModel = $this->model('Log');

        $porPagina = 10;
        $pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
        $offset = ($pagina - 1) * $porPagina;

        $logs = $logModel->getPaginados($porPagina, $offset);
        $totalLogs = $logModel->contarLogs();
        $totalPaginas = ceil($totalLogs / $porPagina);

        $this->view('auth/logs', [
            'logs' => $logs,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas
        ]);
    }
}
