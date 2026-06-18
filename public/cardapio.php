<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cardápio — Delícia do Dia</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
  <header>
    <div class="header-inner">
      <div class="logo-section">
        <h1><i class="bi bi-cup-hot-fill"></i> Delícia do Dia</h1>
        <span>Restaurante</span>
      </div>
      <nav>
        <a href="index.php">Início</a>
        <a href="cardapio.php" class="active">Cardápio</a>
        <a href="reserva.php">Reservar</a>
        <a href="../admin/login.php" class="nav-admin"><i class="bi bi-lock"></i> Login</a>
      </nav>
    </div>
  </header>

  <div class="container">
    <section>
      <h2>Cardápio</h2>
      <div class="cardapio-layout">
        <nav class="filtro-sidebar filtro-categorias">
          <span class="sidebar-heading">Categorias</span>
          <a href="#" class="active" onclick="mostrarCategoria('todos'); return false;">Todos</a>
        </nav>

        <div class="cardapio-content">
          <div style="text-align:center;margin-top:40px;">
            <a href="reserva.php" class="btn btn-primary">Reservar uma mesa</a>
          </div>
        </div>
      </div>
    </section>
  </div>

  <footer class="site-footer">
    <p>&copy; 2026 Delícia do Dia. Todos os direitos reservados.</p>
  </footer>

  <script>
    function mostrarCategoria(cat) {
      document.querySelectorAll('.categoria-section').forEach(el => {
        el.style.display = cat === 'todos' || el.id === cat ? 'block' : 'none';
      });
      document.querySelectorAll('.filtro-categorias a').forEach(a => a.classList.remove('active'));
      event.target.classList.add('active');
    }
  </script>
</body>
</html>
