<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Agendamento;
use App\Repositories\AgendamentoRepository;
use App\Services\ClienteService;
use App\Services\ServicoService;
use InvalidArgumentException;

class AgendamentoService {
    private AgendamentoRepository $repository;
    private ClienteService $clienteService;
    private ServicoService $servicoService;

    public function __construct(
        ?AgendamentoRepository $repository = null,
        ?ClienteService $clienteService = null,
        ?ServicoService $servicoService = null
    ){
        $this->repository = $repository ?? new AgendamentoRepository();
        $this->clienteService = $clienteService ?? new ClienteService();
        $this->servicoService = $servicoService ?? new ServicoService();

    }

    private function validarStatus(string $status): void {
        $statusPermitidos = ['pendente', 'confirmado', 'concluido', 'cancelado'];

        if (!in_array($status, $statusPermitidos, true)) {
            throw new InvalidArgumentException(
                'Status inválido. Os status permitidos são: pendente, confirmado, concluido, cancelado.'
            );
        }
    }

    public function cadastrar(array $dados): int {
        $cliente_id = $dados['cliente_id'] ?? null;
        $servico_id = $dados['servico_id'] ?? null;
        $data_agendamento = $dados['data_agendamento'] ?? '';
        $status = $dados['status'] ?? '';
        $observacao = $dados['observacao'] ?? '';

        if (empty($cliente_id) || (int)$cliente_id <= 0) {
            throw new InvalidArgumentException('O id do cliente é obrigatório e deve ser maior que zero.');
        }

        if (empty($servico_id) || (int)$servico_id <= 0) {
            throw new InvalidArgumentException('O id do serviço é obrigatório e deve ser maior que zero.');
        }

        $existe_cliente = $this->clienteService->buscarPorId($cliente_id);
        if ($existe_cliente === null) {
            throw new InvalidArgumentException('O id do cliente não encontrado.');
        }

        $existe_servico = $this->servicoService->buscarPorId($servico_id);
        if ($existe_servico === null) {
            throw new InvalidArgumentException('O id do Serviço não encontrado.');
        }

        $this->validarStatus($status);

        $agendamento = new Agendamento(
            null,
            $cliente_id,
            $servico_id,
            $data_agendamento,
            $status,
            $observacao,
            date('Y-m-d H:i:s')
        );

        return $this->repository->inserir($agendamento);        
        
    }

    public function buscarPorId(int $id): ?Agendamento {
        if ($id <= 0) {
            throw new InvalidArgumentException('O id do agendamento deve ser maior que zero.');
        }

        return $this->repository->buscarPorId($id);      
    }

    public function listarTodos(): array {
        return $this->repository->listarTodos();
    }

    public function atualizar(int $id, array $dados): bool {
        if ($id <= 0) {
            throw new InvalidArgumentException('O id do agendamento deve ser maior que zero.');
        }  

        $agendamentoAtual = $this->repository->buscarPorId($id);

        if ($agendamentoAtual === null) {
            throw new InvalidArgumentException('Agendamento não encontrado para atualização.');
        }

        $cliente_id = $dados['cliente_id'] ?? $agendamentoAtual->getClienteId();
        $servico_id = $dados['servico_id'] ?? $agendamentoAtual->getServicoId();
        $data_agendamento = $dados['data_agendamento'] ?? $agendamentoAtual->getDataAgendamento();
        $status = $dados['status'] ?? $agendamentoAtual->getStatus();
        $observacao = $dados['observacao'] ?? $agendamentoAtual->getObservacao();

        $existe_cliente = $this->clienteService->buscarPorId($cliente_id);
        if ($existe_cliente === null) {
            throw new InvalidArgumentException('O id do cliente não encontrado.');
        }

        $existe_servico = $this->servicoService->buscarPorId($servico_id);
        if ($existe_servico === null) {
            throw new InvalidArgumentException('O id do Serviço não encontrado.');
        }

        $this->validarStatus($status);

        $agendamentoAtualizado = new Agendamento(
            $id,
            $cliente_id,
            $servico_id,
            $data_agendamento,
            $status,
            $observacao,
            $agendamentoAtual->getCriadoEm()
        );

        return $this->repository->atualizar($agendamentoAtualizado);

    }

    public function deletar(int $id): bool {
        if ($id <= 0) {
            throw new InvalidArgumentException('O id do agendamento deve ser maior que zero.');
        }  

        $agendamentoAtual = $this->repository->buscarPorId($id);

        if ($agendamentoAtual === null) {
            throw new InvalidArgumentException('Agendamento não encontrado para exclusão.');
        }   
        
        $status = $agendamentoAtual->getStatus();

        if($status === 'concluido'){
            throw new InvalidArgumentException('Agendamento concluído não pode ser excluso.');
        }

        return $this->repository->deletar($id);
    }


}