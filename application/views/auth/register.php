<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <title>Registrar - Conecta Lá</title>
  <style>
    body {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #495057;
    }
    .navbar {
      background: #ffffff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      border-bottom: 1px solid #e9ecef;
    }
    .navbar-brand {
      font-weight: 600;
      color: #2c3e50 !important;
    }
    .nav-link {
      color: #6c757d !important;
      font-weight: 500;
      transition: color 0.3s;
    }
    .nav-link:hover {
      color: #3498db !important;
    }
    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.07);
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .card-header {
      background: #ffffff;
      color: #2c3e50;
      border-bottom: 1px solid #e9ecef;
      border-radius: 12px 12px 0 0 !important;
      font-weight: 600;
      font-size: 1.3rem;
      text-align: center;
      padding: 1.5rem;
    }
    .btn-primary {
      background: #3498db;
      border: none;
      border-radius: 25px;
      padding: 12px 30px;
      font-weight: 500;
      transition: all 0.3s;
      width: 100%;
    }
    .btn-primary:hover {
      background: #2980b9;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }
    .form-control {
      border-radius: 8px;
      border: 1px solid #dee2e6;
      transition: border-color 0.3s, box-shadow 0.3s;
      padding: 0.75rem;
    }
    .form-control:focus {
      border-color: #3498db;
      box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
    .form-label {
      font-weight: 500;
      color: #495057;
      margin-bottom: 0.5rem;
    }
    .input-group-text {
      background: #f8f9fa;
      color: #6c757d;
      border: 1px solid #dee2e6;
      border-radius: 8px 0 0 8px;
    }
    .text-center a {
      color: #3498db;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }
    .text-center a:hover {
      color: #2980b9;
      text-decoration: underline;
    }
    .alert {
      border-radius: 8px;
      border: none;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
  <a class="navbar-brand" href="<?= base_url() ?>"><i class="fas fa-link"></i> Conecta Lá</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index.php/login') ?>"><i class="fas fa-sign-in-alt"></i> Entrar</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header">
            <i class="fas fa-user-plus" style="color: #3498db; margin-right: 10px;"></i>
            Criar nova conta
          </div>
          <div class="card-body p-4">
            <?php if (!empty($error)): ?>
              <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
              </div>
            <?php endif; ?>
            <form action="/index.php/auth/register" method="post">
              <div class="mb-3">
                <label class="form-label">Nome</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="name" class="form-control" placeholder="Seu nome completo" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input type="email" name="email" class="form-control" placeholder="seu@email.com" required>
                </div>
              </div>
              <div class="mb-4">
                <label class="form-label">Senha</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  <input type="password" name="password" class="form-control" placeholder="Crie uma senha segura" required>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Criar conta
              </button>
            </form>
            <div class="text-center mt-3">
              <a href="/index.php/login">Já tem conta? Faça login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
