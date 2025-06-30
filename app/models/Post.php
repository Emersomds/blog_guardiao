<?php
require_once __DIR__ . '/../../config/Database.php';

class Post {
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    // Método antigo (ainda pode ser usado onde não há paginação)
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT id, titulo, conteudo, data_publicacao, imagem FROM posts ORDER BY data_publicacao DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //  Método para obter posts paginados
    public function getPaginados($limite, $offset)
    {
        $stmt = $this->pdo->prepare("SELECT id, titulo, conteudo, data_publicacao, imagem FROM posts ORDER BY data_publicacao DESC LIMIT :limite OFFSET :offset");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //  Método para contar o total de posts
    public function contarPosts()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM posts");
        return $stmt->fetchColumn();
    }

    public function criar($titulo, $conteudo, $imagem, $autor_id)
    {
        $stmt = $this->pdo->prepare("INSERT INTO posts (titulo, conteudo, imagem, autor_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $conteudo, $imagem, $autor_id]);
    }



    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $titulo, $conteudo, $imagem = null)
    {
        if ($imagem) {
            $stmt = $this->pdo->prepare("UPDATE posts SET titulo = ?, conteudo = ?, imagem = ? WHERE id = ?");
            $stmt->execute([$titulo, $conteudo, $imagem, $id]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE posts SET titulo = ?, conteudo = ? WHERE id = ?");
            $stmt->execute([$titulo, $conteudo, $id]);
        }
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function getPorUsuario($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT id, titulo, conteudo, data_publicacao, imagem FROM posts WHERE autor_id = ? ORDER BY data_publicacao DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
