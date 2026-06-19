<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: PaginaReserva.php'); exit; }
validarCsrf();

$nome_cliente = trim($_POST['nome_cliente'] ?? '');
$telefone     = trim($_POST['telefone'] ?? '');
$mesa_id      = (int)($_POST['mesa_id'] ?? 0);
$num_pessoas  = (int)($_POST['num_pessoas'] ?? 0);
$data_reserva = $_POST['data_reserva'] ?? '';
$hora_reserva = $_POST['hora_reserva'] ?? '';
$observacoes  = trim($_POST['observacoes'] ?? '');
$status       = $_POST['status'] ?? 'pendente';

if ($nome_cliente === '' || $mesa_id === 0 || $data_reserva === '' || $hora_reserva === '') {
    header('Location: cadastrar.php?erro=campos_obrigatorios');
    exit;
}

try {
    $pdo = getConexao();
    $stmt = $pdo->prepare("INSERT INTO reservas (mesa_id, nome_cliente, telefone, data_reserva, hora_reserva, num_pessoas, observacoes, status) VALUES (:mesa_id, :nome_cliente, :telefone, :data_reserva, :hora_reserva, :num_pessoas, :observacoes, :status)");
    $stmt->bindValue(':mesa_id', $mesa_id, PDO::PARAM_INT);
    $stmt->bindValue(':nome_cliente', $nome_cliente);
    $stmt->bindValue(':telefone', $telefone);
    $stmt->bindValue(':data_reserva', $data_reserva);
    $stmt->bindValue(':hora_reserva', $hora_reserva);
    $stmt->bindValue(':num_pessoas', $num_pessoas, PDO::PARAM_INT);
    $stmt->bindValue(':observacoes', $observacoes);
    $stmt->bindValue(':status', $status);
    $stmt->execute();
    header('Location: PaginaReserva.php?sucesso=1');
    exit;
} catch (PDOException $e) {
    header('Location: cadastrar.php?erro=' . urlencode('Erro: ' . $e->getMessage()));
    exit;
}
