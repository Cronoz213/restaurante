<?php
$pdo = getConexao();
$stmt = $pdo->query("SELECT * FROM categorias ORDER BY id DESC");
$categorias = $stmt->fetchAll();
?>

<div class="header-page">
  <div>
    <h2>Categorias</h2>
    <p class="header-page-sub">Gerencie as categorias do cardápio</p>
  </div>
  <div class="header-actions">
    <a href="cadastrar.php" class="btn btn-primary"><i class="bi bi-plus"></i> Nova categoria</a>
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
          <th>Nome</th>
          <th>Descrição</th>
          <th>Ativo</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($categorias)): ?>
          <tr>
            <td colspan="5">
              <div class="empty-state">
                <i class="bi bi-tags"></i>
                <h3>Nenhuma categoria cadastrada</h3>
                <p>Clique em "Nova categoria" para começar.</p>
              </div>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($categorias as $c): ?>
            <tr>
              <td><?= $c['id'] ?></td>
              <td><?= e($c['nome']) ?></td>
              <td><?= e($c['descricao'] ?? '—') ?></td>
              <td><?= $c['ativo'] ? '<span class="badge badge-success">Ativo</span>' : '<span class="badge badge-danger">Inativo</span>' ?></td>
              <td class="acoes">
                <a href="editar.php?id=<?= $c['id'] ?>" class="btn btn-secondary btn-small"><i class="bi bi-pencil"></i> Editar</a>
                <a href="excluir.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-small" onclick="return confirm('Excluir a categoria \'<?= e($c['nome']) ?>\'?')"><i class="bi bi-trash"></i> Excluir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
