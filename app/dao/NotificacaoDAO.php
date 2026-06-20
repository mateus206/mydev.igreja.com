<?php

require_once __DIR__ . "/../config/Databasesingle.php";

class NotificacaoDAO
{
    private $conn;

    public function __construct()
    {
        $this->conn = Databasesingle::connect();
    }

    public function findAll(): array
    {
        $sql = "SELECT n.*, u.nome AS nome_user, u.email AS email_user
                FROM notificacoes n
                LEFT JOIN users u ON u.id = n.id_user
                ORDER BY n.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUser(int $userId): array
    {
        $sql = "SELECT * FROM notificacoes
                WHERE id_user IS NULL OR id_user = ?
                ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(?int $userId, string $titulo, string $mensagem, string $tipo = 'Geral'): array
    {
        $sql = "INSERT INTO notificacoes (id_user, titulo, mensagem, tipo, lida)
                VALUES (?, ?, ?, ?, 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId, $titulo, $mensagem, $tipo]);
        return $this->findById((int)$this->conn->lastInsertId());
    }

    public function createFromArray(array $data): array
    {
        $userId = isset($data['id_user']) && $data['id_user'] !== '' ? (int)$data['id_user'] : null;
        return $this->create($userId, trim($data['titulo']), trim($data['mensagem']), trim($data['tipo'] ?? 'Geral'));
    }

    public function update(int $id, array $data): bool
    {
        $userId = isset($data['id_user']) && $data['id_user'] !== '' ? (int)$data['id_user'] : null;
        $sql = "UPDATE notificacoes SET id_user = ?, titulo = ?, mensagem = ?, tipo = ?, lida = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $userId,
            trim($data['titulo']),
            trim($data['mensagem']),
            trim($data['tipo'] ?? 'Geral'),
            (int)($data['lida'] ?? 0),
            $id
        ]);
    }

    public function marcarLida(int $id, int $userId): bool
    {
        $sql = "UPDATE notificacoes SET lida = 1 WHERE id = ? AND (id_user IS NULL OR id_user = ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id, $userId]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM notificacoes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findById(int $id): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM notificacoes WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: [];
    }

    public function countAll(): int
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM notificacoes");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
