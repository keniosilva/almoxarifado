<?php
require_once 'config.php';
verificaLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $quantidade = (int)$_POST['quantidade'];
    $fornecedor = $_POST['fornecedor'];
    
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO entradas (item_id, quantidade, data_entrada, fornecedor, usuario) VALUES (?, ?, NOW(), ?, ?)");
    $stmt->execute([$item_id, $quantidade, $fornecedor, $_SESSION['usuario']]);
    
    $stmt = $pdo->prepare("UPDATE itens SET estoque_atual = estoque_atual + ? WHERE id = ?");
    $stmt->execute([$quantidade, $item_id]);
    $pdo->commit();
}

$stmt = $pdo->query("SELECT * FROM itens");
$itens = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entradas - Almoxarifado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php"><i class="fas fa-warehouse me-2"></i>Almoxarifado</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="itens.php"><i class="fas fa-box me-1"></i>Itens</a></li>
                    <li class="nav-item"><a class="nav-link active" href="entradas.php"><i class="fas fa-sign-in-alt me-1"></i>Entradas</a></li>
                    <li class="nav-item"><a class="nav-link" href="saidas.php"><i class="fas fa-sign-out-alt me-1"></i>Saídas</a></li>
                    <li class="nav-item"><a class="nav-link" href="relatorios.php"><i class="fas fa-chart-bar me-1"></i>Relatórios</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-door-open me-1"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4"><i class="fas fa-sign-in-alt me-2"></i>Registro de Entradas</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <select name="item_id" class="form-control" required>
                                <option value="">Selecione o Item</option>
                                <?php foreach ($itens as $item): ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['descricao']); ?> (Estoque: <?php echo $item['estoque_atual']; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="quantidade" class="form-control" placeholder="Quantidade" required min="1">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="fornecedor" class="form-control" placeholder="Fornecedor">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-plus me-2"></i>Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>