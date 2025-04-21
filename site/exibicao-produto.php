<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['id'], $_POST['nome'], $_POST['tipoproduto'], $_POST['categoria'], 
    $_POST['descricao'], $_POST['preco'], $_POST['imgpath'])){
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $tipoproduto = $_POST['tipoproduto'];
        $categoria = $_POST['categoria'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $imgpath = $_POST['imgpath'];
        $parcelas = $_POST['parcelas'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibição do produto</title>
    <link rel="stylesheet" href="../CSS/style_exibicao.css?v=2">
</head>
<body>
    <?php
        if (isset($_SESSION['usercod'])){
            include '../phpInclude/headerlogado.php';
        }else{
            include '../phpInclude/header.php';
        }
    ?>
    <?php
    echo '<div class="product">
        <form method="POST" action="../phpExec/adicionaraocarrinho.php">
            <img src="'. $imgpath .'" alt="'. $nome .'">

            <div class="details">
                <h1>'. $tipoproduto .' '. $nome .'</h1>';
                if (isset($parcela) && is_numeric($parcela)){
                    echo '<p class="price">'. $parcela. 'x de R$'. sprintf("%.2f", $preco*1.07 / $parcela) .'<br>R$'. $preco .'</p>';
                }else{
                    echo '<p class="price">R$'. $preco .'</p>';
                }
                echo '
                <div class="quantity">
                    <button type="button" onclick="ajustarqnt(document.getElementById(\'qnt\'), 0)">-</button>
                    <input id="qnt" type="text" name="qnt" value="1" min="1" pattern="[0-9]{1,}">
                    <button type="button" onclick="ajustarqnt(document.getElementById(\'qnt\'), 1)">+</button>
                </div>

                <div class="buy-now">
                    <button type="submit">Comprar ao carrinho &#128722;</button>
                </div>

                <!-- Campos ocultos para enviar informações -->
                <input type="hidden" name="id" value="'. $id .'">
                <input type="hidden" name="nome" value="'. $nome .'">
                <input type="hidden" name="tipoproduto" value="'. $tipoproduto .'">
                <input type="hidden" name="categoria" value="'. $categoria .'">
                <input type="hidden" name="descricao" value="'. $descricao .'">
                <input type="hidden" name="preco" value="'. $preco .'">
                <input type="hidden" name="imgpath" value="'. $imgpath .'">
                <input type="hidden" name="parcelas" value="'. $parcelas .'">
            </form>
        </div>
    </div>
    <div class="product">
        <div class="characteristics">
            <p><strong>Descrições:</strong></p>
            <p>' . $descricao . ' </p>
        </div>
    </div>';
    ?>
    <?php include '../phpInclude/footer.php'; ?>
    <script src="../JS/funcionalides.js"></script>
</body>
</html>