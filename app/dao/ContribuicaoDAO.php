<?php

require_once __DIR__ . "/../config/Databasesingle.php";

class ContribuicaoDAO
{
    private $conn;

    public function __construct()
    {
        $this->conn = Databasesingle::connect();
    }

    public function findAll(): array
    {
        $sql = "SELECT c.*, u.nome AS nome_user, u.email AS email_user
                FROM contribuicoes c
                LEFT JOIN users u ON u.id = c.id_user
                ORDER BY c.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUser(int $userId): array
    {
        $sql = "SELECT * FROM contribuicoes WHERE id_user = ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $userId, string $tipo, float $valor, string $metodoPagamento, string $observacao = '', string $estado = 'Pendente'): array
    {
        $sql = "INSERT INTO contribuicoes (id_user, tipo, valor, metodo_pagamento, observacao, estado)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId, $tipo, $valor, $metodoPagamento, $observacao, $estado]);
        return $this->findById((int)$this->conn->lastInsertId());
    }

    public function createFromArray(array $data): array
    {
        return $this->create(
            (int)$data['id_user'],
            trim($data['tipo']),
            (float)$data['valor'],
            trim($data['metodo_pagamento']),
            trim($data['observacao'] ?? ''),
            trim($data['estado'] ?? 'Pendente')
        );
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE contribuicoes
                SET id_user = ?, tipo = ?, valor = ?, metodo_pagamento = ?, observacao = ?, estado = ?
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            (int)$data['id_user'],
            trim($data['tipo']),
            (float)$data['valor'],
            trim($data['metodo_pagamento']),
            trim($data['observacao'] ?? ''),
            trim($data['estado'] ?? 'Pendente'),
            $id
        ]);
    }

    public function updateEstado(int $id, string $estado): bool
    {
        $sql = "UPDATE contribuicoes SET estado = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$estado, $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM contribuicoes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findById(int $id): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM contribuicoes WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: [];
    }

    public function countAll(): int
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM contribuicoes");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
