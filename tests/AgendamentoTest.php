<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Agendamento;

final class AgendamentoTest extends TestCase {
    
    public function testDeveCriarAgendamentoComDadosValidos(): void {
        $agendamento = new Agendamento(
            null, 
            1,
            1,
            '2026-04-08 14:13:05',
            'pendente',
            'Cliente prefere horario da tarde',
            '2026-04-08 11:35:05'
        );

        $this->assertSame(1, $agendamento->getClienteId());
        $this->assertSame(1, $agendamento->getServicoId());
        $this->assertSame('2026-04-08 14:13:05', $agendamento->getDataAgendamento());
        $this->assertSame('pendente', $agendamento->getStatus());
        $this->assertSame('Cliente prefere horario da tarde', $agendamento->getObservacao());
    }

    public function testDeveLancarExcecaoQuandoStatusForInvalido(): void {
        $this->expectException(\InvalidArgumentException::class);

        new Agendamento(
            null,
            1,
            1,
            '2026-04-08 14:13:05',
            'pendentes',
            'Cliente prefere horario da tarde',
            '2026-04-08 11:35:05'
        );
    }
}