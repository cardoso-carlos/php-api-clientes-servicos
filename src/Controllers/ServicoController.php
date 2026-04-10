<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\ServicoService;
use InvalidArgumentException;
use Throwable;

class ServicoController {
    private ServicoService $service;

    public function __construct(?ServicoService $service = null) {
        $this->service = $service ?? new ServicoService();
    }

    public function store(array $request): array {
        try {
            $id = $this->service->cadastrar($request);

            return [
                'success' => true,
                'message' => 'Serviço cadastrado com sucesso.',
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
                'message' => 'Erro interno ao cadastrar serviço.',
                'data' => null,
            ];
        }
    }

    public function show(int $id): array {
        try {
            $servico = $this->service->buscarPorId($id);

            if ($servico === null) {
                return [
                    'success' => false,
                    'message' => 'Serviço não encontrado.',
                    'data' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Serviço encontrado com sucesso.',
                'data' => $servico->toArray(),
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
                'message' => 'Erro interno ao buscar serviço.',
                'data' => null,
            ];
        }
    }

    public function index(): array {
        try {
            $servicos = $this->service->listarTodos();

            $dados = [];

            foreach ($servicos as $servico) {
                $dados[] = $servico->toArray();
            }

            return [
                'success' => true,
                'message' => 'Lista de serviços carregada com sucesso.',
                'data' => $dados,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao listar serviço.',
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
                    ? 'Serviço atualizado com sucesso.'
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
                'message' => 'Erro interno ao atualizar serviço.',
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
                    ? 'Serviço removido com sucesso.'
                    : 'Nenhum serviço foi removido.',
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
                'message' => 'Erro interno ao remover serviço.',
                'data' => null,
            ];
        }
    }
}