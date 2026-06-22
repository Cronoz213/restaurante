<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/auth.php';
verificarAcesso();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Adicionar Fotos — Delícia do Dia</title>
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
        <li><a href="../reservas/PaginaReserva.php"><i class="bi bi-calendar-check"></i> Reservas</a></li>

        <span class="sidebar-section-label">Visual</span>
        <li><a href="PaginaGaleria.php" class="active"><i class="bi bi-images"></i> Galeria</a></li>

        <hr class="sidebar-divider">
        <li><a href="../logout.php"><i class="bi bi-box-arrow-left"></i> Sair</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <div class="header-page">
        <h2>Adicionar Fotos</h2>
      </div>

      <?php if (isset($_GET['erro'])): ?>
        <div class="alert alert-error"><i class="bi bi-x-circle"></i> <?= e($_GET['erro']) ?></div>
      <?php endif; ?>

      <div class="form-section" style="max-width:600px">
        <form method="post" action="salvar.php" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= gerarTokenCsrf() ?>">

          <div class="form-group">
            <label for="titulo">Título / Legenda <span style="color:var(--txt3);font-weight:400;text-transform:none">(opcional)</span></label>
            <input type="text" id="titulo" name="titulo" placeholder="Ex.: Salão principal, Área externa…">
          </div>

          <div class="form-group required">
            <label for="fotos">Fotos do ambiente</label>
            <div class="file-input-wrapper">
              <input type="file" id="fotos" name="fotos[]" accept="image/*" multiple required>
              <label for="fotos" class="file-input-label">
                <i class="bi bi-images"></i> Clique para selecionar (pode escolher várias)
              </label>
            </div>
            <p style="font-size:0.75rem;color:var(--txt3);margin-top:6px">Formatos aceitos: JPG, PNG, WEBP. Tamanho máximo: 5MB por foto.</p>
          </div>

          <div id="preview-area" style="display:none;margin-bottom:18px">
            <p style="font-size:0.72rem;color:var(--txt2);margin-bottom:8px;text-transform:uppercase;letter-spacing:.8px;font-weight:600">Pré-visualização</p>
            <div id="preview-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(100px,1fr));gap:8px"></div>
          </div>

          <div class="form-buttons">
            <button type="submit" class="btn btn-primary"><i class="bi bi-upload"></i> Enviar fotos</button>
            <a href="PaginaGaleria.php" class="btn btn-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </main>
  </div>

  <script>
    document.getElementById('fotos').addEventListener('change', function () {
      const area = document.getElementById('preview-area');
      const grid = document.getElementById('preview-grid');
      grid.innerHTML = '';
      if (!this.files.length) { area.style.display = 'none'; return; }
      area.style.display = 'block';
      Array.from(this.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.style.cssText = 'width:100%;height:80px;object-fit:cover;border-radius:6px;border:1px solid #272727';
          grid.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
    });
  </script>
</body>
</html>
