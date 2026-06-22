<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/auth.php';
verificarAcesso();

$pdo = getConexao();
$totalPratos     = $pdo->query("SELECT COUNT(*) FROM pratos")->fetchColumn();
$totalMesas      = $pdo->query("SELECT COUNT(*) FROM mesas")->fetchColumn();
$totalCategorias = $pdo->query("SELECT COUNT(*) FROM categorias")->fetchColumn();
$totalReservasHoje = $pdo->query("SELECT COUNT(*) FROM reservas WHERE data_reserva = CURDATE()")->fetchColumn();

$reservasRecentes = $pdo->query("
    SELECT r.*, m.numero AS mesa_numero
    FROM reservas r
    LEFT JOIN mesas m ON r.mesa_id = m.id
    ORDER BY r.data_reserva DESC, r.hora_reserva DESC
    LIMIT 5
")->fetchAll();

$badgesReserva = ['pendente' => 'badge-warning', 'confirmada' => 'badge-success', 'cancelada' => 'badge-danger'];
$labelsReserva = ['pendente' => 'Pendente', 'confirmada' => 'Confirmada', 'cancelada' => 'Cancelada'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Delícia do Dia</title>
  <link rel="stylesheet" href="admin-style.css">
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
        <li><a href="index.php" class="active"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>

        <span class="sidebar-section-label">Cardápio</span>
        <li><a href="categorias/PaginaCategoria.php"><i class="bi bi-tags"></i> Categorias</a></li>
        <li><a href="pratos/PaginaPrato.php"><i class="bi bi-egg-fried"></i> Pratos</a></li>

        <span class="sidebar-section-label">Operações</span>
        <li><a href="mesas/PaginaMesa.php"><i class="bi bi-layout-three-columns"></i> Mesas</a></li>
        <li><a href="reservas/PaginaReserva.php"><i class="bi bi-calendar-check"></i> Reservas</a></li>

        <span class="sidebar-section-label">Visual</span>
        <li><a href="galeria/PaginaGaleria.php"><i class="bi bi-images"></i> Galeria</a></li>

        <hr class="sidebar-divider">
        <li><a href="logout.php"><i class="bi bi-box-arrow-left"></i> Sair</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <div class="header-page">
        <div>
          <h2>Dashboard</h2>
        </div>
        <div class="header-actions">
          <div class="user-chip">
            <div class="user-chip-avatar"><?= strtoupper(substr($_SESSION['usuario_nome'] ?? 'A', 0, 1)) ?></div>
            <span><?= e($_SESSION['usuario_nome'] ?? 'Admin') ?></span>
          </div>
        </div>
      </div>

      <div class="cards-stats">
        <div class="card-stat">
          <div class="card-stat-title">Pratos <i class="bi bi-egg-fried"></i></div>
          <div class="card-stat-number"><?= $totalPratos ?></div>
          <a href="pratos/PaginaPrato.php" class="card-stat-link">Ver pratos <i class="bi bi-arrow-right"></i></a>
          <div class="card-stat-bar"></div>
        </div>

        <div class="card-stat">
          <div class="card-stat-title">Mesas <i class="bi bi-layout-three-columns"></i></div>
          <div class="card-stat-number"><?= $totalMesas ?></div>
          <a href="mesas/PaginaMesa.php" class="card-stat-link">Gerenciar <i class="bi bi-arrow-right"></i></a>
          <div class="card-stat-bar"></div>
        </div>

        <div class="card-stat">
          <div class="card-stat-title">Categorias <i class="bi bi-tags"></i></div>
          <div class="card-stat-number"><?= $totalCategorias ?></div>
          <a href="categorias/PaginaCategoria.php" class="card-stat-link">Ver categorias <i class="bi bi-arrow-right"></i></a>
          <div class="card-stat-bar"></div>
        </div>

        <div class="card-stat">
          <div class="card-stat-title">Reservas hoje <i class="bi bi-calendar-check"></i></div>
          <div class="card-stat-number"><?= $totalReservasHoje ?></div>
          <a href="reservas/PaginaReserva.php" class="card-stat-link">Ver reservas <i class="bi bi-arrow-right"></i></a>
          <div class="card-stat-bar"></div>
        </div>
      </div>

      <div class="section-card">
        <div class="section-card-header">
          <h3>Reservas recentes</h3>
          <a href="reservas/PaginaReserva.php" class="btn btn-secondary btn-small">Ver todas</a>
        </div>
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Pessoas</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($reservasRecentes)): ?>
                <tr>
                  <td colspan="7">
                    <div class="empty-state">
                      <i class="bi bi-calendar-x"></i>
                      <h3>Nenhuma reserva ainda</h3>
                      <p>As reservas aparecerão aqui.</p>
                    </div>
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($reservasRecentes as $r): ?>
                  <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= e($r['nome_cliente']) ?></td>
                    <td><?= date('d/m/Y', strtotime($r['data_reserva'])) ?></td>
                    <td><?= substr($r['hora_reserva'], 0, 5) ?></td>
                    <td><?= $r['num_pessoas'] ?></td>
                    <td><span class="badge <?= $badgesReserva[$r['status']] ?? 'badge-warning' ?>"><?= $labelsReserva[$r['status']] ?? e($r['status']) ?></span></td>
                    <td class="acoes">
                      <a href="reservas/editar.php?id=<?= $r['id'] ?>" class="btn btn-secondary btn-small"><i class="bi bi-pencil"></i> Editar</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

</body>
</html>
