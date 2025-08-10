<?php
require_once 'config.php';
verificaLogin();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        // Edição de local
        $id = (int)$_POST['id'];
        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];

        try {
            $stmt = $pdo->prepare("UPDATE locais SET nome = ?, tipo = ? WHERE id = ?");
            $stmt->execute([$nome, $tipo, $id]);
            $success = "Local atualizado com sucesso!";
        } catch (PDOException $e) {
            $error = "Erro ao atualizar local: " . $e->getMessage();
        }
    } else {
        // Cadastro de novo local
        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];

        try {
            $stmt = $pdo->prepare("INSERT INTO locais (nome, tipo) VALUES (?, ?)");
            $stmt->execute([$nome, $tipo]);
            $success = "Local cadastrado com sucesso!";
        } catch (PDOException $e) {
            $error = "Erro ao cadastrar local: " . $e->getMessage();
        }
    }
}

$stmt = $pdo->query("SELECT * FROM locais");
$locais = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locais - Almoxarifado</title>
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
                    <li class="nav-item"><a class="nav-link active" href="locais.php"><i class="fas fa-map-marker-alt me-1"></i>Locais</a></li>
                    <li class="nav-item"><a class="nav-link" href="relatorios.php"><i class="fas fa-chart-bar me-1"></i>Relatórios</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-door-open me-1"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="mb-4"><i class="fas fa-map-marker-alt me-2"></i>Gerenciamento de Locais</h2>
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
                        <div class="col-md-6">
                            <input type="text" name="nome" class="form-control" placeholder="Nome do Local" required>
                        </div>
                        <div class="col-md-4">
                            <select name="tipo" class="form-control" required>
                                <option value="">Selecione o Tipo</option>
                                <option value="Escola">Escola</option>
                                <option value="Creche">Creche</option>
                                <option value="Setor Interno">Setor Interno</option>
                                <option value="Anexo">Anexo</option>
                            </select>
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
                            <th>Nome</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($locais as $local): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($local['nome']); ?></td>
                            <td><?php echo htmlspecialchars($local['tipo']); ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-id="<?php echo $local['id']; ?>"
                                        data-nome="<?php echo htmlspecialchars($local['nome']); ?>"
                                        data-tipo="<?php echo htmlspecialchars($local['tipo']); ?>">
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
                        <h5 class="modal-title" id="editModalLabel"><i class="fas fa-edit me-2"></i>Editar Local</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" id="edit-id">
                            <div class="mb-3">
                                <label for="edit-nome" class="form-label">Nome do Local</label>
                                <input type="text" name="nome" id="edit-nome" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-tipo" class="form-label">Tipo</label>
                                <select name="tipo" id="edit-tipo" class="form-control" required>
                                    <option value="Escola">Escola</option>
                                    <option value="Creche">Creche</option>
                                    <option value="Setor Interno">Setor Interno</option>
                                    <option value="Anexo">Anexo</option>
                                </select>
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
        // Preenche o modal com os dados do local
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nome = button.getAttribute('data-nome');
            const tipo = button.getAttribute('data-tipo');

            const modal = editModal;
            modal.querySelector('#edit-id').value = id;
            modal.querySelector('#edit-nome').value = nome;
            modal.querySelector('#edit-tipo').value = tipo;
        });
    </script>
</body>
</html>