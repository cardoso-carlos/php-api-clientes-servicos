<?php

declare(strict_types=1);

namespace App\Models;

class Agendamento {
    private ?int $id;
    private int $clienteId;
    private int $servicoId;
    private string $dataAgendamento;
    private string $status;
    private ?string $observacao;
    private ?string $criadoEm;

    public function __construct(?int $id, int $clienteId, int $servicoId, string $dataAgendamento, string $status, ?string $observacao = null, ?string $criadoEm = null) {
        $this->id = $id;
        $this->setClienteId($clienteId);
        $this->setServicoId($servicoId);
        $this->setDataAgendamento($dataAgendamento);
        $this->setStatus($status);
        $this->setObservacao($observacao);
        $this->setCriadoEm($criadoEm);
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getClienteId(): int {
        return $this->clienteId;
    }

    public function getServicoId(): int {
        return $this->servicoId;
    }

    public function getDataAgendamento(): string {
        return $this->dataAgendamento;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function getObservacao(): ?string {
        return $this->observacao;
    }

    public function getCriadoEm(): ?string {
        return $this->criadoEm;
    }

    public function setClienteId(int $clienteId): void {
        if ($clienteId <= 0) {
            throw new \InvalidArgumentException('O cliente do agendamento é obrigatório.');
        }
        $this->clienteId = $clienteId;
    }

    public function setServicoId(int $servicoId): void {
        if ($servicoId <= 0){
            throw new \InvalidArgumentException('O serviço do agendamento é obrigatório.');
        }

        $this->servicoId = $servicoId;
    }

    public function setDataAgendamento(string $dataAgendamento): void {
        $dataAgendamento = trim($dataAgendamento);
        if ($dataAgendamento === '') {
            throw new \InvalidArgumentException('A data do agendamento é obrigatória.');
        }
        $this->dataAgendamento = $dataAgendamento;
    }

    public function setStatus(string $status): void {
        $status = trim($status);
        if ($status === '') {
            throw new \InvalidArgumentException('O status do agendamento é obrigatório.');
        }

        $statusPermitidos = ['pendente', 'confirmado', 'concluido', 'cancelado'];

        if (!in_array($status, $statusPermitidos, true)) {
            throw new \InvalidArgumentException(
                'Status inválido. Os status permitidos são: pendente, confirmado, concluido, cancelado.'
            );
        }
        $this->status = $status;
    }

    public function setObservacao(?string $observacao): void {
        $this->observacao = $observacao !== null ? trim($observacao) : null;
    }

    public function setCriadoEm(?string $criadoEm): void {
        $this->criadoEm = $criadoEm;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'cliente_id' => $this->clienteId,
            'servico_id' => $this->servicoId,
            'data_agendamento' => $this->dataAgendamento,
            'status' => $this->status,
            'observacao' => $this->observacao,
            'criado_em' => $this->criadoEm,
        ];
    }
}