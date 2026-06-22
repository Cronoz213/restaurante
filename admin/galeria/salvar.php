<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: PaginaGaleria.php'); exit; }
validarCsrf();

$titulo    = trim($_POST['titulo'] ?? '') ?: null;
$permitidos = ['jpg', 'jpeg', 'png', 'webp'];
$destino   = __DIR__ . '/../../uploads/galeria/';

if (!is_dir($destino)) {
    mkdir($destino, 0755, true);
}

if (empty($_FILES['fotos']['name'][0])) {
    header('Location: cadastrar.php?erro=' . urlencode('Selecione ao menos uma foto.'));
    exit;
}

$pdo       = getConexao();
$stmt      = $pdo->prepare("INSERT INTO galeria (titulo, arquivo) VALUES (:titulo, :arquivo)");
$salvos    = 0;
$erros     = [];

foreach ($_FILES['fotos']['name'] as $i => $nome) {
    if ($_FILES['fotos']['error'][$i] !== UPLOAD_ERR_OK) continue;

    $ext = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
    if (!in_array($ext, $permitidos)) {
        $erros[] = "\"$nome\" tem formato inválido.";
        continue;
    }

    if ($_FILES['fotos']['size'][$i] > 5 * 1024 * 1024) {
        $erros[] = "\"$nome\" excede 5MB.";
        continue;
    }

    $arquivo = uniqid('galeria_') . '.' . $ext;
    if (!move_uploaded_file($_FILES['fotos']['tmp_name'][$i], $destino . $arquivo)) {
        $erros[] = "Falha ao salvar \"$nome\".";
        continue;
    }

    $stmt->execute([':titulo' => $titulo, ':arquivo' => $arquivo]);
    $salvos++;
}

if ($salvos === 0) {
    $msg = $erros ? implode(' ', $erros) : 'Nenhuma foto foi enviada.';
    header('Location: cadastrar.php?erro=' . urlencode($msg));
    exit;
}

header('Location: PaginaGaleria.php?sucesso=' . $salvos);
exit;
