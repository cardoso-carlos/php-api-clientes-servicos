<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Servico;
use App\Repositories\ServicoRepository;
use InvalidArgumentException;

class ServicoService {
    private ServicoRepository $repository;

    public function __construct(?ServicoRepository $repository = null) {
        $this->repository = $repository ?? new ServicoRepository();
    }

    public function cadastrar(array $dados): int {
        $nome = $dados['nome'] ?? '';
        $descricao = $dados['descricao'] ?? '';
        $valor = $dados['valor'] ?? null;

        $servico = new Servico(
            null,
            $nome,
            $descricao,
            $valor,
            date('Y-m-d H:i:s')
        );

        return $this->repository->inserir($servico);
    }

    public function buscarPorId(int $id): ?Servico {
        if ($id <= 0) {
            throw new InvalidArgumentException('O id do serviço deve ser maior que zero.');
        }

        return $this->repository->buscarPorId($id);    
    }

    public function listarTodos(): array {
        return $this->repository->listarTodos();
    }

    public function atualizar(int $id, array $dados): bool {
        
        if ($id <= 0) {
            throw new InvalidArgumentException('O id do serviço deve ser maior que zero.');
        }

        $servicoAtual = $this->repository->buscarPorId($id);

        if ($servicoAtual === null) {
            throw new InvalidArgumentException('Serviço não encontrado para atualização.');
        }

        $nome = $dados['nome'] ?? $servicoAtual->getNome();
        $descricao = $dados['descricao'] ?? $servicoAtual->getDescricao();
        $valor = $dados['valor'] ?? $servicoAtual->getValor();


        $servicoAtualizado = new Servico(
            $id,
            $nome,
            $descricao,
            $valor,
            $servicoAtual->getCriadoEm()
        );

        return $this->repository->atualizar($servicoAtualizado);    

    }

    public function deletar(int $id): bool {
        if ($id <= 0) {
            throw new InvalidArgumentException('O id do serviço deve ser maior que zero.');
        }
        
        $servicoAtual = $this->repository->buscarPorId($id);

        if ($servicoAtual === null) {
            throw new InvalidArgumentException('Serviço não encontrado para atualização.');
        }

        return $this->repository->deletar($id);

    }
}