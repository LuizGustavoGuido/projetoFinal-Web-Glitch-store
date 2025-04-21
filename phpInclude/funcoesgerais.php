<?php
//Funções que serão utilizadas em mais de um arquivo
function filtrarInput($connection, $input){
    $input = mysqli_real_escape_string($connection, htmlspecialchars($input));
    return $input;
}
?>