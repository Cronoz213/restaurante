<?php
require_once __DIR__ . '/../conexao.php';

try {
    $fotosGaleria = $conn->query("SELECT * FROM galeria WHERE ativo = 1 ORDER BY id DESC LIMIT 8")->fetchAll();
} catch (PDOException $e) {
    $fotosGaleria = [];
}

$destaques = $conn->query("
    SELECT p.*, c.nome AS categoria_nome
    FROM pratos p
    LEFT JOIN categorias c ON p.categoria_id = c.id
    WHERE p.disponivel = 1
    ORDER BY RAND()
    LIMIT 4
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delícia do Dia</title>
  <link rel="stylesheet" href="style.css?v=3">
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
        <a href="index.php" class="active">Início</a>
        <a href="cardapio.php">Cardápio</a>
        <a href="reserva.php">Reservar</a>
        <a href="../admin/login.php" class="nav-admin"><i class="bi bi-lock"></i> Login</a>
      </nav>
    </div>
  </header>

  <div class="container">

    <section class="hero">
      <div class="hero-text">
        <h2>Delícia do Dia</h2>
        <p>Sabores autênticos, experiências inesquecíveis</p>
        <div class="btn-group">
          <a href="reserva.php" class="btn btn-primary">Reservar mesa</a>
          <a href="cardapio.php" class="btn btn-outline">Ver cardápio</a>
        </div>
      </div>
    </section>

    <section>
      <h2>Destaques do cardápio</h2>
      <div class="destaques-list">
        <?php foreach ($destaques as $p): ?>
          <div class="card-horizontal">
            <div class="card-img">
              <?php if ($p['foto']): ?>
                <img src="../uploads/imagens/<?= htmlspecialchars($p['foto']) ?>" alt="<?= htmlspecialchars($p['nome']) ?>">
              <?php else: ?>
                <div class="card-placeholder"><i class="bi bi-egg-fried" style="font-size:2rem;opacity:0.2"></i></div>
              <?php endif; ?>
            </div>
            <div class="card-body">
              <span class="card-category"><?= htmlspecialchars($p['categoria_nome'] ?? '') ?></span>
              <h3><?= htmlspecialchars($p['nome']) ?></h3>
              <p><?= htmlspecialchars($p['descricao'] ?? '') ?></p>
              <span class="price">R$ <?= number_format($p['preco'], 2, ',', '.') ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div style="text-align:center;margin-top:10px;">
        <a href="cardapio.php" class="btn btn-outline">Cardápio completo</a>
      </div>
    </section>

    <?php if (!empty($fotosGaleria)): ?>
    <section>
      <h2>Nosso Ambiente</h2>
      <div class="galeria-grid">
        <?php foreach ($fotosGaleria as $foto): ?>
          <div class="galeria-item">
            <img src="../uploads/galeria/<?= htmlspecialchars($foto['arquivo']) ?>"
                 alt="<?= htmlspecialchars($foto['titulo'] ?? 'Ambiente do restaurante') ?>">
          </div>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>

    <section>
      <h2>Funcionamento</h2>
      <div class="horarios-timeline">
        <div class="horario-slot">
          <span class="slot-dia">Seg — Sex</span>
          <div class="slot-turno"><strong>Almoço</strong>11h — 14h</div>
          <div class="slot-turno"><strong>Jantar</strong>18h — 22h</div>
        </div>
        <div class="horario-slot">
          <span class="slot-dia">Sábado</span>
          <div class="slot-turno"><strong>Almoço</strong>11h — 14h</div>
          <div class="slot-turno"><strong>Jantar</strong>18h — 22h</div>
        </div>
        <div class="horario-slot">
          <span class="slot-dia">Domingo</span>
          <div class="slot-turno">Fechado</div>
        </div>
      </div>
    </section>

  </div>

  <footer class="site-footer">
    <p>&copy; 2026 Delícia do Dia. Todos os direitos reservados.</p>
  </footer>
</body>
</html>
