<?php

declare(strict_types=1);

use App\Controllers\ClienteController;
use App\Controllers\ServicoController;
use App\Controllers\AgendamentoController;
use App\Controllers\UsuarioController;

$clienteController = new ClienteController();
$servicoController = new ServicoController();
$agendamentoController = new AgendamentoController();
$usuarioController = new UsuarioController();

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Clientes
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

// SERVIÇOS
if ($uri === '/servicos' && $method === 'GET') {
    if (isset($_GET['id'])) {
        $response = $servicoController->show((int) $_GET['id']);
    } else {
        $response = $servicoController->index();
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($uri === '/servicos' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];

    $response = $servicoController->store($input);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}


if ($uri === '/servicos' && $method === 'PUT') {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $input = json_decode(file_get_contents('php://input'), true) ?? [];

    $response = $servicoController->update($id, $input);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($uri === '/servicos' && $method === 'DELETE') {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    $response = $servicoController->destroy($id);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

// AGENDAMENTO
if ($uri === '/agendamentos' && $method === 'GET') {
    if (isset($_GET['id'])) {
        $response = $agendamentoController->show((int) $_GET['id']);
    } else {
        $response = $agendamentoController->index();
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($uri === '/agendamentos' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];

    $response = $agendamentoController->store($input);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}


if ($uri === '/agendamentos' && $method === 'PUT') {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $input = json_decode(file_get_contents('php://input'), true) ?? [];

    $response = $agendamentoController->update($id, $input);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($uri === '/agendamentos' && $method === 'DELETE') {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    $response = $agendamentoController->destroy($id);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}


// Usuários
if ($uri === '/usuarios' && $method === 'GET') {
    if (isset($_GET['id'])) {
        $response = $usuarioController->show((int) $_GET['id']);
    } else {
        $response = $usuarioController->index();
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($uri === '/usuarios' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];

    $response = $usuarioController->store($input);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($uri === '/usuarios' && $method === 'PUT') {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    $input = json_decode(file_get_contents('php://input'), true) ?? [];

    $response = $usuarioController->update($id, $input);

    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

if ($uri === '/usuarios' && $method === 'DELETE') {
    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    $response = $usuarioController->destroy($id);

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