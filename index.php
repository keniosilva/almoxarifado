<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Almoxarifado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body class="login-bg">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg p-4 bg-white rounded-3" style="max-width: 400px; width: 100%;">
            <h2 class="text-center mb-4"><i class="fas fa-warehouse me-2"></i>Almoxarifado</h2>
            <?php
            require_once 'config.php';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];
                
                $nome_completo = autenticarAD($username, $password);
                if ($nome_completo) {
                    $_SESSION['usuario'] = $username;
                    $_SESSION['nome_completo'] = $nome_completo;
                    
                    $stmt = $pdo->prepare("INSERT IGNORE INTO usuarios (username, nome_completo, ultimo_login) VALUES (?, ?, NOW())");
                    $stmt->execute([$username, $nome_completo]);
                    
                    header('Location: dashboard.php');
                    exit;
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>Credenciais inválidas!
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                          </div>';
                }
            }
            ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user me-2"></i>Usuário</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock me-2"></i>Senha</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-sign-in-alt me-2"></i>Entrar</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>