<?php

require_once __DIR__ . "/../config/Databasesingle.php";

class PedidoOracaoDAO
{
  private $conn;

  public function __construct()
  {
    $this->conn = Databasesingle::connect();
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
