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

      <div class="form-section">
        <form method="post" action="">
          <div class="reserva-form-cols">

            <div class="form-col">
              <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required>
              </div>

              <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="tel" id="telefone" name="telefone" required>
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
              </div>

              <div class="form-group">
                <label for="mesa_id">Mesa</label>
                <select id="mesa_id" name="mesa_id" required>
                  <option value="">Selecione</option>
                </select>
              </div>
            </div>

            <div class="col-divider"></div>

            <div class="form-col">
              <div class="form-group">
                <label for="data_reserva">Data</label>
                <input type="date" id="data_reserva" name="data_reserva" required>
              </div>

              <div class="form-group">
                <label for="hora_reserva">Horário</label>
                <input type="time" id="hora_reserva" name="hora_reserva" required>
              </div>

              <div class="form-group">
                <label for="num_pessoas">Pessoas</label>
                <input type="number" id="num_pessoas" name="num_pessoas" required min="1" max="20">
              </div>

              <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea id="observacoes" name="observacoes"></textarea>
              </div>
            </div>

          </div>

          <button type="submit" class="btn btn-primary" style="width:100%;margin-top:10px;padding:12px;">
            Confirmar reserva
          </button>
        </form>
      </div>

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
