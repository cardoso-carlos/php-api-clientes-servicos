<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\AgendamentoService;
use InvalidArgumentException;
use Throwable;

class AgendamentoController {
    private AgendamentoService $service;

    public function __construct(?AgendamentoService $service = null) {
        $this->service = $service ?? new AgendamentoService();
    }

    public function store(array $request): array {

         try {
            $id = $this->service->cadastrar($request);

            return [
                'success' => true,
                'message' => 'Agendamento cadastrado com sucesso.',
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
                'message' => 'Erro interno ao cadastrar Agendamento.',
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
                    'message' => 'Agendamento não encontrado.',
                    'data' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Agendamento encontrado com sucesso.',
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
                'message' => 'Erro interno ao buscar agendamento.',
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
                'message' => 'Lista de agendamento carregada com sucesso.',
                'data' => $dados,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao listar agendamento.',
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
                    ? 'Agendamento atualizado com sucesso.'
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
                'message' => 'Erro interno ao atualizar agendamento.',
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
                    ? 'Agendamento removido com sucesso.'
                    : 'Nenhum agendamento foi removido.',
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
                'message' => 'Erro interno ao remover agendamento.',
                'data' => null,
            ];
        }
    }
}