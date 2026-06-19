<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: PaginaReserva.php'); exit; }
validarCsrf();

$id           = (int)($_POST['id'] ?? 0);
$nome_cliente = trim($_POST['nome_cliente'] ?? '');
$telefone     = trim($_POST['telefone'] ?? '');
$mesa_id      = (int)($_POST['mesa_id'] ?? 0);
$num_pessoas  = (int)($_POST['num_pessoas'] ?? 0);
$data_reserva = $_POST['data_reserva'] ?? '';
$hora_reserva = $_POST['hora_reserva'] ?? '';
$observacoes  = trim($_POST['observacoes'] ?? '');
$status       = $_POST['status'] ?? 'pendente';

if ($id === 0 || $nome_cliente === '' || $mesa_id === 0) {
    header('Location: PaginaReserva.php?erro=1');
    exit;
}

try {
    $pdo = getConexao();
    $stmt = $pdo->prepare("UPDATE reservas SET mesa_id = :mesa_id, nome_cliente = :nome_cliente, telefone = :telefone, data_reserva = :data_reserva, hora_reserva = :hora_reserva, num_pessoas = :num_pessoas, observacoes = :observacoes, status = :status WHERE id = :id");
    $stmt->bindValue(':mesa_id', $mesa_id, PDO::PARAM_INT);
    $stmt->bindValue(':nome_cliente', $nome_cliente);
    $stmt->bindValue(':telefone', $telefone);
    $stmt->bindValue(':data_reserva', $data_reserva);
    $stmt->bindValue(':hora_reserva', $hora_reserva);
    $stmt->bindValue(':num_pessoas', $num_pessoas, PDO::PARAM_INT);
    $stmt->bindValue(':observacoes', $observacoes);
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header('Location: PaginaReserva.php?sucesso=1');
    exit;
} catch (PDOException $e) {
    header('Location: editar.php?id=' . $id . '&erro=' . urlencode('Erro: ' . $e->getMessage()));
    exit;
}
