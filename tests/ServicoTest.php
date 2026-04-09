<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Servico;

final class ServicoTest extends TestCase {
    public function testDeveCriarServicoComDadosValidos(): void {
        $servico = new Servico(
            null,
            'Corte de Cabelo',
            'Servico de corte masculino',
            35.50,
            '2026-04-08 14:13:05'
        );

        $this->assertSame('Corte de Cabelo', $servico->getNome());
        $this->assertSame('Servico de corte masculino', $servico->getDescricao());
        $this->assertSame(35.50, $servico->getValor());

    }

    public function testDeveLancarExcecaoQuandoValorForInvalido(): void {
        // Você precisa avisar ao PHPUnit para esperar esta exceção
        $this->expectException(\InvalidArgumentException::class);

        new Servico (
            null,
            'Corte de Cabelo',
            'Servico de corte masculino',
            -35.50,
            '2026-04-08 14:13:05'
        );
    }
}