<?php 

require '../phpInclude/dbinfo.php';
require '../phpInclude/funcoesgerais.php';

// Verifica se o e-mail já existe no banco de dados
function checarEmail($connection, $email){
    $stmt = mysqli_prepare($connection, 'SELECT * FROM users WHERE email = ?');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    mysqli_stmt_close($stmt);

    if (mysqli_num_rows($result) > 0){
        mysqli_close($connection);
        return[false, 'Este e-mail já está cadastrado'];
    }
    return [true];
}

function cadastrarUsuario(){
    global $dbhost; global $dbuser; global $dbpsswd; global $dbname;

    // Conexão com o banco de dados
    $connection = mysqli_connect($dbhost, $dbuser, $dbpsswd, $dbname) 
    or die('Não foi possível conectar-se, tente mais tarde' . mysqli_connect_error());

    // Atribuição das variáveis com valores do formulário POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = filtrarInput($connection, $_POST['username']);
        $email = filtrarInput($connection, $_POST['email']);
        $psswd = filtrarInput($connection, $_POST['psswd']);
        if ($username == 'admin' || $username == 'administrador'){
            return[false,'Nome de usuário inválido'];
        }
    }else{
        return[false,'Não requisitado'];
    }

    $exeEmail = checarEmail($connection, $email);
    if ($exeEmail[0]){
        // Se não houver conflito de e-mail, faz o hash da senha
        $psswd = password_hash($psswd, PASSWORD_DEFAULT);

        // Prepara o statement SQL para inserir o usuário no banco de dados
        $stmt = mysqli_prepare($connection, 'INSERT INTO users (username, email, psswd) VALUES (?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $psswd);

        // Executa a inserção e verifica se deu tudo certo
        $exeStmt = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
        if ($exeStmt){
            return [true,'Usuário cadastrado com sucesso!'];
        }else{
            return[false,'Não foi possível cadastrar o usuário: ' . mysqli_error($connection)];
        }
    }else{
        return [false, $exeEmail[1]];
    }
}
?>