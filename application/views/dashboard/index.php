<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <title>Dashboard - Conecta Lá</title>
  <style>
    body {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
      font-size: 1.1rem;
    }
    .btn-primary {
      background: #3498db;
      border: none;
      border-radius: 25px;
      padding: 10px 20px;
      font-weight: 500;
      transition: all 0.3s;
    }
    .btn-primary:hover {
      background: #2980b9;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }
    .btn-outline-secondary {
      border-radius: 25px;
      transition: all 0.3s;
    }
    .btn-outline-secondary:hover {
      transform: translateY(-2px);
    }
    .list-group-item {
      border: none;
      border-radius: 8px;
      margin-bottom: 5px;
      transition: background 0.3s;
    }
    .list-group-item:hover {
      background: #f8f9fa;
    }
    #weatherCard .card-body {
      background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
      color: white;
    }
    #cityName {
      font-weight: 300;
      margin-bottom: 0.5rem;
    }
    #weatherSummary {
      font-size: 1.1rem;
      opacity: 0.9;
    }
    #raw {
      background: rgba(0, 0, 0, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.3);
      color: #000000;
      padding: 15px;
      border-radius: 8px;
      font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
      font-size: 0.85rem;
      line-height: 1.4;
      white-space: pre-wrap;
      word-break: break-all;
    }
    .feature-icon {
      font-size: 1.5rem;
      color: #3498db;
      margin-right: 10px;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="fas fa-tachometer-alt"></i> Conecta Lá - Dashboard</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?= site_url('profile') ?>"><i class="fas fa-user"></i> Perfil (<?= htmlspecialchars($user_name) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= site_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-search feature-icon"></i> Escolher cidade
          </div>
          <div class="card-body">
            <div class="mb-3">
              <input id="cityInput" class="form-control" placeholder="Ex: Sao Paulo">
            </div>
            <button id="fetchBtn" class="btn btn-primary w-100"><i class="fas fa-cloud-sun"></i> Buscar clima</button>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <i class="fas fa-star feature-icon"></i> Cidades favoritas
          </div>
          <div class="card-body">
            <ul id="favorites" class="list-group">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                São Paulo
                <button class="btn btn-sm btn-outline-primary" onclick="loadCity('Sao Paulo')"><i class="fas fa-eye"></i> Abrir</button>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                New York
                <button class="btn btn-sm btn-outline-primary" onclick="loadCity('New York')"><i class="fas fa-eye"></i> Abrir</button>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Tokyo
                <button class="btn btn-sm btn-outline-primary" onclick="loadCity('Tokyo')"><i class="fas fa-eye"></i> Abrir</button>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div id="weatherCard" class="card">
          <div class="card-header">
            <i class="fas fa-cloud-sun-rain feature-icon"></i> Clima
          </div>
          <div class="card-body">
            <h5 class="text-muted">Clima</h5>
            <h3 id="cityName">Nenhuma cidade selecionada</h3>
            <p id="weatherSummary" class="lead">Use o painel à esquerda para escolher uma cidade.</p>
            <button id="toggleRaw" class="btn btn-sm btn-outline-light" style="display:none"><i class="fas fa-code"></i> Mostrar JSON</button>
            <pre id="raw" style="max-height:300px;overflow:auto;background:#f8f9fa;padding:10px;border-radius:4px;display:none;margin-top:10px"></pre>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    async function fetchWeather(city){
      const cityNameEl = document.getElementById('cityName');
      const summaryEl = document.getElementById('weatherSummary');
      const rawEl = document.getElementById('raw');
      const toggleBtn = document.getElementById('toggleRaw');

      cityNameEl.textContent = 'Buscando...';
      summaryEl.textContent = '';
      rawEl.style.display = 'none';
      toggleBtn.style.display = 'none';
      try{
        // trigger fetch endpoint (store/update)
        await fetch('<?= site_url('weather/fetch/') ?>'+encodeURIComponent(city), { method: 'POST' });
        const res = await fetch('<?= site_url('weather/') ?>'+encodeURIComponent(city));
        const json = await res.json();
        if(json.error){
          cityNameEl.textContent = city;
          summaryEl.textContent = 'Erro: '+json.error;
          return;
        }
        const data = json.data || {};

        // Friendly display: City, temperature and description
        cityNameEl.textContent = data.city || city;
        const temp = (data.temperature !== null && data.temperature !== undefined) ? Number(data.temperature).toFixed(2) + '°C' : '';
        const desc = data.description || '';
        summaryEl.innerHTML = (temp ? ('<strong>' + temp + '</strong>') : '') + (temp && desc ? ' - ' : '') + (desc ? desc : '');

        // Raw JSON toggle (prefer provider raw if available)
        const rawProvider = (data.raw && data.raw.raw) ? data.raw.raw : (data.raw || {});
        rawEl.textContent = JSON.stringify(rawProvider, null, 2);
        toggleBtn.style.display = 'inline-block';
        toggleBtn.textContent = 'Mostrar JSON';
        toggleBtn.onclick = function(){
          if(rawEl.style.display === 'none'){
            rawEl.style.display = 'block';
            toggleBtn.textContent = 'Ocultar JSON';
          } else {
            rawEl.style.display = 'none';
            toggleBtn.textContent = 'Mostrar JSON';
          }
        };
      }catch(e){
        cityNameEl.textContent = city;
        summaryEl.textContent = 'Erro na requisição';
      }
    }

    function loadCity(c){ fetchWeather(c); }

    document.getElementById('fetchBtn').addEventListener('click', ()=>{
      const city = document.getElementById('cityInput').value.trim();
      if(city) fetchWeather(city);
    });
  </script>
</body>
</html>
