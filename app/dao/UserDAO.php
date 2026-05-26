<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../config/Databasesingle.php";

class UserDAO
{
  private $conn;

  public function __construct()
  {
       $this->conn = Databasesingle::connect();

  }

  private function mapRowToUser(array $row): User
  {
    $user = new User(
      (int)$row["id"],
      (int)$row["is_admin"],
      (string)$row["nome"],
      (string)$row["telefone"],
      (string)$row["email"],
      $row["data_resgito"],
      (string)$row["estado"],
      (string)$row["password"]
    );

    return $user;
  }

  public function findByEmail($email): ?User
  {
    $sql = "
      SELECT
        id,
        is_admin,
        nome,
        telefone,
        email,
        data_resgito,
        estado,
        password
      FROM users
      WHERE email = ?
      LIMIT 1
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([$email]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null;
    }

    return $this->mapRowToUser($row);
  }

  public function createPending(string $nome, string $telefone, string $email, string $password): int
  {
    $sql = "
      INSERT INTO users (
        is_admin,
        nome,
        telefone,
        email,
        estado,
        password
      )
      VALUES (
        0,
        ?,
        ?,
        ?,
        'ativo',
        ?
      )
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([$nome, $telefone, $email, $password]);

    return (int)$this->conn->lastInsertId();
  }

  public function getUsersCount(): int
  {
    $sql = "
      SELECT COUNT(*)
      FROM users
      WHERE is_admin = 0
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute();

    return (int)$stmt->fetchColumn();
  }

  public function getEventCount(): int
  {
    $sql = "SELECT COUNT(*) FROM eventos";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute();

    return (int)$stmt->fetchColumn();
  }

  public function getApoioSocialCount(): int
  {
    $sql = "SELECT COUNT(*) FROM apoio_sociais";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute();

    return (int)$stmt->fetchColumn();
  }

  public function getPedidosOracaoCount(): int
  {
    $sql = "SELECT COUNT(*) FROM pedido_oracoes";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute();

    return (int)$stmt->fetchColumn();
  }

  public function getUsers(): array
  {
    $sql = "
      SELECT
        id,
        is_admin,
        nome,
        telefone,
        email,
        data_resgito,
        estado,
        password
      FROM users
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute();

    $users = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $users[] = $this->mapRowToUser($row);
    }

    return $users;
  }
}