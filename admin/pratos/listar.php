<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pratos — Delícia do Dia</title>
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
        <li><a href="../categorias/listar.php"><i class="bi bi-tags"></i> Categorias</a></li>
        <li><a href="listar.php" class="active"><i class="bi bi-egg-fried"></i> Pratos</a></li>

        <span class="sidebar-section-label">Operações</span>
        <li><a href="../mesas/listar.php"><i class="bi bi-layout-three-columns"></i> Mesas</a></li>
        <li><a href="../reservas/listar.php"><i class="bi bi-calendar-check"></i> Reservas</a></li>

        <hr class="sidebar-divider">
        <li><a href="#" onclick="sair()"><i class="bi bi-box-arrow-left"></i> Sair</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <div class="header-page">
        <div>
          <h2>Pratos</h2>
          <p class="header-page-sub">Gerencie os pratos do cardápio</p>
        </div>
        <div class="header-actions">
          <a href="cadastrar.php" class="btn btn-primary"><i class="bi bi-plus"></i> Novo prato</a>
        </div>
      </div>

      <div class="section-card">
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Foto</th>
                <th>Disponível</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="7">
                  <div class="empty-state">
                    <i class="bi bi-egg-fried"></i>
                    <h3>Nenhum prato cadastrado</h3>
                    <p>Clique em "Novo prato" para começar.</p>
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
      if (localStorage.getItem('user_logged') !== 'true') window.location.href = '../login.php';
    });

    function sair() {
      if (confirm('Sair do painel?')) {
        localStorage.removeItem('user_logged');
        localStorage.removeItem('username');
        window.location.href = '../login.php';
      }
    }
  </script>
</body>
</html>
