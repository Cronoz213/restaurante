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

    /* grade decorativa ao fundo */
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

    /* brilho central */
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

    /* topo da marca */
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

    /* card do formulário */
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

    .field {
      margin-bottom: 16px;
    }

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

    .field input:focus {
      outline: none;
      border-color: #a01e1e;
    }

    .field-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }

    .field-row label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.82rem;
      color: #555;
      cursor: pointer;
    }

    .field-row input[type="checkbox"] {
      accent-color: #a01e1e;
      width: 14px;
      height: 14px;
    }

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
      display: none;
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

    .erro.ativo { display: flex; }

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

      <div id="erro" class="erro">
        <i class="bi bi-x-circle"></i>
        Usuário ou senha incorretos.
      </div>

      <form onsubmit="logar(event)">
        <div class="field">
          <label>Usuário</label>
          <input type="text" id="usuario" placeholder="seu usuário" autocomplete="username" required>
        </div>

        <div class="field">
          <label>Senha</label>
          <input type="password" id="senha" placeholder="••••••••" autocomplete="current-password" required>
        </div>

        <div class="field-row">
          <label>
            <input type="checkbox" id="lembrar"> Manter conectado
          </label>
        </div>

        <button type="submit" class="btn-entrar">Entrar</button>
      </form>
    </div>

    <div class="rodape">
      <a href="../public/index.php"><i class="bi bi-arrow-left"></i> Voltar ao site</a>
    </div>
  </div>

  <script>
    window.addEventListener('load', () => {
      if (localStorage.getItem('user_logged') === 'true') window.location.href = 'index.php';
    });

    function logar(e) {
      e.preventDefault();
      const u = document.getElementById('usuario').value;
      const s = document.getElementById('senha').value;
      const validos = { admin: 'admin123' };

      if (validos[u] && validos[u] === s) {
        localStorage.setItem('user_logged', 'true');
        localStorage.setItem('username', u);
        window.location.href = 'index.php';
      } else {
        const el = document.getElementById('erro');
        el.classList.add('ativo');
        setTimeout(() => el.classList.remove('ativo'), 4000);
      }
    }
  </script>
</body>
</html>
