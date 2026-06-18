<?php

require_once __DIR__ . "/../models/acaosolidarias.php";
require_once __DIR__ . "/../config/Databasesingle.php";

class AcaoSolidariaDAO
{
  private PDO $conn;

  public function __construct()
  {
    $this->conn = Databasesingle::connect();
  }

  public function findAll(): array
  {
    $sql = "
      SELECT id, id_user, data_hora_inicio, nome_acao
      FROM acao_solidarias
      ORDER BY id DESC
    ";

    $stmt = $this->conn->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $acoes = [];

    foreach ($rows as $row) {
      $acoes[] = $this->mapRowToAcaoSolidaria($row);
    }

    return $acoes;
  }

  public function findByUserId(int $idUser): array
  {
    $sql = "
      SELECT id, id_user, data_hora_inicio, nome_acao
      FROM acao_solidarias
      WHERE id_user = ?
      ORDER BY id DESC
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$idUser]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $acoes = [];

    foreach ($rows as $row) {
      $acoes[] = $this->mapRowToAcaoSolidaria($row);
    }

    return $acoes;
  }

  public function create(AcaoSolidaria $acao): ?AcaoSolidaria
  {
    $sql = "
      INSERT INTO acao_solidarias 
        (id_user, data_hora_inicio, nome_acao)
      VALUES 
        (?, ?, ?)
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      $acao->getIdUser(),
      $acao->getDataHoraInicio(),
      $acao->getNomeAcao()
    ]);

    $id = (int)$this->conn->lastInsertId();

    return $this->findById($id);
  }

  public function findById(int $id): ?AcaoSolidaria
  {
    $sql = "
      SELECT 
        a.id,
        a.id_user,
        a.data_hora_inicio,
        a.nome_acao,
        d.descricao,
        d.como_ajudar
      FROM acao_solidarias a
      LEFT JOIN detalhe_acao_solidarias d ON d.id_acao_solidaria = a.id
      WHERE a.id = ?
      LIMIT 1
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
      return null;
    }

    return $this->mapRowToAcaoSolidaria($row);
  }



  public function createFromArray(array $data): ?AcaoSolidaria
  {
    $acao = new AcaoSolidaria();
    $acao->setIdUser((int)$data['id_user']);
    $acao->setDataHoraInicio($data['data_hora_inicio']);
    $acao->setNomeAcao(trim($data['nome_acao']));

    return $this->create($acao);
  }

  public function update(int $id, array $data): bool
  {
    $sql = "
      UPDATE acao_solidarias
      SET id_user = ?,
          data_hora_inicio = ?,
          nome_acao = ?
      WHERE id = ?
    ";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
      (int)$data['id_user'],
      $data['data_hora_inicio'],
      trim($data['nome_acao']),
      $id
    ]);
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM acao_solidarias WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id]);
  }

  private function mapRowToAcaoSolidaria(array $row): AcaoSolidaria
  {
    $acao = new AcaoSolidaria();

    $acao->setId((int)$row["id"]);
    $acao->setIdUser((int)$row["id_user"]);
    $acao->setDataHoraInicio($row["data_hora_inicio"]);
    $acao->setNomeAcao($row["nome_acao"]);

    if (array_key_exists("descricao", $row)) {
      $acao->setDescricao($row["descricao"]);
    }

    if (array_key_exists("como_ajudar", $row)) {
      $acao->setComoAjudar($row["como_ajudar"]);
    }

    return $acao;
  }
}
