<?php
require_once __DIR__ . '/../../config/Database.php';

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getTodos()
    {
        $stmt = $this->pdo->query("SELECT id, nome, email, criado_em FROM users ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarUsers()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM users");
        return $stmt->fetchColumn();
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function existeEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }


    public function criar($nome, $email, $senha, $role = 'user')
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (nome, email, senha, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $senha, $role]);
    }

    public function buscarPorId($id)
{
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function atualizar($id, $nome, $email, $role)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET nome = ?, email = ?, role = ? WHERE id = ?");
        $stmt->execute([$nome, $email, $role, $id]);
    }

}
