<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use InvalidArgumentException;

class ClienteService {
    private ClienteRepository $repository;

    public function __construct(?ClienteRepository $repository = null) {
        $this->repository = $repository ?? new ClienteRepository();
    }

    public function cadastrar(array $dados): int {
        $nome = $dados['nome'] ?? '';
        $email = $dados['email'] ?? '';
        $telefone = $dados['telefone'] ?? null;

        $clienteExistente = $this->repository->buscarPorEmail($email);

        if ($clienteExistente !== null) {
            throw new InvalidArgumentException('Já existe um cliente cadastrado com esse e-mail.');
        }

        $cliente = new Cliente(
            null,
            $nome,
            $email,
            $telefone,
            date('Y-m-d H:i:s')
        );

        return $this->repository->inserir($cliente);
    }

    public function buscarPorId(int $id): ?Cliente {
        if ($id <= 0) {
            throw new InvalidArgumentException('O id do cliente deve ser maior que zero.');
        }

        return $this->repository->buscarPorId($id);
    }

    public function listarTodos(): array {
        return $this->repository->listarTodos();
    }

    public function atualizar(int $id, array $dados): bool {
        if ($id <= 0) {
            throw new InvalidArgumentException('O id do cliente deve ser maior que zero.');
        }

        $clienteAtual = $this->buscarPorId($id);

        if ($clienteAtual === null) {
            throw new InvalidArgumentException('Cliente não encontrado para atualização.');
        }

        $nome = $dados['nome'] ?? $clienteAtual->getNome();
        $email = $dados['email'] ?? $clienteAtual->getEmail();
        $telefone = $dados['telefone'] ?? $clienteAtual->getTelefone();

        $clienteComMesmoEmail = $this->repository->buscarPorEmail($email);

        if ($clienteComMesmoEmail !== null && $clienteComMesmoEmail->getId() !== $id) {
            throw new InvalidArgumentException('Já existe um cliente cadastrado com esse e-mail.');
        }

        $clienteAtualizado = new Cliente(
            $id,
            $nome,
            $email,
            $telefone,
            $clienteAtual->getCriadoEm()
        );

        return $this->repository->atualizar($clienteAtualizado);
    }


    public function deletar(int $id): bool {
        if ($id <= 0) {
            throw new InvalidArgumentException('O id do cliente deve ser maior que zero.');
        }

        $clienteAtual = $this->repository->buscarPorId($id);

        if ($clienteAtual === null) {
            throw new InvalidArgumentException('Cliente não encontrado para exclusão.');
        }

        return $this->repository->deletar($id);
    }
}