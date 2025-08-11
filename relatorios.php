<?php
require_once 'config.php';
require_once 'dompdf/autoload.inc.php'; // Include DOMPDF
use Dompdf\Dompdf;
verificaLogin();

// Fetch available locations
try {
    $stmt_locais = $pdo->query("SELECT id, nome FROM locais ORDER BY nome");
    $locais = $stmt_locais->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar locais: " . $e->getMessage());
}

// Fetch available items (sorted alphabetically)
try {
    $stmt_itens = $pdo->query("SELECT id, descricao FROM itens ORDER BY descricao ASC");
    $itens = $stmt_itens->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar itens: " . $e->getMessage());
}

// Initialize filter variables
$selected_local = isset($_GET['local_id']) ? (int)$_GET['local_id'] : 0;
$selected_item = isset($_GET['item_id']) ? (int)$_GET['item_id'] : 0;
$data_inicio = isset($_GET['data_inicio']) ? $_GET['data_inicio'] : '';
$data_fim = isset($_GET['data_fim']) ? $_GET['data_fim'] : '';

$where_clause = [];
$params = [];

if ($selected_local) {
    $where_clause[] = "s.destino = ?";
    $params[] = $selected_local;
}

if ($selected_item) {
    $where_clause[] = "s.item_id = ?";
    $params[] = $selected_item;
}

if ($data_inicio) {
    $where_clause[] = "DATE(s.data_saida) >= ?";
    $params[] = $data_inicio;
}

if ($data_fim) {
    $where_clause[] = "DATE(s.data_saida) <= ?";
    $params[] = $data_fim;
}

$where_sql = !empty($where_clause) ? "AND " . implode(" AND ", $where_clause) : "";

// Fetch material withdrawals
try {
    $query = "SELECT s.id, s.quantidade, s.data_saida, s.usuario, i.codigo, i.descricao, l.nome AS local_nome 
              FROM saidas s 
              JOIN itens i ON s.item_id = i.id 
              LEFT JOIN locais l ON s.destino = l.id 
              WHERE 1=1 $where_sql 
              ORDER BY s.data_saida DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $saidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar saídas: " . $e->getMessage());
}

// Handle PDF generation
if (isset($_GET['gerar_pdf'])) {
    $local_nome = $selected_local ? htmlspecialchars($locais[array_search($selected_local, array_column($locais, 'id'))]['nome']) : 'Todos os Locais';
    $item_nome = $selected_item ? htmlspecialchars($itens[array_search($selected_item, array_column($itens, 'id'))]['descricao']) : 'Todos os Itens';
    $data_filtro = ($data_inicio || $data_fim) ? 'Período: ' . ($data_inicio ? date('d/m/Y', strtotime($data_inicio)) : 'Início') . ' até ' . ($data_fim ? date('d/m/Y', strtotime($data_fim)) : 'Fim') : 'Todos os Períodos';

    $html = '
    <h3 style="text-align: center;">SECRETARIA MUNICIPAL DE EDUCAÇÃO</h3>
    <h3 style="text-align: center;">DIVISÃO DE ALMOXARIFADO</h3>
    <h3 style="text-align: center;">Relatório de Saídas de Material</h3>
    <h4 style="text-align: center;">' . $local_nome . '</h4>
    <h4 style="text-align: center;">' . $item_nome . '</h4>
    <h4 style="text-align: center;">' . $data_filtro . '</h4>
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th style="border: 1px solid #dee2e6; padding: 8px;">Código</th>
                <th style="border: 1px solid #dee2e6; padding: 8px;">Descrição</th>
                <th style="border: 1px solid #dee2e6; padding: 8px;">Local (Destino)</th>
                <th style="border: 1px solid #dee2e6; padding: 8px;">Quantidade</th>
                <th style="border: 1px solid #dee2e6; padding: 8px;">Data da Saída</th>
            </tr>
        </thead>
        <tbody>';
    foreach ($saidas as $saida) {
        $html .= '
            <tr>
                <td style="border: 1px solid #dee2e6; padding: 8px;">' . htmlspecialchars($saida['codigo']) . '</td>
                <td style="border: 1px solid #dee2e6; padding: 8px;">' . htmlspecialchars($saida['descricao']) . '</td>
                <td style="border: 1px solid #dee2e6; padding: 8px;">' . htmlspecialchars($saida['local_nome'] ?? 'Sem Local') . '</td>
                <td style="border: 1px solid #dee2e6; padding: 8px;">' . $saida['quantidade'] . '</td>
                <td style="border: 1px solid #dee2e6; padding: 8px;">' . date('d/m/Y H:i', strtotime($saida['data_saida'])) . '</td>
            </tr>';
    }
    $html .= '
        </tbody>
    </table>';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('relatorio_saidas_material.pdf', ['Attachment' => true]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - Almoxarifado</title>
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
                    <li class="nav-item"><a class="nav-link" href="entradas.php"><i class="fas fa-sign-in-alt me-1"></i>Entradas</a></li>
                    <li class="nav-item"><a class="nav-link" href="saidas.php"><i class="fas fa-sign-out-alt me-1"></i>Saídas</a></li>
                    <li class="nav-item"><a class="nav-link active" href="relatorios.php"><i class="fas fa-chart-bar me-1"></i>Relatórios</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-door-open me-1"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4"><i class="fas fa-chart-bar me-2"></i>Relatório de Saídas de Material</h2>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="local_id" class="form-label">Filtrar por Local (Destino)</label>
                        <select name="local_id" id="local_id" class="form-select" onchange="this.form.submit()">
                            <option value="0" <?php echo $selected_local == 0 ? 'selected' : ''; ?>>Todos os Locais</option>
                            <?php foreach ($locais as $local): ?>
                                <option value="<?php echo $local['id']; ?>" <?php echo $selected_local == $local['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($local['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="item_id" class="form-label">Filtrar por Item</label>
                        <select name="item_id" id="item_id" class="form-select" onchange="this.form.submit()">
                            <option value="0" <?php echo $selected_item == 0 ? 'selected' : ''; ?>>Todos os Itens</option>
                            <?php foreach ($itens as $item): ?>
                                <option value="<?php echo $item['id']; ?>" <?php echo $selected_item == $item['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($item['descricao']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" name="data_inicio" id="data_inicio" class="form-control" value="<?php echo htmlspecialchars($data_inicio); ?>" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-2">
                        <label for="data_fim" class="form-label">Data Fim</label>
                        <input type="date" name="data_fim" id="data_fim" class="form-control" value="<?php echo htmlspecialchars($data_fim); ?>" onchange="this.form.submit()">
                    </div>
                    <div class="col-md-2">
                        <a href="?local_id=<?php echo $selected_local; ?>&item_id=<?php echo $selected_item; ?>&data_inicio=<?php echo urlencode($data_inicio); ?>&data_fim=<?php echo urlencode($data_fim); ?>&gerar_pdf=1" class="btn btn-primary w-100"><i class="fas fa-file-pdf me-2"></i>Gerar PDF</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Local (Destino)</th>
                            <th>Quantidade</th>
                            <th>Data da Saída</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($saidas as $saida): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($saida['codigo']); ?></td>
                            <td><?php echo htmlspecialchars($saida['descricao']); ?></td>
                            <td><?php echo htmlspecialchars($saida['local_nome'] ?? 'Sem Local'); ?></td>
                            <td><?php echo $saida['quantidade']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($saida['data_saida'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>