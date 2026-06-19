<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: PaginaMesa.php'); exit; }
validarCsrf();

$numero      = (int)($_POST['numero'] ?? 0);
$capacidade  = (int)($_POST['capacidade'] ?? 0);
$localizacao = trim($_POST['localizacao'] ?? '');
$status      = $_POST['status'] ?? 'livre';

if ($numero <= 0 || $capacidade <= 0) {
    header('Location: cadastrar.php?erro=campos_obrigatorios');
    exit;
}

try {
    $pdo = getConexao();
    $stmt = $pdo->prepare("INSERT INTO mesas (numero, capacidade, localizacao, status) VALUES (:numero, :capacidade, :localizacao, :status)");
    $stmt->bindValue(':numero', $numero, PDO::PARAM_INT);
    $stmt->bindValue(':capacidade', $capacidade, PDO::PARAM_INT);
    $stmt->bindValue(':localizacao', $localizacao);
    $stmt->bindValue(':status', $status);
    $stmt->execute();
    header('Location: PaginaMesa.php?sucesso=1');
    exit;
} catch (PDOException $e) {
    header('Location: cadastrar.php?erro=' . urlencode('Erro: ' . $e->getMessage()));
    exit;
}
