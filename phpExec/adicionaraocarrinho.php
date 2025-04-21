<?php
session_start();
if (isset($_SESSION['usercod'])){
    if (isset($_POST['id'], $_POST['nome'], $_POST['tipoproduto'], $_POST['categoria'], $_POST['preco'], $_POST['imgpath'], $_POST['qnt'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $tipoproduto = $_POST['tipoproduto'];
        $categoria = $_POST['categoria'];
        $preco = $_POST['preco'];
        $imgpath = $_POST['imgpath'];
        $parcelas = $_POST['parcelas'];
        $qnt = $_POST['qnt'];
    }
    if ($qnt>=1){
        if (!isset($_SESSION['carrinho'][$id])) {
            $arrayproduto = [
                'nome' => $nome,
                'tipoproduto' => $tipoproduto,
                'categoria' => $categoria,
                'preco' => $preco,
                'imgpath' => $imgpath,
                'parcelas' => $parcelas,
                'qnt' => $qnt
            ];
        
            $_SESSION['carrinho'][$id] = $arrayproduto;
        
        } else {
            $_SESSION['carrinho'][$id]['qnt'] += $qnt;
        }
    }
    
    echo '<pre>';
    print_r($_SESSION['carrinho']);
    echo '</pre>';
    header("Location:../site/home.php");
}else{
    header("Location:../site/login.php");
}
?>