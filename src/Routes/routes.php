<?php

declare(strict_types=1);

use App\Controllers\ClienteController;

$clienteController = new ClienteController();

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if ($uri === '/clientes' && $method === 'GET') {
    if (isset($_GET['id'])) {
        $response = $clienteController->show((int) $_GET['id']);
    } else {
        $response = $clienteController->index();
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($uri === '/clientes' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];

    $response = $clienteController->store($input);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}


if ($uri === '/clientes' && $method === 'PUT') {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $input = json_decode(file_get_contents('php://input'), true) ?? [];

    $response = $clienteController->update($id, $input);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($uri === '/clientes' && $method === 'DELETE') {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    $response = $clienteController->destroy($id);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

http_response_code(404);
header('Content-Type: application/json');
echo json_encode([
    'success' => false,
    'message' => 'Rota não encontrada.',
    'data' => null,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);