<?php

require_once __DIR__ . "/../config/Databasesingle.php";

class PedidoOracaoDAO
{
  private $conn;

  public function __construct()
  {
    $this->conn = Databasesingle::connect();
  }

  public function findAll(): array
  {
    $sql = "SELECT * FROM pedido_oracoes ORDER BY id DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function create($userId, $email, $tipoPedido, $descricao): array
  {
    $sql = "
      INSERT INTO pedido_oracoes (
        id_user,
        email,
        tipo_pedido,
        descricao
      )
      VALUES (?, ?, ?, ?)
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
      $userId,
      $email,
      $tipoPedido,
      $descricao
    ]);

    return $this->findById((int)$this->conn->lastInsertId());
  }

  public function createFromArray(array $data): array
  {
    return $this->create(
      (int)$data['id_user'],
      trim($data['email']),
      trim($data['tipo_pedido']),
      trim($data['descricao'])
    );
  }

  public function update(int $id, array $data): bool
  {
    $sql = "
      UPDATE pedido_oracoes
      SET id_user = ?,
          email = ?,
          tipo_pedido = ?,
          descricao = ?
      WHERE id = ?
    ";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
      (int)$data['id_user'],
      trim($data['email']),
      trim($data['tipo_pedido']),
      trim($data['descricao']),
      $id
    ]);
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM pedido_oracoes WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
  }

  public function findById($id): array
  {
    $sql = "SELECT * FROM pedido_oracoes WHERE id = ? LIMIT 1";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([$id]);

    $pedidoOracao = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pedidoOracao) {
      return [];
    }

    return $pedidoOracao;
  }
}
