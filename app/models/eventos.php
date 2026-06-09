<?php

class Evento
{
  private ?int $id = null;
  private ?int $id_users = null;
  private ?string $data_hora_inicio = null;
  private ?string $nome_evento = null;
  private ?string $tipo_evento = null;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(?int $id): void
  {
    $this->id = $id;
  }

  public function getIdUsers(): ?int
  {
    return $this->id_users;
  }

  public function setIdUsers(?int $id_users): void
  {
    $this->id_users = $id_users;
  }

  public function getDataHoraInicio(): ?string
  {
    return $this->data_hora_inicio;
  }

  public function setDataHoraInicio(?string $data_hora_inicio): void
  {
    $this->data_hora_inicio = $data_hora_inicio;
  }

  public function getNomeEvento(): ?string
  {
    return $this->nome_evento;
  }

  public function setNomeEvento(?string $nome_evento): void
  {
    $this->nome_evento = $nome_evento;
  }

  public function getTipoEvento(): ?string
  {
    return $this->tipo_evento;
  }

  public function setTipoEvento(?string $tipo_evento): void
  {
    $this->tipo_evento = $tipo_evento;
  }

  public function toArray(): array
  {
    return [
      "id" => $this->id,
      "id_users" => $this->id_users,
      "data_hora_inicio" => $this->data_hora_inicio,
      "nome_evento" => $this->nome_evento,
      "tipo_evento" => $this->tipo_evento
    ];
  }
}
