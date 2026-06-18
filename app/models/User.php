<?php

class User
{
    private int $id;
    private bool $is_admin;
    private string $nome;
    private string $telefone;
    private string $email;
    private string $data_registro;
    private string $estado;
    private string $password;
    private bool $is_verified;

    public function __construct(
        int $id,
        bool $is_admin,
        string $nome,
        string $telefone,
        string $email,
        string $data_registro,
        string $estado,
        string $password,
        bool $is_verified
    ) {
        $this->id = $id;
        $this->is_admin = $is_admin;
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->data_registro = $data_registro;
        $this->estado = $estado;
        $this->password = $password;
        $this->is_verified = $is_verified;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getIsAdmin(): bool
    {
        return $this->is_admin;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDataRegistro(): string
    {
        return $this->data_registro;
    }

    // Compatibilidade com a coluna antiga usada no projeto: data_resgito
    public function getDataResgito(): string
    {
        return $this->data_registro;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getIsVerified(): bool
    {
        return $this->is_verified;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "is_admin" => $this->is_admin,
            "nome" => $this->nome,
            "telefone" => $this->telefone,
            "email" => $this->email,
            "data_registro" => $this->data_registro,
            "estado" => $this->estado,
            "is_verified" => $this->is_verified
        ];
    }
}