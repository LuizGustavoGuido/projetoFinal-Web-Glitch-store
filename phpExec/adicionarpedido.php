<?php
require '../phpInclude/dbinfo.php';
require '../phpInclude/funcoesgerais.php';
function adicionarpedido($cep, $metodoPagamento){
    global $dbhost; global $dbuser; global $dbpsswd; global $dbname;
    // Conexão com o banco de dados
    $connection = mysqli_connect($dbhost, $dbuser, $dbpsswd, $dbname) 
    or die('Não foi possível conectar-se, tente mais tarde' . mysqli_connect_error());

    $cep = filtrarInput($connection, $cep);
    $metodoPagamento = filtrarInput($connection, $metodoPagamento);
    $valorpedido = 0;
    //Itera pelo carrinho do usuário, onde $keyitem é o id de cada item e $item é o conteúdo de cada item exceto id
    foreach ($_SESSION['carrinho'] as $keyitem => $item){
        $valorpedido += $item['preco'] * $item['qnt'];
    }
    //Insere na tabela pedido o cep recebido, o valor total do pedido e o código do usuário que realizou o pedido
    $queryPedido = 'Insert into pedido(cep,valorpedido,metodopagamento,usercod) values (?,?,?,?)';
    $stmt = mysqli_prepare($connection, $queryPedido);
    mysqli_stmt_bind_param($stmt, 'sdsi', $cep, $valorpedido, $metodoPagamento, $_SESSION['usercod']);
    $exePedido = mysqli_stmt_execute($stmt);
    if ($exePedido){
        //mysqli_insert_id retorna o id do último query enviado ao banco de dados, no caso o id do pedido feito anteriormente
        //devido a condição de corrida em multithreading, é mais seguro e eficiente que select max(id) from pedido
        $idpedido = mysqli_insert_id($connection);

        //Para cada item no carrinho onde $keyitem é seu id e $item é seu conteúdo exceto id
        foreach ($_SESSION['carrinho'] as $keyitem => $item){
            //Insere na tabela pedidoitem o id do pedido, o id do item e a quantidade pedida
            $queryPedidoItem = 'Insert into pedidoitem values (?,?,?)';
            $stmt = mysqli_prepare($connection, $queryPedidoItem);
            mysqli_stmt_bind_param($stmt, 'iii', $idpedido, $keyitem, $item['qnt']);
            $exePedidoItem = mysqli_stmt_execute($stmt);
            if (!$exePedidoItem){
                return [false, 'Falha no registro dos itens pedidos, tente novamente'];
            }
        }
    }else{
        return [false, 'Falha no registro do pedido, tente novamente'];
    }

    mysqli_close($connection);
    unset($_SESSION['carrinho']);
    return [true, 'Pedido realizado!'];
}