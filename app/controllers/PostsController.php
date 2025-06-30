<?php
class PostsController extends Controller
{

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
            // Verifica token CSRF
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $erros[] = 'CSRF inválido.';
            }

            $titulo = trim($_POST['titulo']);
            $conteudo = trim($_POST['conteudo']);
            $imagem = null;

            if (!empty($_FILES['imagem']['name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 2 * 1024 * 1024; // 2 MB

                $fileType = $_FILES['imagem']['type'];
                $fileSize = $_FILES['imagem']['size'];

                if (!in_array($fileType, $allowedTypes)) {
                    $erros[] = 'Tipo de arquivo não permitido. Use JPG, PNG ou GIF.';
                }

                if ($fileSize > $maxSize) {
                    $erros[] = 'Arquivo muito grande. O limite é 2MB.';
                }

                if (empty($erros)) {
                    $nomeTemp = $_FILES['imagem']['tmp_name'];
                    $nomeFinal = uniqid() . '_' . basename($_FILES['imagem']['name']);
                    $destino = __DIR__ . '/../../public/uploads/' . $nomeFinal;

                    if (move_uploaded_file($nomeTemp, $destino)) {
                        $imagem = $nomeFinal;
                    } else {
                        $erros[] = 'Erro ao enviar o arquivo.';
                    }
                }
            }

            if (empty($erros)) {
                $postModel = $this->model('Post');
                $postModel->criar($titulo, $conteudo, $imagem, $_SESSION['user_id']);

                // Registra log
                $logModel = $this->model('Log');
                $logModel->registrar($_SESSION['user_id'], "Criou um post: {$titulo}");

                $mensagem = "Post publicado com sucesso!";
            }
        }

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $this->view('posts/create', [
            'csrf_token' => $_SESSION['csrf_token'],
            'mensagem' => $mensagem,
            'erros' => $erros
        ]);
    }


    public function manage()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $postModel = $this->model('Post');

        if ($_SESSION['user_role'] === 'admin') {
            $posts = $postModel->getAll(); // Admin vê todos
        } else {
            $posts = $postModel->getPorUsuario($_SESSION['user_id']); // Usuário comum vê só os seus
        }

        $this->view('posts/manage', ['posts' => $posts]);
    }


    public function delete($id)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $postModel = $this->model('Post');
        $postModel->excluir($id);

        $logModel = $this->model('Log');
        $logModel->registrar($_SESSION['user_id'], "Excluiu o post ID: $id");
        header('Location: ' . BASE_URL . '/posts/manage');
        exit;
    }

    public function edit($id)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $postModel = $this->model('Post');
        $post = $postModel->buscarPorId($id);

        if (!$post) {
            die('Post não encontrado.');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF inválido');
            }

            $titulo = trim($_POST['titulo']);
            $conteudo = trim($_POST['conteudo']);
            $imagem = $post['imagem'];

            if (!empty($_FILES['imagem']['name'])) {
                $nomeTemp = $_FILES['imagem']['tmp_name'];
                $nomeFinal = uniqid() . '_' . basename($_FILES['imagem']['name']);
                $destino = __DIR__ . '/../../public/uploads/' . $nomeFinal;

                if (move_uploaded_file($nomeTemp, $destino)) {
                    $imagem = $nomeFinal;
                }
            }

            $postModel->atualizar($id, $titulo, $conteudo, $imagem);

            $logModel = $this->model('Log');
            $logModel->registrar($_SESSION['user_id'], "Editou o post ID: $id");

            header('Location: ' . BASE_URL . '/posts/manage');
            exit;
        }

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $this->view('posts/edit', [
            'post' => $post,
            'csrf_token' => $_SESSION['csrf_token']
        ]);
    }

    public function ver($id)
    {
        $postModel = $this->model('Post');
        $post = $postModel->buscarPorId($id);

        if (!$post) {
            die('Post não encontrado.');
        }

        $this->view('posts/ver', ['post' => $post]);
    }
}
