<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suporte</title>
  <link rel="stylesheet" href="../CSS/style_suporte.css">
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
  
  <div class="form-container">
    <h1>Suporte</h1>
    <p>Preencha o formulário para obter ajuda</p>
    <form action="#" method="post">
      <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" id="name" name="name" placeholder="Digite o seu nome" required>
      </div>
      <div class="form-group">
        <label for="email">Endereço de E-mail</label>
        <input type="email" id="email" name="email" placeholder="Digite o seu e-mail" required>
      </div>
      <div class="form-group">
        <label for="message">Mensagem</label>
        <textarea id="message" name="message" placeholder="Digite a sua mensagem" required></textarea>
      </div>
      <button type="submit">Enviar</button>
    </form>
  </div>
  <?php include '../phpInclude/footer.php'; ?>
  <script src="../JS/funcionalides.js"></script>
</body>
</html>
