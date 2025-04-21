<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/style_login.css">
    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
</head>
<body>
    <div id="particles-js"></div>
    <?php
    //Caso o usuário esteja logado
    if (isset($_SESSION['usercod'])){
        include '../phpInclude/headerlogado.php';
    //Senão
    }else{
        include '../phpInclude/header.php';
    }
    ?>
    
    <div class="login-container">
    <h2>Bem-vindo, faça seu login!</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        require '../phpExec/login_control.php';
        $exe = logarUsuario();
        if ($exe[0]){
            echo '<p>'. $exe[1] .'</p>';
            header("Location: ../site/home.php");
        }else{
            echo '<p>'. $exe[1] .'</p>';
        }
    }
    ?>
    <form action="" method="POST">
        <fieldset>
            <label>E-mail:</label><input class="inputText" type="text" name="email" value="<?php if (isset($_POST['email'])){echo htmlspecialchars($_POST['email']);}?>" placeholder="Digite o seu e-mail" required><br><br>
            <label>Senha:</label><input class="inputText" type="password" name="psswd" value="<?php if (isset($_POST['psswd'])){echo htmlspecialchars($_POST['psswd']);}?>" placeholder="Digite a sua senha" required><br><br>
            <label>Usuário:</label><input class="inputText" type="text" name="username" value="<?php if (isset($_POST['username'])){echo htmlspecialchars($_POST['username']);}?>" placeholder="Digite o seu usuário" required><br><br>
            <input class="inputSubmit" type="submit" value="Entrar">
        </fieldset>
    </form>
    </div>

    
    <?php include '../phpInclude/footer.php'; ?>
    <script src="../JS/funcionalides.js"></script>
</body>
</html>