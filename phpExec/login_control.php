<?php

require '../phpInclude/dbinfo.php';
require '../phpInclude/funcoesgerais.php';

/*
function filtrarInput($connection, $username, $email, $psswd){

    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    return [$username, $email, $psswd];
}
*/

function logarUsuario(){
    global $dbhost; global $dbuser; global $dbpsswd; global $dbname;

    // Conexão com o banco de dados
    $connection = mysqli_connect($dbhost, $dbuser, $dbpsswd, $dbname) 
    or die('Não foi possível conectar-se, tente mais tarde' . mysqli_connect_error());

    // Atribuição e filtro das variáveis com valores do formulário POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = filtrarInput($connection, $_POST['username']);
        $email = filtrarInput($connection, $_POST['email']);
        $psswd = filtrarInput($connection, $_POST['psswd']);
    }

    // Prepara o statement SQL e executa
    $stmt = mysqli_prepare($connection, 'SELECT * FROM users WHERE username = ? and email = ?');
    mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
    $exeSucess = mysqli_stmt_execute($stmt);

    // Se a consulta executar corretamente
    if ($exeSucess){
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($connection);

        // Se a consulta encontrar apenas 1 usuário
        if (mysqli_num_rows($result) == 1){

            $user = mysqli_fetch_assoc($result);
            if (password_verify($psswd, $user['psswd'])){              
                session_start();
                $_SESSION['usercod'] = $user['cod'];
                $_SESSION['name'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                return [true,'Logado com sucesso!'];
            }else{
                return [false,'Senha incorreta'];
            }

        // Se a consulta não encontrar nada
        }elseif (mysqli_num_rows($result) < 1){
            return [false,'Este usuário não existe'];

        // Se de alguma forma encontrar dois usuários??
        }elseif (mysqli_num_rows($result) > 1){
            return [false,'Redundância encontrada?'];
        }
    
    // Senão
    }else{
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
        return [false,'Erro de execução'];
    }
}
?>