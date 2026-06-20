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

    public function findById(int $id): ?User
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

    public function setPasswordAndVerify(int $userId, string $hashedPassword): void
    {
        $sql = "
            UPDATE users
            SET password = ?,
                is_verified = 1,
                verified_at = NOW()
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$hashedPassword, $userId]);
    }

    public function updatePasswordById(int $id, string $hashedPassword): ?User
    {
        $sql = "
            UPDATE users
            SET password = ?,
                updated_at = NOW()
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$hashedPassword, $id]);

        return $this->findById($id);
    }


    public function updateProfileById(int $id, string $nome, string $telefone, string $email): ?User
    {
        $sql = "
            UPDATE users
            SET nome = ?,
                telefone = ?,
                email = ?,
                updated_at = NOW()
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nome, $telefone, $email, $id]);

        return $this->findById($id);
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
    }

    public function getEmailVerifications($userId): array
    {
        $sql = "SELECT * FROM email_verifications WHERE user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
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
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            (int)($data['is_admin'] ?? 0),
            trim($data['nome'] ?? ''),
            trim($data['telefone'] ?? ''),
            trim($data['email'] ?? ''),
            trim($data['estado'] ?? 'ativo'),
            password_hash($data['password'] ?? '123456', PASSWORD_DEFAULT),
            (int)($data['is_verified'] ?? 0)
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "
            UPDATE users
            SET is_admin = ?,
                nome = ?,
                telefone = ?,
                email = ?,
                estado = ?,
                is_verified = ?,
                updated_at = NOW()
            WHERE id = ?
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            (int)($data['is_admin'] ?? 0),
            trim($data['nome'] ?? ''),
            trim($data['telefone'] ?? ''),
            trim($data['email'] ?? ''),
            trim($data['estado'] ?? 'ativo'),
            (int)($data['is_verified'] ?? 0),
            $id
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "UPDATE users SET deleted_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

}