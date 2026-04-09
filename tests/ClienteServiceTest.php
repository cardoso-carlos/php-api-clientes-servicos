<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use App\Services\ClienteService;

final class ClienteServiceTest extends TestCase
{
    public function testDeveAtualizarClienteComDadosValidos(): void
    {
        $repository = $this->createMock(ClienteRepository::class);

        $cliente = new Cliente(
            1,
            'Carlos Augusto',
            'carlos@email.com',
            '62999999999',
            '2026-04-08 17:40:05'
        );

        $repository->method('buscarPorId')->with(1)->willReturn($cliente);
        $repository->method('buscarPorEmail')->with('novo@email.com')->willReturn(null);
        $repository->method('atualizar')->willReturn(true);

        $service = new ClienteService($repository);

        $resultado = $service->atualizar(1, [
            'nome' => 'Carlos Atualizado',
            'email' => 'novo@email.com',
            'telefone' => '62911111111',
        ]);

        $this->assertTrue($resultado);
    }

    public function testDeveLancarExcecaoAoAtualizarClienteInexistente(): void
    {
        $repository = $this->createMock(ClienteRepository::class);
        $repository->method('buscarPorId')->with(999)->willReturn(null);

        $service = new ClienteService($repository);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cliente não encontrado para atualização.');

        $service->atualizar(999, [
            'nome' => 'Teste',
        ]);
    }

    public function testDeveDeletarClienteExistente(): void
    {
        $repository = $this->createMock(ClienteRepository::class);

        $cliente = new Cliente(
            1,
            'Carlos Augusto',
            'carlos@email.com',
            '62999999999',
            '2026-04-08 17:40:05'
        );

        $repository->method('buscarPorId')->with(1)->willReturn($cliente);
        $repository->method('deletar')->with(1)->willReturn(true);

        $service = new ClienteService($repository);

        $resultado = $service->deletar(1);

        $this->assertTrue($resultado);
    }

    public function testDeveLancarExcecaoAoDeletarClienteInexistente(): void
    {
        $repository = $this->createMock(ClienteRepository::class);
        $repository->method('buscarPorId')->with(999)->willReturn(null);

        $service = new ClienteService($repository);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cliente não encontrado para exclusão.');

        $service->deletar(999);
    }
}