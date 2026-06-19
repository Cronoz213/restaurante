<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: PaginaPrato.php'); exit; }
validarCsrf();

$nome         = trim($_POST['nome'] ?? '');
$descricao    = trim($_POST['descricao'] ?? '');
$categoria_id = (int)($_POST['categoria_id'] ?? 0);
$preco        = (float)($_POST['preco'] ?? 0);
$disponivel   = isset($_POST['disponivel']) ? 1 : 0;
$foto         = null;

if ($nome === '' || $categoria_id === 0 || $preco <= 0) {
    header('Location: cadastrar.php?erro=campos_obrigatorios');
    exit;
}

if (!empty($_FILES['foto']['name'])) {
    $ext        = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'webp'];
    if (in_array($ext, $permitidos)) {
        $foto = uniqid('prato_') . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], __DIR__ . '/../../uploads/imagens/' . $foto);
    }
}

try {
    $pdo = getConexao();
    $stmt = $pdo->prepare("INSERT INTO pratos (nome, descricao, categoria_id, preco, foto, disponivel) VALUES (:nome, :descricao, :categoria_id, :preco, :foto, :disponivel)");
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':descricao', $descricao);
    $stmt->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
    $stmt->bindValue(':preco', $preco);
    $stmt->bindValue(':foto', $foto);
    $stmt->bindValue(':disponivel', $disponivel, PDO::PARAM_INT);
    $stmt->execute();
    header('Location: PaginaPrato.php?sucesso=1');
    exit;
} catch (PDOException $e) {
    header('Location: cadastrar.php?erro=' . urlencode('Erro: ' . $e->getMessage()));
    exit;
}
