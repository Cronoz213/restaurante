<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categorias — Delícia do Dia</title>
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
        <li><a href="PaginaCategoria.php" class="active"><i class="bi bi-tags"></i> Categorias</a></li>
        <li><a href="../pratos/PaginaPrato.php"><i class="bi bi-egg-fried"></i> Pratos</a></li>

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
      <?php require_once 'listar.php'; ?>
    </main>
  </div>

</body>
</html>
