<?php

class ApoioSocial
{
  private ?int $id = null;
  private ?int $id_user = null;
  private ?string $local = null;
  private ?string $codigo_postal = null;
  private ?string $contacto = null;
  private ?int $membros_familia = null;
  private ?string $pedido = null;
  private ?string $created_at = null;

  public function getId(): ?int { return $this->id; }
  public function setId(?int $id): void { $this->id = $id; }

  public function getIdUser(): ?int { return $this->id_user; }
  public function setIdUser(?int $id_user): void { $this->id_user = $id_user; }

  public function getLocal(): ?string { return $this->local; }
  public function setLocal(?string $local): void { $this->local = $local; }

  public function getCodigoPostal(): ?string { return $this->codigo_postal; }
  public function setCodigoPostal(?string $codigo_postal): void { $this->codigo_postal = $codigo_postal; }

  public function getContacto(): ?string { return $this->contacto; }
  public function setContacto(?string $contacto): void { $this->contacto = $contacto; }

  public function getMembrosFamilia(): ?int { return $this->membros_familia; }
  public function setMembrosFamilia(?int $membros_familia): void { $this->membros_familia = $membros_familia; }

  public function getPedido(): ?string { return $this->pedido; }
  public function setPedido(?string $pedido): void { $this->pedido = $pedido; }

  public function getCreatedAt(): ?string { return $this->created_at; }
  public function setCreatedAt(?string $created_at): void { $this->created_at = $created_at; }

  public function toArray(): array
  {
    return [
      "id" => $this->id,
      "id_user" => $this->id_user,
      "local" => $this->local,
      "codigo_postal" => $this->codigo_postal,
      "contacto" => $this->contacto,
      "membros_familia" => $this->membros_familia,
      "pedido" => $this->pedido,
      "created_at" => $this->created_at
    ];
  }
}
