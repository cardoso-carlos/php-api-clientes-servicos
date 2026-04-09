<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use App\Services\ClienteService;

try {
    $service = new ClienteService();

    echo "=== CADASTRANDO CLIENTE PELO SERVICE ===" . PHP_EOL;

    $id = $service->cadastrar([
        'nome' => 'Maria Oliveira',
        'email' => 'maria@email.com',
        'telefone' => '62988888888',
    ]);

    echo "Cliente cadastrado com ID: {$id}" . PHP_EOL . PHP_EOL;

    echo "=== BUSCANDO CLIENTE POR ID ===" . PHP_EOL;

    $cliente = $service->buscarPorId($id);

    if ($cliente !== null) {
        print_r($cliente->toArray());
    } else {
        echo "Cliente não encontrado." . PHP_EOL;
    }

    echo PHP_EOL . "=== LISTANDO TODOS ===" . PHP_EOL;

    $clientes = $service->listarTodos();

    foreach ($clientes as $item) {
        print_r($item->toArray());
    }
} catch (\Throwable $e) {
    echo 'Erro: ' . $e->getMessage() . PHP_EOL;
}