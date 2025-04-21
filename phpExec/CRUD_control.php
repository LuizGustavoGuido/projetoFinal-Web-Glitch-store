<?php
require '../phpInclude/dbinfo.php';
require '../phpInclude/funcoesgerais.php';

const debugBol = false; //DEBUG MODE

function pesquisarBD($table, $attrib = null , $operator = null, $search = null){
    global $dbhost; global $dbuser; global $dbpsswd; global $dbname;
    if (debugBol){
        echo 'FUNCTION SELECT DEBUG:' . '<br>';
        echo $attrib . '<br>';
        echo $operator . '<br>';
        echo $search . '<br>';
    }
    // Conexão com o banco de dados
    $connection = mysqli_connect($dbhost, $dbuser, $dbpsswd, $dbname) 
    or die('Não foi possível conectar-se, tente mais tarde' . mysqli_connect_error());

    if (isset($attrib, $operator, $search)){
        $query = 'select * from '. $table .' where '. $attrib .' '. $operator . ' ?';
        if (is_numeric($search)){
            $search = (int) $search;
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'i', $search);
        }else
            if ($operator == 'like'){
                $search = '%' . $search . '%';
            }
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 's', $search);
    }else{
        $query = 'select * from '. $table;
        $stmt = mysqli_prepare($connection, $query);
    }

    $exeSucess = mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $queryfields = 'show fields from ' . $table;
    $stmt = mysqli_prepare($connection, $queryfields);
    $fieldExeSucess = mysqli_stmt_execute($stmt);
    $fields = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0){
        mysqli_close($connection);
        return [$fields, $result];
    }else{
        mysqli_close($connection);
        return [$fields, $result]; 
    }
}

function atualizarBD($table, $attrib, $input, $whereattrib, $whereoperator, $search){
    global $dbhost; global $dbuser; global $dbpsswd; global $dbname;

    if (debugBol){
        echo 'FUNCTION UPDATE DEBUG:' . '<br>';
        echo $attrib . '<br>';
        echo $whereoperator . '<br>';
        echo $search . '<br>';
    }

    // Conexão com o banco de dados
    $connection = mysqli_connect($dbhost, $dbuser, $dbpsswd, $dbname) 
    or die('Não foi possível conectar-se, tente mais tarde' . mysqli_connect_error());

    $query = 'update '. $table . ' set '. $attrib .'='. $input .' where '. $whereattrib .' '. $whereoperator .' ?';
    if (is_numeric($search)){
        $search = (double) $search;
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'd', $search);
    }else
        if ($whereoperator == 'like'){
            $search = '%' . $search . '%';
        }
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 's', $search);

    $exeSucess = mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($exeSucess){
        mysqli_close($connection);
        return true;
    }else{
        mysqli_close($connection);
        return false;
    }
}

function inserirprodutoBD($nome, $tipoproduto, $descricao, $categoria, $preco, $img){
    global $dbhost; global $dbuser; global $dbpsswd; global $dbname;

    //Verifica se o formato do arquivo enviado é valido e o armazena na pasta apropriada
    function validarArquivoImg($imgfile, $nameprefix){

        $imgclientpath = $imgfile['name']; //Caminho e nome do arquivo enviado pelo cliente
        $imgtempserverpath = $imgfile['tmp_name']; //Caminho e nome do arquivo em pasta temporária do servidor
        $imgserverpath = '../videos-imagens/'; //Caminho do arquivo até a pasta definitiva de armazenamento
        $imgname = uniqid($nameprefix); //Novo nome único para o arquivo
        $extensao = strtolower(pathinfo($imgclientpath, PATHINFO_EXTENSION)); //Extensão do arquivo

        if ($extensao != 'png' && $extensao != 'jpg'){
            die('Formato de arquivo inválido');
        }
        $imgserverpath = $imgserverpath . $imgname . "." . $extensao;
        move_uploaded_file($imgtempserverpath, $imgserverpath);
        return $imgserverpath;
    }

    if ($img['error']){
        die('Falha no envio do arquivo, tente novamente');
    }

    // Conexão com o banco de dados
    $connection = mysqli_connect($dbhost, $dbuser, $dbpsswd, $dbname) 
    or die('Não foi possível conectar-se, tente mais tarde' . mysqli_connect_error());

    // Atribuição das variáveis pós filtro do parâmetro
    $nome = filtrarInput($connection, $nome);
    $tipoproduto = filtrarInput($connection, $tipoproduto);
    $descricao = filtrarInput($connection, $descricao);
    $categoria = filtrarInput($connection, $categoria);
    $preco = filtrarInput($connection, $preco);

    $imgpath = validarArquivoImg($img, $tipoproduto); //Retorna o caminho do arquivo armazenado

    $query = 'Insert into item (nome,tipoproduto,descricao,categoria,preco,imgpath) values (?,?,?,?,?,?)';
    $stmt = mysqli_prepare($connection, $query);

    $bindSucess = mysqli_stmt_bind_param($stmt, 'ssssds', $nome, $tipoproduto, $descricao, $categoria, $preco, $imgpath);

    $exeSucess = mysqli_stmt_execute($stmt); //Executa o query

    if ($exeSucess){
        mysqli_close($connection);
        return true;
    }else{
        mysqli_close($connection);
        return false;
    }
}

function removerBD($table, $attrib, $operator, $search){
    global $dbhost; global $dbuser; global $dbpsswd; global $dbname;

    if (debugBol){
        echo 'FUNCTION REMOVE DEBUG:' . '<br>';
        echo $attrib . '<br>';
        echo $operator . '<br>';
        echo $search . '<br>';
    }

    // Conexão com o banco de dados
    $connection = mysqli_connect($dbhost, $dbuser, $dbpsswd, $dbname) 
    or die('Não foi possível conectar-se, tente mais tarde' . mysqli_connect_error());

    $query = 'delete from '. $table .' where '. $attrib .' '. $operator .' ?';
    if (is_numeric($search)){
        $search = (double) $search;
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 'd', $search);
    }else
        if ($operator == 'like'){
            $search = '%' . $search . '%';
        }
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, 's', $search);

    $exeSucess = mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($exeSucess){
        mysqli_close($connection);
        return true;
    }else{
        mysqli_close($connection);
        return false;
    }
}
?>