<?php

declare(strict_types=1);

namespace App\Models;

class Servico {
    private ?int $id;
    private string $nome;
    private string $descricao;
    private float $valor;
    private ?string $criadoEm;

    public function __construct(?int $id, string $nome, string $descricao, float $valor, ?string $criadoEm = null){

        $this->id = $id;
        $this->setNome($nome);
        $this->setDescricao($descricao);
        $this->setValor($valor);
        $this->criadoEm = $criadoEm;

    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }

    public function getValor(): float {
        return $this->valor;
    }

    public function getCriadoEm(): ?string {
        return $this->criadoEm;
    }

    public function setNome(string $nome): void {
        $nome = trim($nome);
        if($nome === '') {
            throw new \InvalidArgumentException('O nome do serviço é obrigatório');
        }

        $this->nome = $nome;
    }

    public function setDescricao(string $descricao): void {
        $descricao = trim($descricao);
        if($descricao === '') {
            throw new \InvalidArgumentException('A descricao do serviço é obrigatório');
        }

        $this->descricao = $descricao;
    }

    public function setValor(float $valor): void {
        
        if(is_null($valor) || empty($valor)){
            throw new \InvalidArgumentException('O valor do serviço é obrigatório');       
        }

        if(floatval($valor) <= 0) {
            throw new \InvalidArgumentException('O valor do serviço não pode ser menor o igual a zero.');    
        }

        $this->valor = $valor;
    }

    public function setCriadoEm(?string $criadoEm): void {
        $this->criadoEm = $criadoEm;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'valor' => $this->valor,
            'criado_em' => $this->criadoEm,
        ];
    }
}