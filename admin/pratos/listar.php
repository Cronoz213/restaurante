<?php
$pdo = getConexao();
$stmt = $pdo->query("
    SELECT p.*, c.nome AS categoria_nome
    FROM pratos p
    LEFT JOIN categorias c ON p.categoria_id = c.id
    ORDER BY p.id DESC
");
$pratos = $stmt->fetchAll();
?>

<div class="header-page">
  <div>
    <h2>Pratos</h2>
    <p class="header-page-sub">Gerencie os pratos do cardápio</p>
  </div>
  <div class="header-actions">
    <a href="cadastrar.php" class="btn btn-primary"><i class="bi bi-plus"></i> Novo prato</a>
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
          <th>Categoria</th>
          <th>Preço</th>
          <th>Foto</th>
          <th>Disponível</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($pratos)): ?>
          <tr>
            <td colspan="7">
              <div class="empty-state">
                <i class="bi bi-egg-fried"></i>
                <h3>Nenhum prato cadastrado</h3>
                <p>Clique em "Novo prato" para começar.</p>
              </div>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($pratos as $p): ?>
            <tr>
              <td><?= $p['id'] ?></td>
              <td><?= e($p['nome']) ?></td>
              <td><?= e($p['categoria_nome'] ?? '—') ?></td>
              <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
              <td>
                <?php if ($p['foto']): ?>
                  <img src="../../uploads/imagens/<?= e($p['foto']) ?>" alt="foto" style="width:48px;height:48px;object-fit:cover;border-radius:4px;">
                <?php else: ?>
                  <span style="color:#888">—</span>
                <?php endif; ?>
              </td>
              <td><?= $p['disponivel'] ? '<span class="badge badge-success">Disponível</span>' : '<span class="badge badge-danger">Indisponível</span>' ?></td>
              <td class="acoes">
                <a href="editar.php?id=<?= $p['id'] ?>" class="btn btn-secondary btn-small"><i class="bi bi-pencil"></i> Editar</a>
                <a href="excluir.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-small" onclick="return confirm('Excluir o prato \'<?= e($p['nome']) ?>\'?')"><i class="bi bi-trash"></i> Excluir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
