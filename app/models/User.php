<?php

class User
{
    private $id;
    private $is_admin;
    private $nome;
    private $telefone;
    private $email;
    private $data_registro;
    private $estado;
    private $password;
    private $is_verified;

    public function __construct(
        int $id = 0,
        bool $is_admin = false,
        string $nome = '',
        string $telefone = '',
        string $email = '',
        string $data_registro = '',
        string $estado = '',
        string $password = '',
        bool $is_verified = false
    )
    {
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

    // GETTERS
    public function getId()
    {
        return $this->id;
    }

    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getDataRegistro()
    {
        return $this->data_registro;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getIsVerified()
    {
        return $this->is_verified;
    }

    // SETTERS
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setDataRegistro($data_registro)
    {
        $this->data_registro = $data_registro;
    }

    public function setIsVerified($is_verified)
    {
        $this->is_verified = $is_verified;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'is_admin' => $this->is_admin,
            'nome' => $this->nome,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'data_registro' => $this->data_registro,
            'estado' => $this->estado,
            'is_verified' => $this->is_verified
        ];
    }
    public function toArray()
{
    return [
        'id' => $this->id,
        'is_admin' => $this->is_admin,
        'nome' => $this->nome,
        'telefone' => $this->telefone,
        'email' => $this->email,
        'data_resgito' => $this->data_resgito,
        'estado' => $this->estado
    ];
}
}