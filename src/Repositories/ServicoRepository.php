<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Config\Database;
use App\Models\Servico;
use PDO;

class ServicoRepository {
    private PDO $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function inserir(Servico $servico): int {
        $sql = 'INSERT INTO servicos (nome, descricao, valor, criado_em) 
                VALUES (:nome, :descricao, :valor, :criado_em)';
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':nome' => $servico->getNome(),
            ':descricao' => $servico->getDescricao(),
            ':valor' => $servico->getValor(),
            ':criado_em' => $servico->getCriadoEm(),
        ]);

        return (int) $this->connection->lastInsertId();
    }

    public function buscarPorId(int $id): ?Servico {
        $sql = 'SELECT id, nome, descricao, valor, criado_em
                FROM servicos
                WHERE id = :id';
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id'=>$id,
        ]);

        $row = $stmt->fetch();

        if(!$row) {
            return null;
        }

        return new Servico(
            (int) $row['id'],
            $row['nome'],
            $row['descricao'],
            $row['valor'],
            $row['criado_em']
        );

    }

    public function listarTodos(): array {
        $sql = 'SELECT id, nome, descricao, valor, criado_em
                FROM servicos
                ORDER BY id DESC';

        $stmt = $this->connection->query($sql);
        $rows = $stmt->fetchAll();

        $servicos = [];

        foreach($rows as $row) {
            $servicos[] = new Servico(
                (int) $row['id'],
                $row['nome'],
                $row['descricao'],
                $row['valor'],
                $row['criado_em']
            );
        }

        return $servicos;
    }

    public function atualizar(Servico $servico): bool {
        $id = $servico->getId();

        if($id === null || $id <= 0){
            throw new \InvalidArgumentException('O id do serviço é obrigatório para atualização.');
        }

        $sql = 'UPDATE servicos
                SET nome = :nome,
                    descricao = :descricao,
                    valor = :valor
                WHERE id = :id';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':nome' => $servico->getNome(),
            ':descricao' => $servico->getDescricao(),
            ':valor' => $servico->getValor(),
        ]);

        return $stmt->rowCount() > 0;
    }

    public function deletar(int $id): bool {
        $sql = 'DELETE FROM servicos WHERE id = :id';
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id,]);

        return $stmt->rowCount() > 0;
    }
}