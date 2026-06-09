<?php

class PedidoOracao
{
  private ?int $id = null;
  private ?int $id_user = null;
  private ?string $email_ou_contacto = null;
  private ?string $tipo_pedido = null;
  private ?string $pedido = null;
  private ?string $created_at = null;

  public function getId(): ?int { return $this->id; }
  public function setId(?int $id): void { $this->id = $id; }

  public function getIdUser(): ?int { return $this->id_user; }
  public function setIdUser(?int $id_user): void { $this->id_user = $id_user; }

  public function getEmailOuContacto(): ?string { return $this->email_ou_contacto; }
  public function setEmailOuContacto(?string $email_ou_contacto): void { $this->email_ou_contacto = $email_ou_contacto; }

  public function getTipoPedido(): ?string { return $this->tipo_pedido; }
  public function setTipoPedido(?string $tipo_pedido): void { $this->tipo_pedido = $tipo_pedido; }

  public function getPedido(): ?string { return $this->pedido; }
  public function setPedido(?string $pedido): void { $this->pedido = $pedido; }

  public function getCreatedAt(): ?string { return $this->created_at; }
  public function setCreatedAt(?string $created_at): void { $this->created_at = $created_at; }

  public function toArray(): array
  {
    return [
      "id" => $this->id,
      "id_user" => $this->id_user,
      "email_ou_contacto" => $this->email_ou_contacto,
      "tipo_pedido" => $this->tipo_pedido,
      "pedido" => $this->pedido,
      "created_at" => $this->created_at
    ];
  }
}
