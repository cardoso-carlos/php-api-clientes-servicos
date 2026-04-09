<?php 

declare(strict_types=1);

namespace App\Models;

class Cliente {
    private ?int $id;
    private string $nome;
    private string $email;
    private ?string $telefone;
    private ?string $criadoEm;


    public function __construct(?int $id, string $nome, string $email, ?string $telefone = null, ?string $criadoEm = null) {

        $this->id = $id;
        $this->setNome($nome);
        $this->setEmail($email);
        $this->telefone = $telefone;
        $this->criadoEm = $criadoEm;
       
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

    public function getTelefone(): ?string {
        return $this->telefone;
    }

    public function getCriadoEm(): ?string {
        return $this->criadoEm;
    }

    public function setNome(string $nome): void {
        $nome = trim($nome);
        if ($nome === '') {
            throw new \InvalidArgumentException('O nome do cliente é obrigatório');
        }

        $this->nome = $nome;
    }

    public function setEmail(string $email): void {
        $email = trim($email);

        if ($email === '') {
            throw new \InvalidArgumentException('O e-mail do cliente é obrigatório.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('O e-mail informado é inválido.');
        }

        $this->email = $email;
    }

    public function setTelefone(?string $telefone): void {
        $this->telefone = $telefone !== null ? trim($telefone) : null;
    }

    public function setCriadoEm(?string $criadoEm): void {
        $this->criadoEm = $criadoEm;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'criado_em' => $this->criadoEm,
        ];
    }

}