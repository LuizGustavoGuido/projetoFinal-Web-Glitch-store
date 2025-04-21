<?php
require '../phpInclude/dbinfo.php';
require '../phpInclude/funcoesgerais.php';

function atualizarUser(){
    global $dbhost; global $dbuser; global $dbpsswd; global $dbname;

    // Conexão com o banco de dados
    $connection = mysqli_connect($dbhost, $dbuser, $dbpsswd, $dbname) 
    or die('Não foi possível conectar-se, tente mais tarde' . mysqli_connect_error());

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_SESSION['usercod'];
        if (isset($_POST['update_info'])) {
            $username = filtrarInput($connection, $_POST['username']);
            $email = filtrarInput($connection, $_POST['email']);

            $updateQuery = 'UPDATE users SET username = ?, email = ? WHERE cod = ?';
            $stmt = mysqli_prepare($connection, $updateQuery);
            mysqli_stmt_bind_param($stmt, 'ssi', $username, $email, $id);
            $exeUpdate = mysqli_stmt_execute($stmt);
            if ($exeUpdate) {
                $_SESSION['name'] = $username;
                $_SESSION['email'] = $email;
                return [true, 'Informações atualizadas com sucesso!'];
            } else {
                return [false, 'Erro ao atualizar'];
            }
        }

        if (isset($_POST['change_password'])) {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            $queryGetPassword = 'SELECT psswd FROM users WHERE cod = ?';
            $stmt = mysqli_prepare($connection, $queryGetPassword);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $user = mysqli_fetch_assoc($result);
                if (password_verify($currentPassword, $user['psswd'])) {
                    if ($newPassword === $confirmPassword) {
                        $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $sqlUpdatePassword = 'UPDATE users SET psswd = ? WHERE cod = ?';
                        $stmt = mysqli_prepare($connection, $sqlUpdatePassword);
                        mysqli_stmt_bind_param($stmt, 'si', $hashPassword, $id);
                        $exe = mysqli_stmt_execute($stmt);

                        if ($exe){
                            return [true, 'Senha alterada com sucesso!'];
                        } else {
                            return[false, 'Erro ao alterar a senha: ' . $connection->error];
                        }
                    } else {
                        return [false, 'As novas senhas não coincidem'];
                    }
                } else {
                    return [false, 'Senha atual incorreta'];
                }
            } elseif (mysqli_num_rows($result) > 1) {
                return [false, 'Redundância encontrada'];
            } else{
                return [false, 'Erro ao verificar a senha atual'];
            }
        }
    }
}
?>