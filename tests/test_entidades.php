<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Cliente;
use App\Models\Servico;
use App\Models\Agendamento;
use App\Models\Usuario;

echo "=== TESTE CLIENTE ===" . PHP_EOL;

try {
    $cliente = new Cliente(
        null,
        'Carlos Augusto',
        'carlos@email.com',
        '62999999999',
        date('Y-m-d H:i:s')
    );

    print_r($cliente->toArray());
} catch (\Throwable $e) {
    echo 'Erro Cliente: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== TESTE SERVICO ===" . PHP_EOL;

try {
    $servico = new Servico(
        null,
        'Corte de cabelo',
        'Servico de corte masculino',
        35.50,
        date('Y-m-d H:i:s')
    );

    print_r($servico->toArray());
} catch (\Throwable $e) {
    echo 'Erro Servico: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== TESTE AGENDAMENTO ===" . PHP_EOL;

try {
    $agendamento = new Agendamento(
        null,
        1,
        1,
        '2026-04-08 14:00:00',
        'pendente',
        'Cliente prefere horario da tarde',
        date('Y-m-d H:i:s')
    );

    print_r($agendamento->toArray());
} catch (\Throwable $e) {
    echo 'Erro Agendamento: ' . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== TESTE USUARIO ===" . PHP_EOL;

try {
    $senhaHash = password_hash('123456', PASSWORD_DEFAULT);

    $usuario = new Usuario(
        null,
        'Administrador',
        'admin@email.com',
        $senhaHash,
        'admin',
        date('Y-m-d H:i:s')
    );

    print_r($usuario->toArray());

    echo 'Senha correta? ';
    var_dump($usuario->verificarSenha('123456'));
} catch (\Throwable $e) {
    echo 'Erro Usuario: ' . $e->getMessage() . PHP_EOL;
}