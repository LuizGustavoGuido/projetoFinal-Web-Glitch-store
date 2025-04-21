<?php
session_start();
if (!isset($_SESSION['usercod'])) {
    header('Location: login.php');
    exit();
}
require '../phpExec/user_control.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Usuário</title>
    <link rel="stylesheet" href="../CSS/style_user.css">
</head>
<body>
    <?php
        if (isset($_SESSION['usercod'])){
            include '../phpInclude/headerlogado.php';
        }else{
            include '../phpInclude/header.php';
        }
?>

    <h1>Perfil do Usuário</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $exe = atualizarUser();
        echo '<p>'. $exe[1] . '</p>';
    }
    ?>
    <form method="POST">
        <input type="hidden" name="update_info" value="1">
        <label for="username">Nome de Usuário:</label>
        <input type="text" id="username" name="username" value="<?php echo $_SESSION['name']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" required>

        <button type="submit">Salvar Alterações</button>
    </form>

    <h2>Alterar Senha</h2>
    <form method="POST">
        <input type="hidden" name="change_password" value="1">
        <label for="current_password">Senha Atual:</label>
        <input type="password" id="current_password" name="current_password" required>

        <label for="new_password">Nova Senha:</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="confirm_password">Confirmar Nova Senha:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Alterar Senha</button>
    </form>
    <a href="pedidos.php" class="admin-button">Pedidos Realizados</a>

    <?php 
    if ($_SESSION['usercod'] === 1){
        echo '<a href="CRUD.php" class="admin-button">Acessar Página de Administração</a>';
    }
    ?>

    <a href="../phpExec/deslogar.php" class="logout">Sair</a>
    <?php include '../phpInclude/footer.php'; ?>
</body>
</html>
