<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Config\Database;
use App\Models\Cliente;
use PDO;

class ClienteRepository {
    private PDO $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function inserir(Cliente $cliente): int {
        $sql = 'INSERT INTO clientes (nome, email, telefone, criado_em)
                VALUES (:nome, :email, :telefone, :criado_em)';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':nome' => $cliente->getNome(),
            ':email' => $cliente->getEmail(),
            ':telefone' => $cliente->getTelefone(),
            ':criado_em' => $cliente->getCriadoEm(),
        ]);

        return (int) $this->connection->lastInsertId();
    }

    public function buscarPorId(int $id): ?Cliente {
        $sql = 'SELECT id, nome, email, telefone, criado_em
                FROM clientes
                WHERE id = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id' => $id,
        ]);

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Cliente(
            (int) $row['id'],
            $row['nome'],
            $row['email'],
            $row['telefone'],
            $row['criado_em']
        );
    }

    public function listarTodos(): array {
        $sql = 'SELECT id, nome, email, telefone, criado_em
                FROM clientes
                ORDER BY id DESC';

        $stmt = $this->connection->query($sql);
        $rows = $stmt->fetchAll();

        $clientes = [];

        foreach ($rows as $row) {
            $clientes[] = new Cliente(
                (int) $row['id'],
                $row['nome'],
                $row['email'],
                $row['telefone'],
                $row['criado_em']
            );
        }

        return $clientes;
    }

    public function buscarPorEmail(string $email): ?Cliente {
        $sql = 'SELECT id, nome, email, telefone, criado_em
                FROM clientes
                WHERE email = :email';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':email' => $email,
        ]);

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Cliente(
            (int) $row['id'],
            $row['nome'],
            $row['email'],
            $row['telefone'],
            $row['criado_em']
        );
    }

    public function atualizar(Cliente $cliente): bool {
        $id = $cliente->getId();

        if($id === null || $id <= 0){
            throw new \InvalidArgumentException('O id do cliente é obrigatório para atualização.');
        }

        $sql = 'UPDATE clientes 
                SET nome = :nome,
                    email= :email,
                    telefone = :telefone
                WHERE id = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':nome' => $cliente->getNome(),
            ':email' => $cliente->getEmail(),
            ':telefone' => $cliente->getTelefone(),
        ]);

        return $stmt->rowCount() > 0;
    }

    public function deletar(int $id): bool {
        $sql = 'DELETE FROM clientes WHERE id = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id,]);
        
        return $stmt->rowCount() > 0;
    }

}