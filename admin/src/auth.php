<?php

function verificarAcesso(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario_id'])) {
        $base = str_contains($_SERVER['SCRIPT_NAME'], '/admin/') ? '../' : '';
        header('Location: ' . $base . 'login.php');
        exit;
    }
}

function gerarTokenCsrf(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function validarCsrf(): void
{
    $tokenRecebido = $_POST['csrf_token'] ?? '';
    $tokenSessao   = $_SESSION['csrf_token'] ?? '';

    if (!hash_equals($tokenSessao, $tokenRecebido)) {
        http_response_code(403);
        exit('Requisição inválida.');
    }
}

function e(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}
