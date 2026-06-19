<?php
$pdo = getConexao();
$stmt = $pdo->query("
    SELECT r.*, m.numero AS mesa_numero
    FROM reservas r
    LEFT JOIN mesas m ON r.mesa_id = m.id
    ORDER BY r.data_reserva DESC, r.hora_reserva DESC
");
$reservas = $stmt->fetchAll();
$labels = ['pendente' => 'Pendente', 'confirmada' => 'Confirmada', 'cancelada' => 'Cancelada'];
$badges = ['pendente' => 'badge-warning', 'confirmada' => 'badge-success', 'cancelada' => 'badge-danger'];
?>

<div class="header-page">
  <div>
    <h2>Reservas</h2>
    <p class="header-page-sub">Gerencie as reservas do restaurante</p>
  </div>
  <div class="header-actions">
    <a href="cadastrar.php" class="btn btn-primary"><i class="bi bi-plus"></i> Nova reserva</a>
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
          <th>Cliente</th>
          <th>Telefone</th>
          <th>Mesa</th>
          <th>Data</th>
          <th>Hora</th>
          <th>Pessoas</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($reservas)): ?>
          <tr>
            <td colspan="9">
              <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
                <h3>Nenhuma reserva cadastrada</h3>
                <p>Clique em "Nova reserva" para começar.</p>
              </div>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($reservas as $r): ?>
            <tr>
              <td><?= $r['id'] ?></td>
              <td><?= e($r['nome_cliente']) ?></td>
              <td><?= e($r['telefone']) ?></td>
              <td>Mesa <?= $r['mesa_numero'] ?? '—' ?></td>
              <td><?= date('d/m/Y', strtotime($r['data_reserva'])) ?></td>
              <td><?= substr($r['hora_reserva'], 0, 5) ?></td>
              <td><?= $r['num_pessoas'] ?></td>
              <td><span class="badge <?= $badges[$r['status']] ?? 'badge-warning' ?>"><?= $labels[$r['status']] ?? $r['status'] ?></span></td>
              <td class="acoes">
                <a href="editar.php?id=<?= $r['id'] ?>" class="btn btn-secondary btn-small"><i class="bi bi-pencil"></i> Editar</a>
                <a href="excluir.php?id=<?= $r['id'] ?>" class="btn btn-danger btn-small" onclick="return confirm('Excluir a reserva de <?= e($r['nome_cliente']) ?>?')"><i class="bi bi-trash"></i> Excluir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
