<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <title>Conecta Lá - Sistema de Teste</title>
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
    .hero-section {
      padding: 80px 0;
      text-align: center;
    }
    .hero-title {
      font-size: 3rem;
      font-weight: 300;
      color: #2c3e50;
      margin-bottom: 1rem;
    }
    .hero-subtitle {
      font-size: 1.2rem;
      color: #6c757d;
      margin-bottom: 2rem;
    }
    .feature-card {
      background: #ffffff;
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.07);
      transition: transform 0.3s, box-shadow 0.3s;
      padding: 2rem;
      margin-bottom: 2rem;
      text-align: center;
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .feature-icon {
      font-size: 3rem;
      color: #3498db;
      margin-bottom: 1rem;
    }
    .feature-title {
      font-size: 1.3rem;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 0.5rem;
    }
    .feature-text {
      color: #6c757d;
      line-height: 1.6;
    }
    .btn-primary {
      background: #3498db;
      border: none;
      border-radius: 25px;
      padding: 12px 30px;
      font-weight: 500;
      transition: all 0.3s;
    }
    .btn-primary:hover {
      background: #2980b9;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }
    .btn-outline-primary {
      border-color: #3498db;
      color: #3498db;
      border-radius: 25px;
      padding: 10px 25px;
      font-weight: 500;
      transition: all 0.3s;
    }
    .btn-outline-primary:hover {
      background: #3498db;
      border-color: #3498db;
      transform: translateY(-2px);
    }
    .footer {
      background: #ffffff;
      padding: 20px 0;
      border-top: 1px solid #e9ecef;
      color: #6c757d;
      text-align: center;
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
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index.php/register') ?>"><i class="fas fa-user-plus"></i> Registrar</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero-section">
    <div class="container">
      <h1 class="hero-title">Sistema de Teste Conecta Lá</h1>
      <p class="hero-subtitle">Uma plataforma completa para testes e desenvolvimento de aplicações web</p>
  <a href="<?= base_url('index.php/login') ?>" class="btn btn-primary me-3"><i class="fas fa-play"></i> Começar</a>
  <a href="<?= base_url('index.php/docs') ?>" class="btn btn-outline-primary"><i class="fas fa-book"></i> Documentação</a>
    </div>
  </section>

  <section class="features-section py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h3 class="feature-title">Autenticação Segura</h3>
            <p class="feature-text">Sistema de login e registro com validação completa e proteção contra ataques comuns.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-cloud-sun"></i>
            </div>
            <h3 class="feature-title">API de Clima</h3>
            <p class="feature-text">Integração com serviços meteorológicos para obter dados climáticos em tempo real.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card">
            <div class="feature-icon">
              <i class="fas fa-code"></i>
            </div>
            <h3 class="feature-title">Arquitetura Moderna</h3>
            <p class="feature-text">Desenvolvido com CodeIgniter 3, seguindo boas práticas de desenvolvimento web.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <p>&copy; 2025 Conecta Lá - Sistema de Teste. Todos os direitos reservados.</p>
    </div>
  </footer>
</body>
</html>