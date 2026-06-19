<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: PaginaCategoria.php'); exit; }
validarCsrf();

$id        = (int)($_POST['id'] ?? 0);
$nome      = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$ativo     = isset($_POST['ativo']) ? 1 : 0;

if ($id === 0 || $nome === '') {
    header('Location: PaginaCategoria.php?erro=1');
    exit;
}

try {
    $pdo = getConexao();
    $stmt = $pdo->prepare("UPDATE categorias SET nome = :nome, descricao = :descricao, ativo = :ativo WHERE id = :id");
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':descricao', $descricao);
    $stmt->bindValue(':ativo', $ativo, PDO::PARAM_INT);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header('Location: PaginaCategoria.php?sucesso=1');
    exit;
} catch (PDOException $e) {
    header('Location: editar.php?id=' . $id . '&erro=' . urlencode('Erro: ' . $e->getMessage()));
    exit;
}
