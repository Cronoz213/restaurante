<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: PaginaGaleria.php'); exit; }

$pdo  = getConexao();
$foto = $pdo->prepare("SELECT arquivo FROM galeria WHERE id = :id");
$foto->execute([':id' => $id]);
$row  = $foto->fetch();

if (!$row) { header('Location: PaginaGaleria.php'); exit; }

$arquivo = __DIR__ . '/../../uploads/galeria/' . $row['arquivo'];
if (is_file($arquivo)) {
    unlink($arquivo);
}

$pdo->prepare("DELETE FROM galeria WHERE id = :id")->execute([':id' => $id]);

header('Location: PaginaGaleria.php?excluido=1');
exit;
