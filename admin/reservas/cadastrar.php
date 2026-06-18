<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nova Reserva — Delícia do Dia</title>
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
        <li><a href="../pratos/listar.php"><i class="bi bi-egg-fried"></i> Pratos</a></li>

        <span class="sidebar-section-label">Operações</span>
        <li><a href="../mesas/listar.php"><i class="bi bi-layout-three-columns"></i> Mesas</a></li>
        <li><a href="listar.php" class="active"><i class="bi bi-calendar-check"></i> Reservas</a></li>

        <hr class="sidebar-divider">
        <li><a href="#" onclick="sair()"><i class="bi bi-box-arrow-left"></i> Sair</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <div class="header-page">
        <h2>Nova Reserva</h2>
      </div>

      <div class="form-section">
        <form method="post" action="">
          <div class="form-row">
            <div class="form-group required">
              <label for="nome">Nome do Cliente</label>
              <input type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group required">
              <label for="telefone">Telefone</label>
              <input type="tel" id="telefone" name="telefone" required>
            </div>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
          </div>

          <div class="form-row">
            <div class="form-group required">
              <label for="mesa_id">Mesa</label>
              <select id="mesa_id" name="mesa_id" required>
                <option value="">Selecione</option>
              </select>

            </div>

            <div class="form-group required">
              <label for="num_pessoas">Pessoas</label>
              <input type="number" id="num_pessoas" name="num_pessoas" required min="1" max="20">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group required">
              <label for="data_reserva">Data</label>
              <input type="date" id="data_reserva" name="data_reserva" required>
            </div>

            <div class="form-group required">
              <label for="hora_reserva">Horário</label>
              <input type="time" id="hora_reserva" name="hora_reserva" required>
            </div>
          </div>

          <div class="form-group">
            <label for="observacoes">Observações</label>
            <textarea id="observacoes" name="observacoes"></textarea>
          </div>

          <div class="form-group required">
            <label for="status">Status</label>
            <select id="status" name="status" required>
              <option value="pendente">Pendente</option>
              <option value="confirmada">Confirmada</option>
              <option value="cancelada">Cancelada</option>
            </select>
          </div>

          <div class="form-buttons">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Salvar</button>
            <a href="listar.php" class="btn btn-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </main>
  </div>

  <script>
    window.addEventListener('load', () => {
      if (localStorage.getItem('user_logged') !== 'true') window.location.href = '../login.php';
      document.getElementById('data_reserva').setAttribute('min', new Date().toISOString().split('T')[0]);
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
