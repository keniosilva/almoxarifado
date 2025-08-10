<?php
require_once 'config.php';
verificaLogin();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        // Edição de item
        $id = (int)$_POST['id'];
        $codigo = $_POST['codigo'];
        $descricao = $_POST['descricao'];
        $unidade = $_POST['unidade'];
        $estoque_minimo = (int)$_POST['estoque_minimo'];

        try {
            $stmt = $pdo->prepare("UPDATE itens SET codigo = ?, descricao = ?, unidade = ?, estoque_minimo = ? WHERE id = ?");
            $stmt->execute([$codigo, $descricao, $unidade, $estoque_minimo, $id]);
            $success = "Item atualizado com sucesso!";
        } catch (PDOException $e) {
            $error = "Erro ao atualizar item: " . $e->getMessage();
        }
    } else {
        // Cadastro de novo item
        $codigo = $_POST['codigo'];
        $descricao = $_POST['descricao'];
        $unidade = $_POST['unidade'];
        $estoque_minimo = (int)$_POST['estoque_minimo'];

        try {
            $stmt = $pdo->prepare("INSERT INTO itens (codigo, descricao, unidade, estoque_minimo) VALUES (?, ?, ?, ?)");
            $stmt->execute([$codigo, $descricao, $unidade, $estoque_minimo]);
            $success = "Item cadastrado com sucesso!";
        } catch (PDOException $e) {
            $error = "Erro ao cadastrar item: " . $e->getMessage();
        }
    }
}

$stmt = $pdo->query("SELECT * FROM itens");
$itens = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itens - Almoxarifado</title>
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
                    <li class="nav-item"><a class="nav-link active" href="itens.php"><i class="fas fa-box me-1"></i>Itens</a></li>
                    <li class="nav-item"><a class="nav-link" href="entradas.php"><i class="fas fa-sign-in-alt me-1"></i>Entradas</a></li>
                    <li class="nav-item"><a class="nav-link" href="saidas.php"><i class="fas fa-sign-out-alt me-1"></i>Saídas</a></li>
                    <li class="nav-item"><a class="nav-link" href="relatorios.php"><i class="fas fa-chart-bar me-1"></i>Relatórios</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-door-open me-1"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4"><i class="fas fa-box me-2"></i>Gerenciamento de Itens</h2>
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="codigo" class="form-control" placeholder="Código" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="descricao" class="form-control" placeholder="Descrição" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="unidade" class="form-control" placeholder="Unidade" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="estoque_minimo" class="form-control" placeholder="Estoque Mínimo" required min="0">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-plus me-2"></i>Cadastrar</button>
                        </div>
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
                            <th>Unidade</th>
                            <th>Estoque Atual</th>
                            <th>Estoque Mínimo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($itens as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['codigo']); ?></td>
                            <td><?php echo htmlspecialchars($item['descricao']); ?></td>
                            <td><?php echo htmlspecialchars($item['unidade']); ?></td>
                            <td><?php echo $item['estoque_atual']; ?></td>
                            <td><?php echo $item['estoque_minimo']; ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-id="<?php echo $item['id']; ?>"
                                        data-codigo="<?php echo htmlspecialchars($item['codigo']); ?>"
                                        data-descricao="<?php echo htmlspecialchars($item['descricao']); ?>"
                                        data-unidade="<?php echo htmlspecialchars($item['unidade']); ?>"
                                        data-estoque_minimo="<?php echo $item['estoque_minimo']; ?>">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal de Edição -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel"><i class="fas fa-edit me-2"></i>Editar Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" id="edit-id">
                            <div class="mb-3">
                                <label for="edit-codigo" class="form-label">Código</label>
                                <input type="text" name="codigo" id="edit-codigo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-descricao" class="form-label">Descrição</label>
                                <input type="text" name="descricao" id="edit-descricao" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-unidade" class="form-label">Unidade</label>
                                <input type="text" name="unidade" id="edit-unidade" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-estoque_minimo" class="form-label">Estoque Mínimo</label>
                                <input type="number" name="estoque_minimo" id="edit-estoque_minimo" class="form-control" required min="0">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancelar</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        // Preenche o modal com os dados do item
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const codigo = button.getAttribute('data-codigo');
            const descricao = button.getAttribute('data-descricao');
            const unidade = button.getAttribute('data-unidade');
            const estoque_minimo = button.getAttribute('data-estoque_minimo');

            const modal = editModal;
            modal.querySelector('#edit-id').value = id;
            modal.querySelector('#edit-codigo').value = codigo;
            modal.querySelector('#edit-descricao').value = descricao;
            modal.querySelector('#edit-unidade').value = unidade;
            modal.querySelector('#edit-estoque_minimo').value = estoque_minimo;
        });
    </script>
</body>
</html>