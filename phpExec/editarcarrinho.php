<?php
function editarcarrinho(){
    foreach ($_SESSION['carrinho'] as $keyitem => $item){
        if(isset($_POST['qnt'.$keyitem])){
            if ($_POST['qnt'.$keyitem] >= 1){
                $_SESSION['carrinho'][$keyitem]['qnt'] = htmlspecialchars($_POST['qnt'.$keyitem]);
            }elseif ($_POST['qnt'.$keyitem]==0){
                unset($_SESSION['carrinho'][$keyitem]);
            }else{
                return [false,'Falha ao atualizar o carrinho'];
            }
        }
    }
    return [true,'Carrinho atualizado com sucesso!'];
}