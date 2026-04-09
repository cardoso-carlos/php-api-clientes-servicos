<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Cliente;

final class ClienteTest extends TestCase
{
    public function testDeveCriarClienteComDadosValidos(): void
    {
        $cliente = new Cliente(
            null,
            'Carlos Augusto',
            'carlos@email.com',
            '62999999999',
            '2026-04-08 14:13:05'
        );

        $this->assertSame('Carlos Augusto', $cliente->getNome());
        $this->assertSame('carlos@email.com', $cliente->getEmail());
        $this->assertSame('62999999999', $cliente->getTelefone());
    }

    public function testDeveLancarExcecaoQuandoEmailForInvalido(): void {
        $this->expectException(\InvalidArgumentException::class);

        new Cliente(
            null,
            'Carlos Augusto',
            'email-invalido',
            '62999999999',
            '2026-04-08 14:13:05'
        );
    }
}