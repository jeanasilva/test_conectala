<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Perfil</title>
</head>
<body>
  <div class="container mt-4">
    <h3>Perfil</h3>
    <div class="card">
      <div class="card-body">
        <p><strong>Nome:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <a class="btn btn-primary" href="<?= site_url('profile/edit') ?>">Editar</a>
        <a class="btn btn-secondary" href="<?= site_url('dashboard') ?>">Dashboard</a>
      </div>
    </div>
  </div>
</body>
</html>
