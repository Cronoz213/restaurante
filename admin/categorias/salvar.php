<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: PaginaCategoria.php'); exit; }
validarCsrf();

$nome      = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$ativo     = isset($_POST['ativo']) ? 1 : 0;

if ($nome === '') {
    header('Location: cadastrar.php?erro=nome_obrigatorio');
    exit;
}

try {
    $pdo = getConexao();
    $stmt = $pdo->prepare("INSERT INTO categorias (nome, descricao, ativo) VALUES (:nome, :descricao, :ativo)");
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':descricao', $descricao);
    $stmt->bindValue(':ativo', $ativo, PDO::PARAM_INT);
    $stmt->execute();
    header('Location: PaginaCategoria.php?sucesso=1');
    exit;
} catch (PDOException $e) {
    header('Location: cadastrar.php?erro=' . urlencode('Erro: ' . $e->getMessage()));
    exit;
}
