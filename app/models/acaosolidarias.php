<?php

class AcaoSolidaria
{
  private ?int $id = null;
  private ?int $id_user = null;
  private ?string $data_hora_inicio = null;
  private ?string $nome_acao = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(?int $id): void
  {
    $this->id = $id;
  }

  public function getIdUser(): ?int
  {
    return $this->id_user;
  }

  public function setIdUser(?int $id_user): void
  {
    $this->id_user = $id_user;
  }

  public function getDataHoraInicio(): ?string
  {
    return $this->data_hora_inicio;
  }

  public function setDataHoraInicio(?string $data_hora_inicio): void
  {
    $this->data_hora_inicio = $data_hora_inicio;
  }

  public function getNomeAcao(): ?string
  {
    return $this->nome_acao;
  }

  public function setNomeAcao(?string $nome_acao): void
  {
    $this->nome_acao = $nome_acao;
  }

  public function toArray(): array
  {
    return [
      "id" => $this->id,
      "id_user" => $this->id_user,
      "data_hora_inicio" => $this->data_hora_inicio,
      "nome_acao" => $this->nome_acao
    ];
  }
}