<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Config\Database;
use App\Models\Agendamento;
use PDO;

class AgendamentoRepository {
    private PDO $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function inserir(Agendamento $agendamento): int {
        $sql = 'INSERT INTO agendamentos (cliente_id, servico_id, data_agendamento,
                status, observacao, criado_em) 
                VALUES (:cliente_id, :servico_id, :data_agendamento, 
                :status, :observacao, :criado_em)';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':cliente_id' => $agendamento->getClienteId(),
            ':servico_id' => $agendamento->getServicoId(),
            ':data_agendamento' => $agendamento->getDataAgendamento(),
            ':status' => $agendamento->getStatus(),
            ':observacao' => $agendamento->getObservacao(),
            ':criado_em' => $agendamento->getCriadoEm(),
        ]);

        return (int)$this->connection->lastInsertId();
    }

    public function buscarPorId(int $id): ?Agendamento {

        $sql = 'SELECT id, cliente_id, servico_id, data_agendamento,
                status, observacao, criado_em
                FROM agendamentos
                WHERE id = :id';
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id,]);

        $row = $stmt->fetch();

        if(!$row) {
            return null;
        }

        return new Agendamento(
            (int) $row['id'],
            (int) $row['cliente_id'],
            (int) $row['servico_id'],
            $row['data_agendamento'],
            $row['status'],
            $row['observacao'],
            $row['criado_em']
        );
    }

    public function listarTodos(): array {
        $sql = 'SELECT id, cliente_id, servico_id, data_agendamento,
            status, observacao, criado_em
            FROM agendamentos
            ORDER BY id DESC ';

        $stmt = $this->connection->query($sql);
        $rows = $stmt->fetchAll();

        $agendamentos = [];
        
        foreach($rows as $row) {
            $agendamentos[] = new Agendamento(
                (int) $row['id'],
                (int) $row['cliente_id'],
                (int) $row['servico_id'],
                $row['data_agendamento'],
                $row['status'],
                $row['observacao'],
                $row['criado_em']   
            );
        }

        return $agendamentos;
    }

    public function atualizar(Agendamento $agendamento): bool {
        $id = $agendamento->getId();

        if($id === null || $id <= 0){
            throw new \InvalidArgumentException('O id do Agendamento é obrigatório para atualização.');
        }

        $sql = 'UPDATE agendamentos
                SET cliente_id = :cliente_id,
                    servico_id = :servico_id,
                    data_agendamento = :data_agendamento,
                    status = :status,
                    observacao = :observacao
                    WHERE id = :id';
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id' =>$id,
            ':cliente_id' => $agendamento->getClienteId(),
            ':servico_id' => $agendamento->getServicoId(),
            ':data_agendamento' => $agendamento->getDataAgendamento(),
            ':status' => $agendamento->getStatus(),
            ':observacao' => $agendamento->getObservacao(),
        ]);

        return $stmt->rowCount() > 0;

    }

    public function deletar(int $id): bool {        
        $sql = 'DELETE FROM agendamentos WHERE id = :id';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id,]);
        return $stmt->rowCount() > 0;
    }
}