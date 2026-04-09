<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Controllers\ClienteController;
use App\Services\ClienteService;

final class ClienteControllerTest extends TestCase
{
    public function testDeveRetornarSucessoAoAtualizarCliente(): void
    {
        $service = $this->createMock(ClienteService::class);
        $service->method('atualizar')->with(1, [
            'nome' => 'Carlos Atualizado',
        ])->willReturn(true);

        $controller = new ClienteController($service);

        $response = $controller->update(1, [
            'nome' => 'Carlos Atualizado',
        ]);

        $this->assertTrue($response['success']);
        $this->assertSame('Cliente atualizado com sucesso.', $response['message']);
        $this->assertTrue($response['data']['updated']);
    }

    public function testDeveRetornarSucessoAoRemoverCliente(): void
    {
        $service = $this->createMock(ClienteService::class);
        $service->method('deletar')->with(1)->willReturn(true);

        $controller = new ClienteController($service);

        $response = $controller->destroy(1);

        $this->assertTrue($response['success']);
        $this->assertSame('Cliente removido com sucesso.', $response['message']);
        $this->assertTrue($response['data']['deleted']);
    }
}