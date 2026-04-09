<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use App\Models\Cliente;
use App\Repositories\ClienteRepository;

try {
    $repository = new ClienteRepository();

    echo "=== INSERINDO CLIENTE PARA TESTE ===" . PHP_EOL;

    $cliente = new Cliente(
        null,
        'Cliente Teste',
        'cliente.teste@email.com',
        '62900000000',
        date('Y-m-d H:i:s')
    );

    $id = $repository->inserir($cliente);
    echo "Cliente inserido com ID: {$id}" . PHP_EOL . PHP_EOL;

    echo "=== ATUALIZANDO CLIENTE ===" . PHP_EOL;

    $clienteAtualizado = new Cliente(
        $id,
        'Cliente Teste Atualizado',
        'cliente.teste.atualizado@email.com',
        '62911111111',
        $cliente->getCriadoEm()
    );

    $resultadoUpdate = $repository->atualizar($clienteAtualizado);
    var_dump($resultadoUpdate);

    $clienteBuscado = $repository->buscarPorId($id);
    print_r($clienteBuscado?->toArray());

    echo PHP_EOL . "=== DELETANDO CLIENTE ===" . PHP_EOL;

    $resultadoDelete = $repository->deletar($id);
    var_dump($resultadoDelete);

    $clienteAposDelete = $repository->buscarPorId($id);
    var_dump($clienteAposDelete);
} catch (\Throwable $e) {
    echo 'Erro: ' . $e->getMessage() . PHP_EOL;
}