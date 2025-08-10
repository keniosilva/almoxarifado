<?php
require_once 'config.php';
verificaLogin();

// Consulta para itens com estoque baixo
$stmt = $pdo->query("SELECT codigo, descricao, estoque_atual, estoque_minimo 
                     FROM itens 
                     WHERE estoque_atual <= estoque_minimo");
$itens_criticos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Almoxarifado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fas fa-warehouse me-2"></i>Almoxarifado</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="itens.php"><i class="fas fa-box me-1"></i>Itens</a></li>
                    <li class="nav-item"><a class="nav-link" href="entradas.php"><i class="fas fa-sign-in-alt me-1"></i>Entradas</a></li>
                    <li class="nav-item"><a class="nav-link" href="saidas.php"><i class="fas fa-sign-out-alt me-1"></i>Saídas</a></li>
                    <li class="nav-item"><a class="nav-link" href="locais.php"><i class="fas fa-map-marker-alt me-1"></i>Locais</a></li>
                    <li class="nav-item"><a class="nav-link" href="relatorios.php"><i class="fas fa-chart-bar me-1"></i>Relatórios</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-door-open me-1"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4"><i class="fas fa-tachometer-alt me-2"></i>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome_completo']); ?>!</h2>
        
        <?php if ($itens_criticos): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Aviso: Estoque Baixo</h5>
                <p class="card-text">Os seguintes itens estão com estoque igual ou abaixo do mínimo:</p>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Estoque Atual</th>
                            <th>Estoque Mínimo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($itens_criticos as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['codigo']); ?></td>
                            <td><?php echo htmlspecialchars($item['descricao']); ?></td>
                            <td class="text-danger"><?php echo $item['estoque_atual']; ?></td>
                            <td><?php echo $item['estoque_minimo']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-box fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title">Itens</h5>
                        <p class="card-text">Gerencie os itens do estoque</p>
                        <a href="itens.php" class="btn btn-primary"><i class="fas fa-arrow-right me-2"></i>Acessar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-sign-in-alt fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title">Entradas</h5>
                        <p class="card-text">Registre entradas de itens</p>
                        <a href="entradas.php" class="btn btn-primary"><i class="fas fa-arrow-right me-2"></i>Acessar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-sign-out-alt fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title">Saídas</h5>
                        <p class="card-text">Registre saídas de itens</p>
                        <a href="saidas.php" class="btn btn-primary"><i class="fas fa-arrow-right me-2"></i>Acessar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-map-marker-alt fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title">Locais</h5>
                        <p class="card-text">Gerencie locais de destino</p>
                        <a href="locais.php" class="btn btn-primary"><i class="fas fa-arrow-right me-2"></i>Acessar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-bar fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title">Relatórios</h5>
                        <p class="card-text">Visualize relatórios de estoque</p>
                        <a href="relatorios.php" class="btn btn-primary"><i class="fas fa-arrow-right me-2"></i>Acessar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>