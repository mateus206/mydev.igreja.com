<?php

class AcaoSolidaria
{
  private ?int $id = null;
  private ?int $id_user = null;
  private ?string $data_hora_inicio = null;
  private ?string $nome_acao = null;
  private ?string $descricao = null;
  private ?string $como_ajudar = null;

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

  public function getDescricao(): ?string
  {
    return $this->descricao;
  }

  public function setDescricao(?string $descricao): void
  {
    $this->descricao = $descricao;
  }

  public function getComoAjudar(): ?string
  {
    return $this->como_ajudar;
  }

  public function setComoAjudar(?string $como_ajudar): void
  {
    $this->como_ajudar = $como_ajudar;
  }

  public function toArray(): array
  {
    $data = [
      "id" => $this->id,
      "id_user" => $this->id_user,
      "data_hora_inicio" => $this->data_hora_inicio,
      "nome_acao" => $this->nome_acao
    ];

    if ($this->descricao !== null || $this->como_ajudar !== null) {
      $data["detalhe_acao_solidaria"] = [
        "descricao" => $this->descricao,
        "como_ajudar" => $this->como_ajudar
      ];
    }

    return $data;
  }
}
