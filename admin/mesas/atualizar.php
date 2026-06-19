<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: PaginaMesa.php'); exit; }
validarCsrf();

$id          = (int)($_POST['id'] ?? 0);
$numero      = (int)($_POST['numero'] ?? 0);
$capacidade  = (int)($_POST['capacidade'] ?? 0);
$localizacao = trim($_POST['localizacao'] ?? '');
$status      = $_POST['status'] ?? 'livre';

if ($id === 0 || $numero <= 0 || $capacidade <= 0) {
    header('Location: PaginaMesa.php?erro=1');
    exit;
}

try {
    $pdo = getConexao();
    $stmt = $pdo->prepare("UPDATE mesas SET numero = :numero, capacidade = :capacidade, localizacao = :localizacao, status = :status WHERE id = :id");
    $stmt->bindValue(':numero', $numero, PDO::PARAM_INT);
    $stmt->bindValue(':capacidade', $capacidade, PDO::PARAM_INT);
    $stmt->bindValue(':localizacao', $localizacao);
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header('Location: PaginaMesa.php?sucesso=1');
    exit;
} catch (PDOException $e) {
    header('Location: editar.php?id=' . $id . '&erro=' . urlencode('Erro: ' . $e->getMessage()));
    exit;
}
