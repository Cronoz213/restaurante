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

        <li><a href="categorias/listar.php"><i class="bi bi-tags"></i> Categorias</a></li>
        <li><a href="pratos/listar.php"><i class="bi bi-egg-fried"></i> Pratos</a></li>

        <span class="sidebar-section-label">Operações</span>

        <li><a href="mesas/listar.php"><i class="bi bi-layout-three-columns"></i> Mesas</a></li>
        <li><a href="reservas/listar.php"><i class="bi bi-calendar-check"></i> Reservas</a></li>

        <hr class="sidebar-divider">

        <li><a href="#" onclick="sair()"><i class="bi bi-box-arrow-left"></i> Sair</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <div class="header-page">
        <div>
          <h2>Dashboard</h2>
        </div>
        <div class="header-actions">
          <div class="user-chip">
            <div class="user-chip-avatar" id="inicial">A</div>
            <span id="username-display">Admin</span>
          </div>
        </div>
      </div>

      <div class="cards-stats">
        <div class="card-stat">
          <div class="card-stat-title">Pratos <i class="bi bi-egg-fried"></i></div>
          <div class="card-stat-number">0</div>
          <a href="pratos/listar.php" class="card-stat-link">Ver pratos <i class="bi bi-arrow-right"></i></a>
          <div class="card-stat-bar"></div>
        </div>

        <div class="card-stat">
          <div class="card-stat-title">Mesas <i class="bi bi-layout-three-columns"></i></div>
          <div class="card-stat-number">0</div>
          <a href="mesas/listar.php" class="card-stat-link">Gerenciar <i class="bi bi-arrow-right"></i></a>
          <div class="card-stat-bar"></div>
        </div>

        <div class="card-stat">
          <div class="card-stat-title">Categorias <i class="bi bi-tags"></i></div>
          <div class="card-stat-number">0</div>
          <a href="categorias/listar.php" class="card-stat-link">Ver categorias <i class="bi bi-arrow-right"></i></a>
          <div class="card-stat-bar"></div>
        </div>

        <div class="card-stat">
          <div class="card-stat-title">Reservas hoje <i class="bi bi-calendar-check"></i></div>
          <div class="card-stat-number">0</div>
          <a href="reservas/listar.php" class="card-stat-link">Ver reservas <i class="bi bi-arrow-right"></i></a>
          <div class="card-stat-bar"></div>
        </div>
      </div>

      <div class="section-card">
        <div class="section-card-header">
          <h3>Reservas recentes</h3>
          <a href="reservas/listar.php" class="btn btn-secondary btn-small">Ver todas</a>
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
              <tr>
                <td colspan="7">
                  <div class="empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <h3>Nenhuma reserva ainda</h3>
                    <p>As reservas aparecerão aqui.</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <script>
    window.addEventListener('load', () => {
      if (localStorage.getItem('user_logged') !== 'true') return window.location.href = 'login.php';
      const u = localStorage.getItem('username') || 'admin';
      const nome = u.charAt(0).toUpperCase() + u.slice(1);
      document.getElementById('username-display').textContent = nome;
      document.getElementById('inicial').textContent = nome.charAt(0);
    });

    function sair() {
      if (confirm('Sair do painel?')) {
        localStorage.removeItem('user_logged');
        localStorage.removeItem('username');
        window.location.href = 'login.php';
      }
    }
  </script>
</body>
</html>
