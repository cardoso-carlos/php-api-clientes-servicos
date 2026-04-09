<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use App\Config\Database;

try {
    $connection = Database::getConnection();

    $sql = file_get_contents(__DIR__ . '/../database/scripts/001_create_tables_sqlite.sql');

    if ($sql === false) {
        throw new RuntimeException('Não foi possível ler o arquivo SQL.');
    }

    $connection->exec($sql);

    echo "Banco e tabelas criados com sucesso!" . PHP_EOL;
} catch (\Throwable $e) {
    echo 'Erro: ' . $e->getMessage() . PHP_EOL;
}