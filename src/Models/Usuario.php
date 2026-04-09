<?php

declare(strict_types=1);

namespace App\Models;

class Usuario {
    private ?int $id;
    private string $nome;
    private string $email;
    private string $senhaHash;
    private string $perfil;
    private ?string $criadoEm;

    public function __construct(?int $id, string $nome, string $email, string $senhaHash, string $perfil, ?string $criadoEm = null ) {
        $this->id = $id;
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenhaHash($senhaHash);
        $this->setPerfil($perfil);
        $this->setCriadoEm($criadoEm);
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getSenhaHash(): string {
        return $this->senhaHash;
    }

    public function getPerfil(): string {
        return $this->perfil;
    }

    public function getCriadoEm(): ?string {
        return $this->criadoEm;
    }

    public function setNome(string $nome): void {
        $nome = trim($nome);

        if ($nome === '') {
            throw new \InvalidArgumentException('O nome do usuário é obrigatório.');
        }

        $this->nome = $nome;
    }

    public function setEmail(string $email): void {
        $email = trim($email);

        if ($email === '') {
            throw new \InvalidArgumentException('O e-mail do usuário é obrigatório.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('O e-mail informado é inválido.');
        }

        $this->email = $email;
    }

    public function setSenhaHash(string $senhaHash): void {
        $senhaHash = trim($senhaHash);

        if ($senhaHash === '') {
            throw new \InvalidArgumentException('O hash da senha é obrigatório.');
        }

        $this->senhaHash = $senhaHash;
    }

    public function setPerfil(string $perfil): void {
        $perfil = trim($perfil);

        if ($perfil === '') {
            throw new \InvalidArgumentException('O perfil do usuário é obrigatório.');
        }

        $perfisPermitidos = ['admin', 'atendente'];

        if (!in_array($perfil, $perfisPermitidos, true)) {
            throw new \InvalidArgumentException('Perfil inválido. Use admin ou atendente.');
        }

        $this->perfil = $perfil;
    }

    public function setCriadoEm(?string $criadoEm): void {
        $this->criadoEm = $criadoEm;
    }

    public function verificarSenha(string $senhaPura): bool {
        return password_verify($senhaPura, $this->senhaHash);
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'perfil' => $this->perfil,
            'criado_em' => $this->criadoEm,
        ];
    }
}