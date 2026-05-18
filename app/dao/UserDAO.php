<?php
 
require_once __DIR__ . '/../config/DataBase.php';
require_once __DIR__ . '/../models/User.php';
 
class UserDAO {
    private $conn;
 
    public function __construct() {
        // Conectar á base de dados
        $this->conn = (new DataBase())->connect();
    }
 
    public function findByEmail(string $email): ?User {
    $sql = "SELECT * FROM users WHERE email = :email AND is_admin = 1 LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    if ($row) {
            return new User(
                $row['id'],
                $row['is_admin'],
                $row['nome'],
                $row['telefone'],
                $row['email'],
                $row['data_resgito'],
                $row['estado'],
                $row['password']
            );
        }
 
        return null;
    }

    public function getUsersCount(): int
    {
        $sql = "SELECT COUNT(*) FROM users
                WHERE is_admin = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
 
        return (int) $stmt->fetchColumn();
    }

    public function getEventCount(): int
    {
        $sql = "SELECT COUNT(*) FROM eventos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
 
        return (int) $stmt->fetchColumn();
    }

    public function getApoioSocialCount(): int
    {
        $sql = "SELECT COUNT(*) FROM apoio_sociais";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
 
        return (int) $stmt->fetchColumn();
    }

    public function getPedidosOracaoCount(): int
    {
        $sql = "SELECT COUNT(*) FROM pedido_oracoes";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
 
        return (int) $stmt->fetchColumn();
    }

    public function getUsers(): array
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
 
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User(
                $row['id'],
                $row['is_admin'],
                $row['nome'],
                $row['telefone'],
                $row['email'],
                $row['data_resgito'],
                $row['estado'],
                $row['password']
            );
        }
 
        return $users;
    }

}