<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../config/Databasesingle.php";

class UserDAO
{
<<<<<<< HEAD
    private $conn;

    public function __construct()
    {
        $this->conn = Databasesingle::connect();
    }

    private function mapRowToUser(array $row): User
    {
        return new User(
            (int)$row["id"],
            (bool)$row["is_admin"],
            (string)$row["nome"],
            (string)($row["telefone"] ?? ''),
            (string)$row["email"],
            (string)$row["data_registro"],
            (string)($row["estado"] ?? ''),
            (string)$row["password"],
            (bool)$row["is_verified"]
        );
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
                data_registro,
                estado,
                password,
                is_verified
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

    // CORRIGIDO: ordem dos parâmetros era ($nome, $email, $telefone) mas o SQL inseria ($nome, $telefone, $email)
    public function createPending(string $nome, string $email, string $telefone, string $password): int
    {
        $sql = "
            INSERT INTO users (
                is_admin,
                nome,
                telefone,
                email,
                estado,
                password,
                is_verified
            )
            VALUES (
                0,
                ?,
                ?,
                ?,
                'ativo',
                ?,
                0
            )
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nome, $telefone, $email, $password]);

        return (int)$this->conn->lastInsertId();
    }

    // NOVO: define a password e marca o utilizador como verificado numa única query
    public function setPasswordAndVerify(int $userId, string $hashedPassword): void
    {
        $sql = "
            UPDATE users
            SET password    = ?,
                is_verified = 1
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$hashedPassword, $userId]);
    }

    public function getUsersCount(): int
    {
        $sql = "SELECT COUNT(*) FROM users WHERE is_admin = 0";

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
                data_registro,
                estado,
                password,
                is_verified
            FROM users
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $users = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $this->mapRowToUser($row);
        }

        return $users;
=======
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
  public function findById(int $id): ?User
  {
    $sql = "
          SELECT
            id, nome, email, password, is_admin, telefone, data_resgito, estado,is_verified
          FROM users
          WHERE id = ?
          LIMIT 1
        ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {  
      return null;
>>>>>>> a9084eda2b8985184fe23df517e6fc84744efd33
    }
     return $this->mapRowToUser($row);
}
  public function getEmailVerifications($userId) {
    $sql = "SELECT * FROM email_verifications WHERE user_id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([$userId]);

    $emailVerifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $emailVerifications;
  }

  public function updatePasswordById(int $id, string $hashedPassword): ?User
  {
    $sql = "
      UPDATE users
      SET password = ?
      WHERE id = ?
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$hashedPassword, $id]);

    return $this->findById($id);
  }

    public function findById(int $id): ?User
    {
        $sql = "
            SELECT
                id,
                nome,
                email,
                password,
                is_admin,
                telefone,
                data_registro,
                estado,
                is_verified
            FROM users
            WHERE id = ?
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->mapRowToUser($row);
    }

    public function getEmailVerifications($userId)
    {
        $sql = "SELECT * FROM email_verifications WHERE user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePasswordById(int $id, string $hashedPassword): ?User
    {
        $sql = "
            UPDATE users
            SET password = ?
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$hashedPassword, $id]);

        return $this->findById($id);
    }
}