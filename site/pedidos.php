<?php
session_start();
if (!isset($_SESSION['usercod'])){
    header("Location:../site/login.php");
}else{
    require '../phpExec/CRUD_control.php';
    $funcResult = pesquisarBD('pedido','usercod','=', $_SESSION['usercod']);
    $arrayPedido = mysqli_fetch_all($funcResult[1], MYSQLI_BOTH);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link rel="stylesheet" href="../CSS/style_pedidos.css">
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
    <section>
        <?php
        if (isset($arrayPedido)){
            foreach ($arrayPedido as $pedido){
                echo'<div>
                        <div>
                            <div>Código do pedido: '.$pedido['id'].'</div> <div>Data do pedido: '.$pedido['datapedido'].'</div> <div>CEP: '.$pedido['cep'].'</div> <div>Método de pagamento:'.$pedido['metodopagamento'].'</div> 
                        </div>
                        <div>
                            <div>';
                    $funcResult = pesquisarBD('pedidoitem','idpedido','=', $pedido['id']);
                    $arrayPedidoItem = mysqli_fetch_all($funcResult[1], MYSQLI_BOTH);
                    foreach ($arrayPedidoItem as $pedidoitem){
                        $funcResult = pesquisarBD('item','id','=', $pedidoitem['iditem']);
                        $arrayItem = mysqli_fetch_all($funcResult[1], MYSQLI_BOTH);
                        foreach ($arrayItem as $item){
                            echo '<p>'.$pedidoitem['quantidade'].'x '.$item['nome'].'</p>';
                        }
                    }
                    echo'</div>
                        <div>Valor do pedido: '.$pedido['valorpedido'].'</div> 
                    </div>
                </div><br>';
            }
        }
        ?>
    </section>
    <?php include '../phpInclude/footer.php'; ?>
</body>
</html>