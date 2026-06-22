<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();

$id = (int)($_GET['id'] ?? 0);
$pdo = getConexao();
$stmt = $pdo->prepare("SELECT * FROM pratos WHERE id = ?");
$stmt->execute([$id]);
$prato = $stmt->fetch();

if (!$prato) {
    header('Location: PaginaPrato.php');
    exit;
}

$categorias = $pdo->query("SELECT id, nome FROM categorias WHERE ativo = 1 ORDER BY nome")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Prato — Delícia do Dia</title>
  <link rel="stylesheet" href="../admin-style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
  <div class="admin-wrapper">
    <aside class="sidebar">
      <div class="sidebar-brand">
        <div class="sidebar-brand-icon"><i class="bi bi-cup-hot-fill"></i></div>
        <div>
          <h1>Delícia do Dia</h1>
          <span class="sidebar-subtitle">Admin</span>
        </div>
      </div>
      <ul class="sidebar-menu">
        <li><a href="../index.php"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
        <span class="sidebar-section-label">Cardápio</span>
        <li><a href="../categorias/PaginaCategoria.php"><i class="bi bi-tags"></i> Categorias</a></li>
        <li><a href="PaginaPrato.php" class="active"><i class="bi bi-egg-fried"></i> Pratos</a></li>
        <span class="sidebar-section-label">Operações</span>
        <li><a href="../mesas/PaginaMesa.php"><i class="bi bi-layout-three-columns"></i> Mesas</a></li>
        <li><a href="../reservas/PaginaReserva.php"><i class="bi bi-calendar-check"></i> Reservas</a></li>
        <span class="sidebar-section-label">Visual</span>
        <li><a href="../galeria/PaginaGaleria.php"><i class="bi bi-images"></i> Galeria</a></li>
        <hr class="sidebar-divider">
        <li><a href="../logout.php"><i class="bi bi-box-arrow-left"></i> Sair</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <div class="header-page">
        <h2>Editar Prato</h2>
      </div>

      <div class="form-section">
        <form method="post" action="atualizar.php" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= gerarTokenCsrf() ?>">
          <input type="hidden" name="id" value="<?= $prato['id'] ?>">
          <input type="hidden" name="foto_atual" value="<?= e($prato['foto'] ?? '') ?>">

          <div class="form-group required">
            <label for="nome">Nome do Prato</label>
            <input type="text" id="nome" name="nome" value="<?= e($prato['nome']) ?>" required>
          </div>

          <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao"><?= e($prato['descricao'] ?? '') ?></textarea>
          </div>

          <div class="form-row">
            <div class="form-group required">
              <label for="categoria_id">Categoria</label>
              <select id="categoria_id" name="categoria_id" required>
                <option value="">Selecione</option>
                <?php foreach ($categorias as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $prato['categoria_id'] ? 'selected' : '' ?>>
                    <?= e($cat['nome']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group required">
              <label for="preco">Preço (R$)</label>
              <input type="number" id="preco" name="preco" value="<?= $prato['preco'] ?>" required step="0.01" min="0">
            </div>
          </div>

          <div class="form-group">
            <label for="foto">Foto <?= $prato['foto'] ? '(atual: ' . e($prato['foto']) . ')' : '' ?></label>
            <div class="file-input-wrapper">
              <input type="file" id="foto" name="foto" accept="image/*">
              <label for="foto" class="file-input-label">
                <i class="bi bi-image"></i> <?= $prato['foto'] ? 'Substituir imagem' : 'Clique para enviar uma imagem' ?>
              </label>
            </div>
          </div>

          <label class="form-toggle">
            <span class="form-toggle-label">Disponível</span>
            <input type="checkbox" name="disponivel" <?= $prato['disponivel'] ? 'checked' : '' ?>>
          </label>

          <div class="form-buttons">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Atualizar</button>
            <a href="PaginaPrato.php" class="btn btn-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </main>
  </div>

</body>
</html>
