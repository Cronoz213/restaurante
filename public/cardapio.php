<?php
require_once __DIR__ . '/../conexao.php';

$categorias = $conn->query("
    SELECT c.*, COUNT(p.id) AS total_pratos
    FROM categorias c
    LEFT JOIN pratos p ON p.categoria_id = c.id AND p.disponivel = 1
    WHERE c.ativo = 1
    GROUP BY c.id
    HAVING total_pratos > 0
    ORDER BY c.nome
")->fetchAll();

$pratos = $conn->query("
    SELECT p.*, c.nome AS categoria_nome
    FROM pratos p
    LEFT JOIN categorias c ON p.categoria_id = c.id
    WHERE p.disponivel = 1 AND c.ativo = 1
    ORDER BY c.nome, p.nome
")->fetchAll();

$pratosPorCategoria = [];
foreach ($pratos as $p) {
    $pratosPorCategoria[$p['categoria_id']][] = $p;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cardápio — Delícia do Dia</title>
  <link rel="stylesheet" href="style.css?v=2">
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

        <nav class="filtro-sidebar">
          <span class="sidebar-heading">Categorias</span>
          <a href="#" class="active" data-cat="todos" onclick="filtrar(this,'todos');return false;">Todos</a>
          <?php foreach ($categorias as $cat): ?>
            <a href="#cat-<?= $cat['id'] ?>" data-cat="cat-<?= $cat['id'] ?>" onclick="filtrar(this,'cat-<?= $cat['id'] ?>');return false;">
              <?= htmlspecialchars($cat['nome']) ?>
            </a>
          <?php endforeach; ?>
        </nav>

        <div class="cardapio-content">
          <?php if (empty($categorias)): ?>
            <p style="color:var(--txt2);margin-top:20px;">Nenhum item disponível no momento.</p>
          <?php else: ?>
            <?php foreach ($categorias as $cat): ?>
              <?php $itens = $pratosPorCategoria[$cat['id']] ?? []; ?>
              <?php if (empty($itens)) continue; ?>
              <div class="categoria-section" id="cat-<?= $cat['id'] ?>">
                <h3><?= htmlspecialchars($cat['nome']) ?></h3>
                <div class="cards-grid">
                  <?php foreach ($itens as $p): ?>
                    <div class="card">
                      <?php if ($p['foto']): ?>
                        <img src="../uploads/imagens/<?= htmlspecialchars($p['foto']) ?>" alt="<?= htmlspecialchars($p['nome']) ?>">
                      <?php else: ?>
                        <div class="card-placeholder"><i class="bi bi-egg-fried"></i></div>
                      <?php endif; ?>
                      <div class="card-body">
                        <h3><?= htmlspecialchars($p['nome']) ?></h3>
                        <?php if ($p['descricao']): ?>
                          <p><?= htmlspecialchars($p['descricao']) ?></p>
                        <?php endif; ?>
                        <span class="price">R$ <?= number_format($p['preco'], 2, ',', '.') ?></span>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

          <div style="text-align:center;margin-top:20px;">
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
    function filtrar(link, cat) {
      document.querySelectorAll('.filtro-sidebar a').forEach(a => a.classList.remove('active'));
      link.classList.add('active');
      document.querySelectorAll('.categoria-section').forEach(s => {
        s.style.display = (cat === 'todos' || s.id === cat) ? 'block' : 'none';
      });
    }
  </script>
</body>
</html>
