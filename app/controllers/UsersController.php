<?php
class UsersController extends Controller
{
    public function manage()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/auth/login");
            exit;
        }

        $mensagem = null;
        if (isset($_SESSION['flash_msg'])) {
            $mensagem = $_SESSION['flash_msg'];
            unset($_SESSION['flash_msg']);
        }

        $userModel = $this->model('User');
        $usuarios = $userModel->getTodos();

        $this->view('users/manage', [
            'usuarios' => $usuarios,
            'mensagem' => $mensagem
        ]);
    }

    public function create()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/auth/login");
            exit;
        }

        $mensagem = null;
        $erros = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF inválido');
            }

            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $senha = $_POST['senha'];
            $role = $_POST['role'] ?? 'user';

            // Validações
            if (empty($nome)) {
                $erros[] = "O nome é obrigatório.";
            }

            if (empty($email)) {
                $erros[] = "O e-mail é obrigatório.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erros[] = "Formato de e-mail inválido.";
            }

            if (empty($senha)) {
                $erros[] = "A senha é obrigatória.";
            } elseif (strlen($senha) < 6) {
                $erros[] = "A senha deve ter no mínimo 6 caracteres.";
            }

            // Verifica se email já existe
            $userModel = $this->model('User');
            if ($userModel->existeEmail($email)) {
                $erros[] = "Este e-mail já está cadastrado.";
            }

            if (empty($erros)) {
                // Criptografa a senha
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                // Salva usuário
                $userModel->criar($nome, $email, $senhaHash, $role);

                $logModel = $this->model('Log');
                $logModel->registrar($_SESSION['user_id'], "Criou um novo usuário: $email");

                $mensagem = "Usuário criado com sucesso!";
            }
        }

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $this->view('users/create', [
            'csrf_token' => $_SESSION['csrf_token'],
            'mensagem' => $mensagem,
            'erros' => $erros ?? []
        ]);
    }

    public function delete($id)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/auth/login");
            exit;
        }

        $userModel = $this->model('User');
        $user = $userModel->buscarPorId($id);

        if ($user) {
            $userModel->excluir($id);

            // Log da ação
            $logModel = $this->model('Log');
            $logModel->registrar($_SESSION['user_id'], "Excluiu o usuário: {$user['email']}");
        }

        header("Location: " . BASE_URL . "/users/manage");
        exit;
    }

    public function edit($id)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/auth/login");
            exit;
        }

        $userModel = $this->model('User');
        $usuario = $userModel->buscarPorId($id);

        if (!$usuario) {
            die("Usuário não encontrado.");
        }

        $mensagem = null;
        if (isset($_SESSION['flash_msg'])) {
            $mensagem = $_SESSION['flash_msg'];
            unset($_SESSION['flash_msg']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF inválido');
            }

            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $role = $_POST['role'];

            $userModel->atualizar($id, $nome, $email, $role);

            // Log
            $logModel = $this->model('Log');
            $logModel->registrar($_SESSION['user_id'], "Editou o usuário ID: $id");
            $mensagem = "Usuário alterado com sucesso!";

            $_SESSION['flash_msg'] = "Usuário alterado com sucesso!";
            header("Location: " . BASE_URL . "/users/manage");
            exit;
        }

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $this->view('users/edit', [
            'usuario' => $usuario,
            'csrf_token' => $_SESSION['csrf_token'],
            'mensagem' => $mensagem
        ]);
    }

}
