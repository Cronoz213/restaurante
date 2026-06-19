<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $pdo = getConexao();
    $stmt = $pdo->prepare("DELETE FROM mesas WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

header('Location: PaginaMesa.php?sucesso=1');
exit;
