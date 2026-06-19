<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();

$id = (int)($_GET['id'] ?? 0);
$pdo = getConexao();
$stmt = $pdo->prepare("SELECT * FROM reservas WHERE id = ?");
$stmt->execute([$id]);
$reserva = $stmt->fetch();

if (!$reserva) {
    header('Location: PaginaReserva.php');
    exit;
}

$mesas = $pdo->query("SELECT id, numero, capacidade FROM mesas ORDER BY numero")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Reserva — Delícia do Dia</title>
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
        <li><a href="../mesas/PaginaMesa.php"><i class="bi bi-layout-three-columns"></i> Mesas</a></li>
        <li><a href="PaginaReserva.php" class="active"><i class="bi bi-calendar-check"></i> Reservas</a></li>
        <hr class="sidebar-divider">
        <li><a href="../logout.php"><i class="bi bi-box-arrow-left"></i> Sair</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <div class="header-page">
        <h2>Editar Reserva</h2>
      </div>

      <div class="form-section">
        <form method="post" action="atualizar.php">
          <input type="hidden" name="csrf_token" value="<?= gerarTokenCsrf() ?>">
          <input type="hidden" name="id" value="<?= $reserva['id'] ?>">

          <div class="form-row">
            <div class="form-group required">
              <label for="nome_cliente">Nome do Cliente</label>
              <input type="text" id="nome_cliente" name="nome_cliente" value="<?= e($reserva['nome_cliente']) ?>" required>
            </div>
            <div class="form-group required">
              <label for="telefone">Telefone</label>
              <input type="tel" id="telefone" name="telefone" value="<?= e($reserva['telefone']) ?>" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group required">
              <label for="mesa_id">Mesa</label>
              <select id="mesa_id" name="mesa_id" required>
                <option value="">Selecione</option>
                <?php foreach ($mesas as $m): ?>
                  <option value="<?= $m['id'] ?>" <?= $m['id'] == $reserva['mesa_id'] ? 'selected' : '' ?>>
                    Mesa <?= $m['numero'] ?> (<?= $m['capacidade'] ?> pessoas)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group required">
              <label for="num_pessoas">Pessoas</label>
              <input type="number" id="num_pessoas" name="num_pessoas" value="<?= $reserva['num_pessoas'] ?>" required min="1" max="20">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group required">
              <label for="data_reserva">Data</label>
              <input type="date" id="data_reserva" name="data_reserva" value="<?= $reserva['data_reserva'] ?>" required>
            </div>
            <div class="form-group required">
              <label for="hora_reserva">Horário</label>
              <input type="time" id="hora_reserva" name="hora_reserva" value="<?= substr($reserva['hora_reserva'], 0, 5) ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label for="observacoes">Observações</label>
            <textarea id="observacoes" name="observacoes"><?= e($reserva['observacoes'] ?? '') ?></textarea>
          </div>

          <div class="form-group required">
            <label for="status">Status</label>
            <select id="status" name="status" required>
              <option value="pendente" <?= $reserva['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
              <option value="confirmada" <?= $reserva['status'] === 'confirmada' ? 'selected' : '' ?>>Confirmada</option>
              <option value="cancelada" <?= $reserva['status'] === 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
            </select>
          </div>

          <div class="form-buttons">
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Atualizar</button>
            <a href="PaginaReserva.php" class="btn btn-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </main>
  </div>

</body>
</html>
