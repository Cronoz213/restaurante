<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/auth.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$erro  = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    validarCsrf();

    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha']      ?? '';

    if (empty($email) || empty($senha)) {
        $erro = 'Preencha e-mail e senha.';
    } else {
        $pdo  = getConexao();
        $stmt = $pdo->prepare('SELECT id, nome, senha FROM usuarios WHERE email = :email');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id']   = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header('Location: index.php');
            exit;
        }

        $erro = 'E-mail ou senha inválidos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entrar — Delícia do Dia</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #111;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 24px;
      position: relative;
      overflow: hidden;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
      background-size: 48px 48px;
      pointer-events: none;
    }

    body::after {
      content: '';
      position: fixed;
      width: 500px;
      height: 500px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(160,30,30,0.12) 0%, transparent 65%);
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      pointer-events: none;
    }

    .login-wrap {
      width: 100%;
      max-width: 400px;
      position: relative;
      z-index: 1;
    }

    .brand {
      text-align: center;
      margin-bottom: 36px;
    }

    .brand-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 52px;
      height: 52px;
      background: #a01e1e;
      border-radius: 14px;
      font-size: 1.5rem;
      color: #fff;
      margin-bottom: 14px;
    }

    .brand h1 {
      font-size: 1.5rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: -0.3px;
    }

    .brand span {
      font-size: 0.75rem;
      color: #555;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .login-card {
      background: #1a1a1a;
      border: 1px solid #2a2a2a;
      border-radius: 14px;
      padding: 32px;
    }

    .login-card h2 {
      font-size: 1.1rem;
      font-weight: 600;
      color: #e8e8e8;
      margin-bottom: 4px;
    }

    .login-card p {
      font-size: 0.82rem;
      color: #555;
      margin-bottom: 28px;
    }

    .field { margin-bottom: 16px; }

    .field label {
      display: block;
      font-size: 0.78rem;
      font-weight: 600;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      margin-bottom: 7px;
    }

    .field input {
      width: 100%;
      padding: 11px 14px;
      background: #111;
      border: 1px solid #2e2e2e;
      border-radius: 8px;
      color: #e8e8e8;
      font-size: 0.9rem;
      font-family: inherit;
      transition: border-color 0.15s;
    }

    .field input::placeholder { color: #3a3a3a; }
    .field input:focus { outline: none; border-color: #a01e1e; }

    .btn-entrar {
      width: 100%;
      padding: 12px;
      background: #a01e1e;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 0.9rem;
      font-weight: 600;
      font-family: inherit;
      cursor: pointer;
      transition: background 0.15s;
      letter-spacing: 0.2px;
    }

    .btn-entrar:hover { background: #861818; }

    .erro {
      display: flex;
      align-items: center;
      gap: 8px;
      background: #2a1010;
      border: 1px solid #5a1c1c;
      color: #f87171;
      border-radius: 8px;
      padding: 11px 14px;
      font-size: 0.82rem;
      margin-bottom: 18px;
    }

    .rodape {
      text-align: center;
      margin-top: 20px;
      font-size: 0.78rem;
      color: #3a3a3a;
    }

    .rodape a { color: #666; text-decoration: none; }
    .rodape a:hover { color: #aaa; }
  </style>
</head>
<body>
  <div class="login-wrap">
    <div class="brand">
      <div class="brand-icon"><i class="bi bi-cup-hot-fill"></i></div>
      <h1>Delícia do Dia</h1>
      <span>Painel Administrativo</span>
    </div>

    <div class="login-card">
      <h2>Bem-vindo de volta</h2>
      <p>Entre com suas credenciais para continuar</p>

      <?php if ($erro): ?>
      <div class="erro">
        <i class="bi bi-x-circle"></i>
        <?= e($erro) ?>
      </div>
      <?php endif; ?>

      <form method="POST" action="login.php">
        <input type="hidden" name="csrf_token" value="<?= gerarTokenCsrf() ?>">

        <div class="field">
          <label>E-mail</label>
          <input type="email" name="email" value="<?= e($email) ?>" placeholder="seu@email.com" autocomplete="email" required>
        </div>

        <div class="field">
          <label>Senha</label>
          <input type="password" name="senha" placeholder="••••••••" autocomplete="current-password" required>
        </div>

        <button type="submit" class="btn-entrar">Entrar</button>
      </form>
    </div>

    <div class="rodape">
      <a href="../public/index.php"><i class="bi bi-arrow-left"></i> Voltar ao site</a>
    </div>
  </div>

</body>
</html>
