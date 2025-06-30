<?php
class HomeController extends Controller {
    public function index() {
        $postModel = $this->model('Post');

        $porPagina = 5;
        $pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
        $offset = ($pagina - 1) * $porPagina;

        $posts = $postModel->getPaginados($porPagina, $offset);
        $total = $postModel->contarPosts();
        $totalPaginas = ceil($total / $porPagina);

        $this->view('home/index', [
            'posts' => $posts,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas
        ]);
    }
}
