<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GLITCH Store</title>
    <link rel="stylesheet" href="../CSS/styles_home.css?v=2">
</head>
<body>
    <?php
    //Caso o usuário esteja logado
    if (isset($_SESSION['usercod'])){
        include '../phpInclude/headerlogado.php';
    //Senão
    }else{
        include '../phpInclude/header.php';
    }
    ?>
    
    <div class="content">
      <main>
        <section class="hero">
            <h1>Experiencie a alta performance</h1>
            <p>Monte o seu setup dos sonhos com a gente.</p>
            <button>EXPLORE</button>
        </section>
        <section class="info">
            <h2>GLITCH Store, a maior do mercado.</h2>
            <p>Somos refer&ecirc;ncia no comércio de computadores e perif&eacute;ricos.</p>
            <div class="text-columns">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare.</p>
            </div>
        </section>
        <section class="products">
            <h2>Principais Categorias</h2>
            <p>Confira os nossos produtos</p>
            <div class="product-grid">
              <a href="../site/produtos.php?categoria=computador" class="product-link">
                  <div class="product">
                      <video src="../videos-imagens/pinterest-video83.mp4" autoplay loop muted></video>
                      <div class="product-title">COMPUTADORES</div>
                  </div>
              </a>
              <a href="../site/produtos.php?categoria=hardware" class="product-link">
                  <div class="product">
                      <video src="../videos-imagens/pinterest-video40.mp4" autoplay loop muted></video>
                      <div class="product-title">HARDWARE</div>
                  </div>
              </a>
              <a href="../site/produtos.php?categoria=periferico" class="product-link">
                  <div class="product">
                      <video src="../videos-imagens/pinterest-video21.mp4" autoplay loop muted></video>
                      <div class="product-title">PERIF&Eacute;RICOS</div>
                  </div>
              </a>
          </div>
        </section>
    </main>

    <?php include '../phpInclude/footer.php'; ?>
    </div>
</body>
</html>
