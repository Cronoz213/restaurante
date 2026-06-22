<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();

$id = (int)($_GET['id'] ?? 0);
$pdo = getConexao();
$stmt = $pdo->prepare("SELECT * FROM mesas WHERE id = ?");
$stmt->execute([$id]);
$mesa = $stmt->fetch();

if (!$mesa) {
    header('Location: PaginaMesa.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Mesa — Delícia do Dia</title>
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
        <li><a href="../pratos/PaginaPrato.php"><i class="bi bi-egg-fried"></i> Pratos</a></li>
        <span class="sidebar-section-label">Operações</span>
        <li><a href="PaginaMesa.php" class="active"><i class="bi bi-layout-three-columns"></i> Mesas</a></li>
        <li><a href="../reservas/PaginaReserva.php"><i class="bi bi-calendar-check"></i> Reservas</a></li>
        <span class="sidebar-section-label">Visual</span>
        <li><a href="../galeria/PaginaGaleria.php"><i class="bi bi-images"></i> Galeria</a></li>
        <hr class="sidebar-divider">
        <li><a href="../logout.php"><i class="bi bi-box-arrow-left"></i> Sair</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <div class="header-page">
        <h2>Editar Mesa</h2>
      </div>

      <div class="form-section">
        <form method="post" action="atualizar.php">
          <input type="hidden" name="csrf_token" value="<?= gerarTokenCsrf() ?>">
          <input type="hidden" name="id" value="<?= $mesa['id'] ?>">

          <div class="form-row">
            <div class="form-group required">
              <label for="numero">Número</label>
              <input type="number" id="numero" name="numero" value="<?= $mesa['numero'] ?>" required>
            </div>
            <div class="form-group required">
              <label for="capacidade">Capacidade</label>
              <input type="number" id="capacidade" name="capacidade" value="<?= $mesa['capacidade'] ?>" required min="1" max="20">
            </div>
          </div>

          <div class="form-group">
            <label for="localizacao">Localização</label>
            <input type="text" id="localizacao" name="localizacao" value="<?= e($mesa['localizacao'] ?? '') ?>">
          </div>

          <div class="form-group required">
            <label for="status">Status</label>
            <select id="status" name="status" required>
              <option value="livre" <?= $mesa['status'] === 'livre' ? 'selected' : '' ?>>Livre</option>
              <option value="ocupada" <?= $mesa['status'] === 'ocupada' ? 'selected' : '' ?>>Ocupada</option>
              <option value="reservada" <?= $mesa['status'] === 'reservada' ? 'selected' : '' ?>>Reservada</option>
            </select>
          </div>

          <div class="form-buttons">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Atualizar</button>
            <a href="PaginaMesa.php" class="btn btn-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </main>
  </div>

</body>
</html>
