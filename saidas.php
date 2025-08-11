<?php
require_once 'config.php';
verificaLogin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $items = $_POST['items'] ?? [];
    $destino = (int)$_POST['destino'];
    
    // Verifica se o destino existe
    $stmt = $pdo->prepare("SELECT id FROM locais WHERE id = ?");
    $stmt->execute([$destino]);
    $local = $stmt->fetch();
    
    if ($local && !empty($items)) {
        try {
            $pdo->beginTransaction();
            $all_valid = true;
            
            foreach ($items as $item) {
                $item_id = (int)$item['item_id'];
                $quantidade = (int)$item['quantidade'];
                
                // Verifica o estoque atual do item
                $stmt = $pdo->prepare("SELECT estoque_atual FROM itens WHERE id = ?");
                $stmt->execute([$item_id]);
                $item_data = $stmt->fetch();
                
                if (!$item_data || $quantidade <= 0 || $quantidade > $item_data['estoque_atual']) {
                    $all_valid = false;
                    $error = "Erro: Quantidade inválida ou estoque insuficiente para um ou mais itens.";
                    break;
                }
                
                // Registra a saída
                $stmt = $pdo->prepare("INSERT INTO saidas (item_id, quantidade, data_saida, destino, usuario) VALUES (?, ?, NOW(), ?, ?)");
                $stmt->execute([$item_id, $quantidade, $destino, $_SESSION['usuario']]);
                
                // Atualiza o estoque
                $stmt = $pdo->prepare("UPDATE itens SET estoque_atual = estoque_atual - ? WHERE id = ?");
                $stmt->execute([$quantidade, $item_id]);
            }
            
            if ($all_valid) {
                $pdo->commit();
                $success = "Saídas registradas com sucesso!";
            } else {
                $pdo->rollBack();
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Erro ao registrar saídas: " . $e->getMessage();
        }
    } else {
        $error = "Destino inválido ou nenhum item selecionado!";
    }
}

$stmt = $pdo->query("SELECT * FROM itens ORDER BY descricao ASC");
$itens = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM locais");
$locais = $stmt->fetchAll();

// Fetch withdrawals by month
try {
    $stmt = $pdo->query("SELECT DATE_FORMAT(s.data_saida, '%Y-%m') AS mes_ano, 
                                DATE_FORMAT(s.data_saida, '%M %Y') AS mes_ano_nome,
                                s.data_saida, i.codigo, i.descricao, s.quantidade, l.nome AS local_nome, s.usuario 
                         FROM saidas s 
                         JOIN itens i ON s.item_id = i.id 
                         LEFT JOIN locais l ON s.destino = l.id 
                         ORDER BY s.data_saida DESC");
    $saidas_por_mes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Erro ao buscar saídas: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saídas - Almoxarifado</title>
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
                    <li class="nav-item"><a class="nav-link active" href="saidas.php"><i class="fas fa-sign-out-alt me-1"></i>Saídas</a></li>
                    <li class="nav-item"><a class="nav-link" href="locais.php"><i class="fas fa-map-marker-alt me-1"></i>Locais</a></li>
                    <li class="nav-item"><a class="nav-link" href="relatorios.php"><i class="fas fa-chart-bar me-1"></i>Relatórios</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-door-open me-1"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4"><i class="fas fa-sign-out-alt me-2"></i>Registro de Saídas</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="POST" id="saidaForm">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <select name="destino" class="form-select" required>
                                <option value="">Selecione o Destino</option>
                                <?php foreach ($locais as $local): ?>
                                <option value="<?php echo $local['id']; ?>"><?php echo htmlspecialchars($local['nome']); ?> (<?php echo $local['tipo']; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div id="itens-container">
                        <div class="row g-3 mb-2 item-row">
                            <div class="col-md-4">
                                <select name="items[0][item_id]" class="form-select item-select" required>
                                    <option value="">Selecione o Item</option>
                                    <?php foreach ($itens as $item): ?>
                                    <option value="<?php echo $item['id']; ?>" data-estoque="<?php echo $item['estoque_atual']; ?>">
                                        <?php echo htmlspecialchars($item['descricao']); ?> (Estoque: <?php echo $item['estoque_atual']; ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="items[0][quantidade]" class="form-control" placeholder="Quantidade" required min="1">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-remove-item"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-secondary w-100" id="add-item"><i class="fas fa-plus me-2"></i>Adicionar Item</button>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-2"></i>Registrar Saídas</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <h3 class="mb-4"><i class="fas fa-table me-2"></i>Saídas por Mês</h3>
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mês/Ano</th>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Destino</th>
                            <th>Data da Saída</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $current_mes_ano = '';
                        foreach ($saidas_por_mes as $saida):
                            $mes_ano = $saida['mes_ano'];
                            $mes_ano_nome = $saida['mes_ano_nome'];
                            if ($mes_ano !== $current_mes_ano):
                                $current_mes_ano = $mes_ano;
                        ?>
                            <tr style="background-color: #f8f9fa; font-weight: bold;">
                                <td colspan="7"><?php echo htmlspecialchars($mes_ano_nome); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td></td>
                            <td><?php echo htmlspecialchars($saida['codigo']); ?></td>
                            <td><?php echo htmlspecialchars($saida['descricao']); ?></td>
                            <td><?php echo $saida['quantidade']; ?></td>
                            <td><?php echo htmlspecialchars($saida['local_nome'] ?? 'Sem Destino'); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($saida['data_saida'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let itemCount = 1;
        document.getElementById('add-item').addEventListener('click', function() {
            const container = document.getElementById('itens-container');
            const newRow = document.createElement('div');
            newRow.className = 'row g-3 mb-2 item-row';
            newRow.innerHTML = `
                <div class="col-md-4">
                    <select name="items[${itemCount}][item_id]" class="form-select item-select" required>
                        <option value="">Selecione o Item</option>
                        <?php foreach ($itens as $item): ?>
                        <option value="<?php echo $item['id']; ?>" data-estoque="<?php echo $item['estoque_atual']; ?>">
                            <?php echo htmlspecialchars($item['descricao']); ?> (Estoque: <?php echo $item['estoque_atual']; ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="items[${itemCount}][quantidade]" class="form-control" placeholder="Quantidade" required min="1">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-remove-item"><i class="fas fa-trash"></i></button>
                </div>
            `;
            container.appendChild(newRow);
            itemCount++;
            updateRemoveButtons();
        });

        function updateRemoveButtons() {
            const removeButtons = document.querySelectorAll('.btn-remove-item');
            removeButtons.forEach(button => {
                button.disabled = document.querySelectorAll('.item-row').length === 1;
                button.onclick = function() {
                    if (document.querySelectorAll('.item-row').length > 1) {
                        this.closest('.item-row').remove();
                    }
                };
            });
        }

        document.getElementById('saidaForm').addEventListener('submit', function(e) {
            const selects = document.querySelectorAll('.item-select');
            const selectedItems = Array.from(selects).map(select => select.value);
            const hasDuplicates = selectedItems.some((item, index) => item && selectedItems.indexOf(item) !== index);
            if (hasDuplicates) {
                e.preventDefault();
                alert('Não é permitido selecionar o mesmo item mais de uma vez.');
            }
        });

        updateRemoveButtons();
    </script>