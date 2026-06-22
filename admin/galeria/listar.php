<?php
$pdo = getConexao();

$pdo->exec("CREATE TABLE IF NOT EXISTS galeria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) DEFAULT NULL,
    arquivo VARCHAR(255) NOT NULL,
    ativo TINYINT(1) DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$fotos = $pdo->query("SELECT * FROM galeria ORDER BY id DESC")->fetchAll();
?>

<div class="header-page">
  <div>
    <h2>Galeria do Ambiente</h2>
    <p class="header-page-sub">Gerencie as fotos do restaurante exibidas no site</p>
  </div>
  <div class="header-actions">
    <a href="cadastrar.php" class="btn btn-primary"><i class="bi bi-plus"></i> Adicionar fotos</a>
  </div>
</div>

<?php if (isset($_GET['sucesso'])): ?>
  <div class="alert alert-success"><i class="bi bi-check-circle"></i> <?= (int)$_GET['sucesso'] ?> foto(s) adicionada(s) com sucesso!</div>
<?php endif; ?>
<?php if (isset($_GET['excluido'])): ?>
  <div class="alert alert-success"><i class="bi bi-check-circle"></i> Foto removida com sucesso.</div>
<?php endif; ?>
<?php if (isset($_GET['erro'])): ?>
  <div class="alert alert-error"><i class="bi bi-x-circle"></i> <?= e($_GET['erro']) ?></div>
<?php endif; ?>

<div class="section-card">
  <?php if (empty($fotos)): ?>
    <div class="empty-state">
      <i class="bi bi-images"></i>
      <h3>Nenhuma foto cadastrada</h3>
      <p>Clique em "Adicionar fotos" para começar a montar a galeria.</p>
    </div>
  <?php else: ?>
    <div class="gallery-grid">
      <?php foreach ($fotos as $f): ?>
        <div class="gallery-item">
          <img src="../../uploads/galeria/<?= e($f['arquivo']) ?>" alt="<?= e($f['titulo'] ?? 'Foto do ambiente') ?>">
          <div class="gallery-item-overlay">
            <a href="excluir.php?id=<?= $f['id'] ?>"
               class="btn btn-danger btn-small"
               onclick="return confirm('Remover esta foto da galeria?')">
              <i class="bi bi-trash"></i> Remover
            </a>
          </div>
          <?php if ($f['titulo']): ?>
            <div class="gallery-item-title"><?= e($f['titulo']) ?></div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
