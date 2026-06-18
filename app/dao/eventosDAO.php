<?php

require_once __DIR__ . "/../models/eventos.php";
require_once __DIR__ . "/../config/Databasesingle.php";

class EventoDAO
{
  private PDO $conn;

  public function __construct()
  {
    $this->conn = Databasesingle::connect();
  }

  public function findAll(): array
  {
    $sql = "
      SELECT id, id_users, data_hora_inicio, nome_evento, tipo_evento
      FROM eventos
      ORDER BY id DESC
    ";

    $stmt = $this->conn->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $eventos = [];

    foreach ($rows as $row) {
      $eventos[] = $this->mapRowToEvento($row);
    }

    return $eventos;
  }

  public function findByUserId(int $idUser): array
  {
    $sql = "
      SELECT id, id_users, data_hora_inicio, nome_evento, tipo_evento
      FROM eventos
      WHERE id_users = ?
      ORDER BY id DESC
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$idUser]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $eventos = [];

    foreach ($rows as $row) {
      $eventos[] = $this->mapRowToEvento($row);
    }

    return $eventos;
  }

  public function create(Evento $evento): ?Evento
  {
    $sql = "
      INSERT INTO eventos 
        (id_users, data_hora_inicio, nome_evento, tipo_evento)
      VALUES 
        (?, ?, ?, ?)
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      $evento->getIdUsers(),
      $evento->getDataHoraInicio(),
      $evento->getNomeEvento(),
      $evento->getTipoEvento()
    ]);

    $id = (int)$this->conn->lastInsertId();

    return $this->findById($id);
  }

  public function findById(int $id): ?Evento
  {
    $sql = "
      SELECT id, id_users, data_hora_inicio, nome_evento, tipo_evento
      FROM eventos
      WHERE id = ?
      LIMIT 1
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null;
    }

    return $this->mapRowToEvento($row);
  }



  public function createFromArray(array $data): ?Evento
  {
    $evento = new Evento();
    $evento->setIdUsers((int)$data['id_users']);
    $evento->setDataHoraInicio($data['data_hora_inicio']);
    $evento->setNomeEvento(trim($data['nome_evento']));
    $evento->setTipoEvento(trim($data['tipo_evento']));

    return $this->create($evento);
  }

  public function update(int $id, array $data): bool
  {
    $sql = "
      UPDATE eventos
      SET id_users = ?,
          data_hora_inicio = ?,
          nome_evento = ?,
          tipo_evento = ?
      WHERE id = ?
    ";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
      (int)$data['id_users'],
      $data['data_hora_inicio'],
      trim($data['nome_evento']),
      trim($data['tipo_evento']),
      $id
    ]);
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM eventos WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
  }

  private function mapRowToEvento(array $row): Evento
  {
    $evento = new Evento();

    $evento->setId((int)$row["id"]);
    $evento->setIdUsers((int)$row["id_users"]);
    $evento->setDataHoraInicio($row["data_hora_inicio"]);
    $evento->setNomeEvento($row["nome_evento"]);
    $evento->setTipoEvento($row["tipo_evento"]);

    return $evento;
  }
}
