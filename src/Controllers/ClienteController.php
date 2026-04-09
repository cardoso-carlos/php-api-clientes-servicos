<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\ClienteService;
use InvalidArgumentException;
use Throwable;

class ClienteController {
    private ClienteService $service;

    public function __construct(?ClienteService $service = null) {
        $this->service = $service ?? new ClienteService();
    }

    public function store(array $request): array {
        try {
            $id = $this->service->cadastrar($request);

            return [
                'success' => true,
                'message' => 'Cliente cadastrado com sucesso.',
                'data' => [
                    'id' => $id,
                ],
            ];
        } catch (InvalidArgumentException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao cadastrar cliente.',
                'data' => null,
            ];
        }
    }

    public function show(int $id): array {
        try {
            $cliente = $this->service->buscarPorId($id);

            if ($cliente === null) {
                return [
                    'success' => false,
                    'message' => 'Cliente não encontrado.',
                    'data' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Cliente encontrado com sucesso.',
                'data' => $cliente->toArray(),
            ];
        } catch (InvalidArgumentException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao buscar cliente.',
                'data' => null,
            ];
        }
    }

    public function index(): array {
        try {
            $clientes = $this->service->listarTodos();

            $dados = [];

            foreach ($clientes as $cliente) {
                $dados[] = $cliente->toArray();
            }

            return [
                'success' => true,
                'message' => 'Lista de clientes carregada com sucesso.',
                'data' => $dados,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao listar clientes.',
                'data' => null,
            ];
        }
    }

    public function update(int $id, array $request): array{

        try{
            $atualizado = $this->service->atualizar($id, $request);

            return [
                'success' => $atualizado,
                'message' => $atualizado
                    ? 'Cliente atualizado com sucesso.'
                    : 'Nenhuma alteração foi realizada.',
                'data' => [
                    'updated' => $atualizado,
                ],
            ];

        }catch (InvalidArgumentException $e){
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao atualizar cliente.',
                'data' => null,
            ];
        }
    }

    public function destroy(int $id): array {
        try {
            $deletado = $this->service->deletar($id);

            return [
                'success' => $deletado,
                'message' => $deletado
                    ? 'Cliente removido com sucesso.'
                    : 'Nenhum cliente foi removido.',
                'data' => [
                    'deleted' => $deletado,
                ],
            ];
        } catch (InvalidArgumentException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao remover cliente.',
                'data' => null,
            ];
        }
    }
}