<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Usuario;
use App\Repositories\UsuarioRepository;
use InvalidArgumentException;

class UsuarioService {
    private UsuarioRepository $repository;

    public function __construct(?UsuarioRepository $repository = null) {
        $this->repository = $repository ?? new UsuarioRepository();
    }

    private function validarPerfil(string $perfil): void {
        $perfilPermitidos = ['admin', 'atendente'];

        if (!in_array($perfil, $perfilPermitidos, true)) {
            throw new InvalidArgumentException(
                'Perfil inválido. Os perfis permitidos são: admin, atendente.'
            );
        }
    }

    public function cadastrar(array $dados): int {
        $nome = $dados['nome'] ?? '';
        $email = $dados['email'] ?? '';
        $senha = $dados['senha'] ?? '';
        $perfil = $dados['perfil'] ?? '';

        if ($senha === '') {
            throw new InvalidArgumentException('A senha do usuário é obrigatória.');
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        if ($senhaHash === false) {
            throw new InvalidArgumentException('Não foi possível gerar o hash da senha do usuário.');
        }

        $usuarioExiste = $this->repository->buscarPorEmail($email);

        if ($usuarioExiste !== null) {
            throw new InvalidArgumentException('Já existe um usuário cadastrado com esse e-mail.');
        }

        $this->validarPerfil($perfil);

        $usuario = new Usuario(
            null,
            $nome,
            $email,
            $senhaHash,
            $perfil,
            date('Y-m-d H:i:s')
        );
      
        return $this->repository->inserir($usuario);
    }

    public function buscarPorId(int $id): ?Usuario {
        if ($id <= 0) {
            throw new InvalidArgumentException('O id do usuário deve ser maior que zero.');
        }

        return $this->repository->buscarPorId($id);
    }

    public function listarTodos(): array {
        return $this->repository->listarTodos();
    }

    public function atualizar(int $id, array $dados): bool {

        if ($id <= 0) {
            throw new InvalidArgumentException('O id do usuário deve ser maior que zero.');
        }

        $usuarioAtual = $this->repository->buscarPorId($id);

        if ($usuarioAtual === null) {
            throw new InvalidArgumentException('Usuário não encontrado para atualização.');
        }

        $nome = $dados['nome'] ?? $usuarioAtual->getNome();
        $email = $dados['email'] ?? $usuarioAtual->getEmail();
        $perfil = $dados['perfil'] ?? $usuarioAtual->getPerfil();
        $senhaHash = $usuarioAtual->getSenhaHash();

        if (array_key_exists('senha', $dados)) {
            $senha = (string) $dados['senha'];

            if ($senha === '') {
                throw new InvalidArgumentException('A senha do usuário é obrigatória.');
            }

            $novoHash = password_hash($senha, PASSWORD_DEFAULT);

            if ($novoHash === false) {
                throw new InvalidArgumentException('Não foi possível gerar o hash da senha do usuário.');
            }

            $senhaHash = $novoHash;
        }

        $usuarioExiste = $this->repository->buscarPorEmail($email);

        if ($usuarioExiste !== null && $usuarioExiste->getId() !== $id) {
            throw new InvalidArgumentException('Já existe um usuário cadastrado com esse e-mail.');
        }

        $this->validarPerfil($perfil);

        $usuarioAtualizado = new Usuario(
            $id,
            $nome,
            $email,
            $senhaHash,
            $perfil,
            $usuarioAtual->getCriadoEm()
        );

        return $this->repository->atualizar($usuarioAtualizado);

    }

    public function deletar(int $id): bool {
        if ($id <= 0) {
            throw new InvalidArgumentException('O id do usuário deve ser maior que zero.');
        }

        $usuarioAtual = $this->repository->buscarPorId($id);

        if ($usuarioAtual === null) {
            throw new InvalidArgumentException('Usuário não encontrado para exclusão.');
        }

        return $this->repository->deletar($id);
    }
}
