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

// Initialize variables
$selected_local = isset($_GET['local_id']) ? (int)$_GET['local_id'] : 0;
$where_clause = $selected_local ? "AND s.destino = $selected_local" : "";

// Fetch material withdrawals
try {
    $stmt = $pdo->query("SELECT s.id, s.quantidade, s.data_saida, s.usuario, i.codigo, i.descricao, l.nome AS local_nome 
                         FROM saidas s 
                         JOIN itens i ON s.item_id = i.id 
                         LEFT JOIN locais l ON s.destino = l.id 
                         WHERE 1=1 $where_clause 
                         ORDER BY s.data_saida DESC");
    $saidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar saídas: " . $e->getMessage());
}

// Handle PDF generation
if (isset($_GET['gerar_pdf'])) {
    $html = '
    <h3 style="text-align: center;">SECRETARIA MUNICIPAL DE EDUCAÇÃO</h3>
    <h3 style="text-align: center;">DIVISÃO DE ALMOXARIFADO</h3>
    <h3 style="text-align: center;">Relatório de Saídas de Material</h3>
    <h4 style="text-align: center;">' . ($selected_local ? 'Local: ' . htmlspecialchars($locais[array_search($selected_local, array_column($locais, 'id'))]['nome']) : 'Todos os Locais') . '</h4>
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
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <a href="?local_id=<?php echo $selected_local; ?>&gerar_pdf=1" class="btn btn-primary"><i class="fas fa-file-pdf me-2"></i>Gerar PDF</a>
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