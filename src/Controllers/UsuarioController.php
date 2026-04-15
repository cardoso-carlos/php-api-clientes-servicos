<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\UsuarioService;
use InvalidArgumentException;
use Throwable;

class UsuarioController {
    private UsuarioService $service;

    public function __construct(?UsuarioService $service = null) {
        $this->service = $service ?? new UsuarioService();
    }

    public function store(array $request): array {
        try {
            $id = $this->service->cadastrar($request);

            return [
                'success' => true,
                'message' => 'Usuário cadastrado com sucesso.',
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
                'message' => 'Erro interno ao cadastrar usuário.',
                'data' => null,
            ];
        }
    }

    public function show(int $id): array {
        try {
            $usuario = $this->service->buscarPorId($id);

            if ($usuario === null) {
                return [
                    'success' => false,
                    'message' => 'Usuário não encontrado.',
                    'data' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Usuário encontrado com sucesso.',
                'data' => $usuario->toArray(),
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
                'message' => 'Erro interno ao buscar usuário.',
                'data' => null,
            ];
        }
    }

    public function index(): array {
        try {
            $usuarios = $this->service->listarTodos();

            $dados = [];

            foreach ($usuarios as $usuario) {
                $dados[] = $usuario->toArray();
            }

            return [
                'success' => true,
                'message' => 'Lista de usuários carregada com sucesso.',
                'data' => $dados,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Erro interno ao listar usuários.',
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
                    ? 'Usuário atualizado com sucesso.'
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
                'message' => 'Erro interno ao atualizar usuário.',
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
                    ? 'Usuário removido com sucesso.'
                    : 'Nenhum usuário foi removido.',
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
                'message' => 'Erro interno ao remover usuário.',
                'data' => null,
            ];
        }
    }
}