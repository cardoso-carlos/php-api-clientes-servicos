<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use App\Config\Database;

try {
    $connection = Database::getConnection();
    echo 'Conexão realizada com sucesso!' . PHP_EOL;
} catch (\Throwable $e) {
    echo 'Erro na conexão: ' . $e->getMessage() . PHP_EOL;
}