<?php
require_once __DIR__ . '/../conexao.php';

$sucesso = false;
$erro    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_cliente = trim($_POST['nome']         ?? '');
    $telefone     = trim($_POST['telefone']     ?? '');
    $mesa_id      = (int)($_POST['mesa_id']     ?? 0);
    $num_pessoas  = (int)($_POST['num_pessoas'] ?? 0);
    $data_reserva = $_POST['data_reserva']      ?? '';
    $hora_reserva = $_POST['hora_reserva']      ?? '';
    $observacoes  = trim($_POST['observacoes']  ?? '');

    if (!$nome_cliente || !$telefone || !$mesa_id || !$data_reserva || !$hora_reserva) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } else {
        try {
            $stmt = $conn->prepare("
                INSERT INTO reservas (mesa_id, nome_cliente, telefone, data_reserva, hora_reserva, num_pessoas, observacoes, status)
                VALUES (:mesa_id, :nome_cliente, :telefone, :data_reserva, :hora_reserva, :num_pessoas, :observacoes, 'pendente')
            ");
            $stmt->bindValue(':mesa_id',      $mesa_id,      PDO::PARAM_INT);
            $stmt->bindValue(':nome_cliente', $nome_cliente);
            $stmt->bindValue(':telefone',     $telefone);
            $stmt->bindValue(':data_reserva', $data_reserva);
            $stmt->bindValue(':hora_reserva', $hora_reserva);
            $stmt->bindValue(':num_pessoas',  $num_pessoas,  PDO::PARAM_INT);
            $stmt->bindValue(':observacoes',  $observacoes);
            $stmt->execute();
            $sucesso = true;
        } catch (PDOException $e) {
            $erro = 'Não foi possível registrar a reserva. Tente novamente.';
        }
    }
}

$mesas = $conn->query("
    SELECT * FROM mesas
    WHERE status = 'livre' OR status = 'reservada'
    ORDER BY numero
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservar — Delícia do Dia</title>
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
        <a href="cardapio.php">Cardápio</a>
        <a href="reserva.php" class="active">Reservar</a>
        <a href="../admin/login.php" class="nav-admin"><i class="bi bi-lock"></i> Login</a>
      </nav>
    </div>
  </header>

  <div class="container">
    <section>
      <h2>Reservar uma mesa</h2>

      <?php if ($sucesso): ?>
        <div class="alert alert-success">
          <i class="bi bi-check-circle"></i>
          Reserva enviada com sucesso! Entraremos em contato para confirmar.
        </div>
      <?php endif; ?>

      <?php if ($erro): ?>
        <div class="alert alert-error">
          <i class="bi bi-x-circle"></i>
          <?= htmlspecialchars($erro) ?>
        </div>
      <?php endif; ?>

      <?php if (!$sucesso): ?>
      <div class="form-section">
        <form method="post" action="reserva.php">
          <div class="reserva-form-cols">

            <div class="form-col">
              <div class="form-group">
                <label for="nome">Nome *</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
              </div>

              <div class="form-group">
                <label for="telefone">Telefone *</label>
                <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" required>
              </div>

              <div class="form-group">
                <label for="mesa_id">Mesa *</label>
                <select id="mesa_id" name="mesa_id" required>
                  <option value="">Selecione uma mesa</option>
                  <?php foreach ($mesas as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= (($_POST['mesa_id'] ?? '') == $m['id']) ? 'selected' : '' ?>>
                      Mesa <?= $m['numero'] ?> — <?= $m['capacidade'] ?> pessoas
                      <?= $m['localizacao'] ? '(' . htmlspecialchars($m['localizacao']) . ')' : '' ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="num_pessoas">Número de pessoas *</label>
                <input type="number" id="num_pessoas" name="num_pessoas" value="<?= htmlspecialchars($_POST['num_pessoas'] ?? '') ?>" required min="1" max="20">
              </div>
            </div>

            <div class="col-divider"></div>

            <div class="form-col">
              <div class="form-group">
                <label for="data_reserva">Data *</label>
                <input type="date" id="data_reserva" name="data_reserva" value="<?= htmlspecialchars($_POST['data_reserva'] ?? '') ?>" required>
              </div>

              <div class="form-group">
                <label for="hora_reserva">Horário *</label>
                <input type="time" id="hora_reserva" name="hora_reserva" value="<?= htmlspecialchars($_POST['hora_reserva'] ?? '') ?>" required>
              </div>

              <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea id="observacoes" name="observacoes"><?= htmlspecialchars($_POST['observacoes'] ?? '') ?></textarea>
              </div>
            </div>

          </div>

          <button type="submit" class="btn btn-primary" style="width:100%;margin-top:10px;padding:12px;">
            <i class="bi bi-calendar-check"></i> Confirmar reserva
          </button>
        </form>
      </div>
      <?php endif; ?>

      <div class="info-box" style="margin-top:32px;">
        <p>
          <strong>Horário de funcionamento</strong><br>
          Seg–Sex e Sáb: 11h–14h e 18h–22h<br>
          Domingo: fechado
        </p>
        <p>
          <strong>Cancelamentos</strong><br>
          Com pelo menos 2 horas de antecedência.
        </p>
      </div>
    </section>
  </div>

  <footer class="site-footer">
    <p>&copy; 2026 Delícia do Dia. Todos os direitos reservados.</p>
  </footer>

  <script>
    document.getElementById('data_reserva').setAttribute('min', new Date().toISOString().split('T')[0]);
  </script>
</body>
</html>
