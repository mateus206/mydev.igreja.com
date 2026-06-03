<?php

require_once __DIR__ . "/../config/Databasesingle.php";

class ApoioSocialDAO
{
  private $conn;

  public function __construct()
  {
    $this->conn = Databasesingle::connect();
  }

  public function create($userId, $local, $codigoPostal, $telefone, $membrosDeFamilia, $pedidoAjuda): array
  {
    $sql = "
      INSERT INTO apoio_sociais (
        id_user,
        local,
        codigo_postal,
        telefone,
        membros_de_familia,
        pedido_ajuda
      )
      VALUES (?, ?, ?, ?, ?, ?)
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
      $userId,
      $local,
      $codigoPostal,
      $telefone,
      $membrosDeFamilia,
      $pedidoAjuda
    ]);

    return $this->findById((int)$this->conn->lastInsertId());
  }

  public function findById($id): array
  {
    $sql = "SELECT * FROM apoio_sociais WHERE id = ? LIMIT 1";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([$id]);

    $apoioSocial = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$apoioSocial) {
      return [];
    }

    return $apoioSocial;
  }
}
