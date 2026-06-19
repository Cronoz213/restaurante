<?php
$pdo = getConexao();
$stmt = $pdo->query("SELECT * FROM mesas ORDER BY numero ASC");
$mesas = $stmt->fetchAll();
$labels = ['livre' => 'Livre', 'ocupada' => 'Ocupada', 'reservada' => 'Reservada'];
$badges = ['livre' => 'badge-success', 'ocupada' => 'badge-danger', 'reservada' => 'badge-warning'];
?>

<div class="header-page">
  <div>
    <h2>Mesas</h2>
    <p class="header-page-sub">Gerencie as mesas do restaurante</p>
  </div>
  <div class="header-actions">
    <a href="cadastrar.php" class="btn btn-primary"><i class="bi bi-plus"></i> Nova mesa</a>
  </div>
</div>

<?php if (isset($_GET['sucesso'])): ?>
  <div class="alert alert-success">Operação realizada com sucesso!</div>
<?php endif; ?>
<?php if (isset($_GET['erro'])): ?>
  <div class="alert alert-error">Erro ao realizar operação.</div>
<?php endif; ?>

<div class="section-card">
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Número</th>
          <th>Capacidade</th>
          <th>Localização</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($mesas)): ?>
          <tr>
            <td colspan="6">
              <div class="empty-state">
                <i class="bi bi-layout-three-columns"></i>
                <h3>Nenhuma mesa cadastrada</h3>
                <p>Clique em "Nova mesa" para começar.</p>
              </div>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($mesas as $m): ?>
            <tr>
              <td><?= $m['id'] ?></td>
              <td><?= $m['numero'] ?></td>
              <td><?= $m['capacidade'] ?> pessoas</td>
              <td><?= e($m['localizacao'] ?? '—') ?></td>
              <td><span class="badge <?= $badges[$m['status']] ?? 'badge-success' ?>"><?= $labels[$m['status']] ?? $m['status'] ?></span></td>
              <td class="acoes">
                <a href="editar.php?id=<?= $m['id'] ?>" class="btn btn-secondary btn-small"><i class="bi bi-pencil"></i> Editar</a>
                <a href="excluir.php?id=<?= $m['id'] ?>" class="btn btn-danger btn-small" onclick="return confirm('Excluir a mesa <?= $m['numero'] ?>?')"><i class="bi bi-trash"></i> Excluir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
