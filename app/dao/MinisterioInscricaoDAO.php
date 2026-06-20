<?php

require_once __DIR__ . "/../config/Databasesingle.php";

class MinisterioInscricaoDAO
{
    private $conn;

    public function __construct()
    {
        $this->conn = Databasesingle::connect();
    }

    public function findAll(): array
    {
        $sql = "SELECT m.*, u.nome AS nome_user, u.email AS email_user
                FROM ministerios_inscricoes m
                LEFT JOIN users u ON u.id = m.id_user
                ORDER BY m.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUser(int $userId): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM ministerios_inscricoes WHERE id_user = ? ORDER BY id DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $userId, string $ministerio, string $experiencia = '', string $disponibilidade = '', string $mensagem = '', string $estado = 'Pendente'): array
    {
        $sql = "INSERT INTO ministerios_inscricoes (id_user, ministerio, experiencia, disponibilidade, mensagem, estado)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId, $ministerio, $experiencia, $disponibilidade, $mensagem, $estado]);
        return $this->findById((int)$this->conn->lastInsertId());
    }

    public function createFromArray(array $data): array
    {
        return $this->create(
            (int)$data['id_user'],
            trim($data['ministerio']),
            trim($data['experiencia'] ?? ''),
            trim($data['disponibilidade'] ?? ''),
            trim($data['mensagem'] ?? ''),
            trim($data['estado'] ?? 'Pendente')
        );
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE ministerios_inscricoes
                SET id_user = ?, ministerio = ?, experiencia = ?, disponibilidade = ?, mensagem = ?, estado = ?
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            (int)$data['id_user'],
            trim($data['ministerio']),
            trim($data['experiencia'] ?? ''),
            trim($data['disponibilidade'] ?? ''),
            trim($data['mensagem'] ?? ''),
            trim($data['estado'] ?? 'Pendente'),
            $id
        ]);
    }

    public function updateEstado(int $id, string $estado): bool
    {
        $stmt = $this->conn->prepare("UPDATE ministerios_inscricoes SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM ministerios_inscricoes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findById(int $id): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM ministerios_inscricoes WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: [];
    }

    public function countAll(): int
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM ministerios_inscricoes");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
