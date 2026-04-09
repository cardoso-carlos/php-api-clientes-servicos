<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use App\Models\Cliente;
use App\Repositories\ClienteRepository;

try {
    $repository = new ClienteRepository();

    echo "=== INSERINDO CLIENTE ===" . PHP_EOL;

    $cliente = new Cliente(
        null,
        'Carlos Augusto',
        'carlos@email.com',
        '62999999999',
        date('Y-m-d H:i:s')
    );

    $id = $repository->inserir($cliente);

    echo "Cliente inserido com ID: {$id}" . PHP_EOL . PHP_EOL;

    echo "=== BUSCANDO CLIENTE POR ID ===" . PHP_EOL;

    $clienteEncontrado = $repository->buscarPorId($id);

    if ($clienteEncontrado !== null) {
        print_r($clienteEncontrado->toArray());
    } else {
        echo "Cliente não encontrado." . PHP_EOL;
    }

    echo PHP_EOL . "=== LISTANDO TODOS OS CLIENTES ===" . PHP_EOL;

    $clientes = $repository->listarTodos();

    foreach ($clientes as $item) {
        print_r($item->toArray());
    }
} catch (\Throwable $e) {
    echo 'Erro: ' . $e->getMessage() . PHP_EOL;
}