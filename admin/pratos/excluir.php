<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $pdo = getConexao();
    $stmt = $pdo->prepare("SELECT foto FROM pratos WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $prato = $stmt->fetch();
    if ($prato && $prato['foto']) {
        $arquivo = __DIR__ . '/../../uploads/imagens/' . $prato['foto'];
        if (file_exists($arquivo)) unlink($arquivo);
    }
    $stmt = $pdo->prepare("DELETE FROM pratos WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

header('Location: PaginaPrato.php?sucesso=1');
exit;
