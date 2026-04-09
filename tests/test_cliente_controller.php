<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use App\Controllers\ClienteController;

$controller = new ClienteController();

echo "=== TESTE STORE ===" . PHP_EOL;
$respostaStore = $controller->store([
    'nome' => 'João Pereira',
    'email' => 'joao@email.com',
    'telefone' => '62977777777',
]);

print_r($respostaStore);

echo PHP_EOL . "=== TESTE SHOW ===" . PHP_EOL;
$respostaShow = $controller->show(1);
print_r($respostaShow);

echo PHP_EOL . "=== TESTE INDEX ===" . PHP_EOL;
$respostaIndex = $controller->index();
print_r($respostaIndex);