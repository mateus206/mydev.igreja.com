<?php

require_once __DIR__ . "/../config/Databasesingle.php";

class ApoioSocialDAO
{
  private $conn;

  public function __construct()
  {
    $this->conn = Databasesingle::connect();
  }

  public function findAll(): array
  {
    $sql = "SELECT * FROM apoio_sociais ORDER BY id DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

  public function createFromArray(array $data): array
  {
    return $this->create(
      (int)$data['id_user'],
      trim($data['local']),
      trim($data['codigo_postal']),
      trim($data['telefone']),
      (int)$data['membros_de_familia'],
      trim($data['pedido_ajuda'])
    );
  }

  public function update(int $id, array $data): bool
  {
    $sql = "
      UPDATE apoio_sociais
      SET id_user = ?,
          local = ?,
          codigo_postal = ?,
          telefone = ?,
          membros_de_familia = ?,
          pedido_ajuda = ?
      WHERE id = ?
    ";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
      (int)$data['id_user'],
      trim($data['local']),
      trim($data['codigo_postal']),
      trim($data['telefone']),
      (int)$data['membros_de_familia'],
      trim($data['pedido_ajuda']),
      $id
    ]);
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM apoio_sociais WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
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
