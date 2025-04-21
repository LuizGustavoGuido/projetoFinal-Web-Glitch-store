<?php
session_start(); 
require '../phpExec/catalogo_produtos.php';

if (isset($_GET['categoria'])){
  $categoria = $_GET['categoria'];
  setcookie("categoria", $_GET['categoria'], time()+3600);
}elseif (isset($_COOKIE['categoria'])){
  $categoria = $_COOKIE['categoria'];
}else{
  $categoria = "";
}

if (isset($_GET['search'])){
  $search = $_GET['search'];
  setcookie("search", $_GET['search'], time()+3600);
}elseif (isset($_COOKIE['search'])){
  $search = $_COOKIE['search'];
}else{
  $search = "";
}

if (isset($_GET['pagina'])){
  $pagina = $_GET['pagina'];
  setcookie("pagina", $_GET['pagina'], time()+3600);
}elseif (isset($_COOKIE['pagina'])){
  $pagina = $_COOKIE['pagina'];
}else{
  $pagina = 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produtos</title>
  <link rel="stylesheet" href="../CSS/style_produtos.css?v=1.0">
  <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
</head>
<body>
  <div id="particles-js"></div>
  <?php
    if (isset($_SESSION['usercod'])){
        include '../phpInclude/headerlogado.php';
    }else{
        include '../phpInclude/header.php';
    }
  ?>
  
  <form action="">
    <div class="products-container">
      <h1>Nossos Produtos</h1>
      <nav class="product-categories">
        <a href="?categoria=">Ver Todos</a>
        <a href="?categoria=computador">Computadores</a>
        <a href="?categoria=hardware">Hardware</a>
        <a href="?categoria=periferico">Periféricos</a>
      </nav>
    </div>
    <div class="pesquisa-items">
      <input class="pesquisa" type="text" name="search" placeholder="Digite sua pesquisa...">
      <input class="pesquisar" type="submit" value="Pesquisar">
    </div>
  </form>

    <?php
    gerarPagina($pagina, $categoria, $search);
    ?>

    <?php include '../phpInclude/footer.php'; ?>
    <script src="../JS/funcionalides.js"></script>
</body>
</html>
