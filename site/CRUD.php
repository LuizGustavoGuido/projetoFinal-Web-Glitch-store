<?php
//Antes de carregar a página
session_start();
if (!isset($_SESSION['usercod']) || $_SESSION['usercod'] != 1){
    header("Location: home.php");
    exit();
}

require '../phpExec/CRUD_control.php';

$exibirTabela = false;

//Se ao carregar a página, algum formulário tiver sido enviado a ela
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Se o formulário enviado for de inserção
    if (isset($_POST['inserir'])){
        // Atribuição das variáveis com valores do formulário POST
        $nome = $_POST['nome'];
        $tipoproduto = $_POST['tipoproduto'];
        $descricao = $_POST['descricao'];
        $categoria = $_POST['categoria'];
        $preco = $_POST['preco'];
        $img = $_FILES['img'];
        inserirprodutoBD($nome, $tipoproduto, $descricao, $categoria, $preco, $img);

    //Se o formulário enviado for de pesquisa
    }if (isset($_POST['pesquisar'])){
        // Atribuição das variáveis com valores do formulário POST
        $table = $_POST['searchtable'];
        if (isset($_POST['searchattrib'],$_POST['searchoperator']) && $_POST['search'] != ""){
            $attrib = $_POST['searchattrib'];
            $operator = $_POST['searchoperator'];
            $search = $_POST['search'];
            if (debugBol){
                echo 'PÁGINA SELECT DEBUG:';
                echo $attrib . '<br>';
                echo $operator . '<br>';
                echo $search . '<br>';
            }
            $functionresult = pesquisarBD($table, $attrib, $operator, $search); //Resultado array da função
        }else{
            $functionresult = pesquisarBD($table); //Resultado array da função
        }
        $fields = $functionresult[0]; //Atributos da tabela em mysqli object
        $result = $functionresult[1]; //Resultado de registros da consulta em mysqli object
        $numfields = mysqli_num_rows($fields); //Número de atributos da tabela
        $numtuplas = mysqli_num_rows($result); //Número de tuplas do resultado
        $arrayresult = mysqli_fetch_all($result, MYSQLI_BOTH); //Resultado de registros da consulta em array
        $arrayfields = mysqli_fetch_all($fields, MYSQLI_BOTH); //Atributos da tabela em array
        $exibirTabela = true; //Utilizado mais à frente na página

    //Se o formulário enviado for de atualização
    }if (isset($_POST['atualizar'])){
        // Atribuição das variáveis com valores do formulário POST
        $table = $_POST['updtable']; //Tabela inserida
        $attrib = $_POST['updattrib']; //Atributo que deseja-se mudar
        $input = $_POST['input']; //Para qual valor deseja-se mudar o atributo

        /* Qual registro deve ser atualizado */
        $whereattrib = $_POST['updwhereattrib']; //Atributo de pesquisa
        $whereoperator = $_POST['updwhereoperator']; //Operador
        $search = $_POST['search']; //Input do usuário
        if (debugBol){
            echo 'PÁGINA UPDATE DEBUG:' . '<br>';
            echo $table . '<br>';
            echo $attrib . '<br>';
            echo $input . '<br>';
            echo $whereattrib . '<br>';
            echo $whereoperator . '<br>';
            echo $search . '<br>';
        }
        atualizarBD($table, $attrib, $input, $whereattrib, $whereoperator, $search);
    //Se o formulário enviado for de remoção
    }if (isset($_POST['remover'])){
        // Atribuição das variáveis com valores do formulário POST
        $table = $_POST['deltable'];
        $attrib = $_POST['delattrib'];
        $operator = $_POST['deloperator'];
        $search = $_POST['delsearch'];
        if (debugBol){
            echo 'PÁGINA DELETE DEBUG:' . '<br>';
            echo $table . '<br>';
            echo $attrib . '<br>';
            echo $operator . '<br>';
            echo $search . '<br>';
        }
        removerBD($table, $attrib, $operator, $search);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="../CSS/style_CRUD.css?v=2">
    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
    <script src="../JS/CRUDControl.js"></script>
</head>
<body>
    <div id="particles-js"></div>
    <?php include '../phpInclude/headerlogado.php';?>
    <section>
        <!-- Botões que visibilizam o form selecionado e escondem os outros-->
        <button onclick="esconderOutrosForm(document.getElementById('inserirForm'))">Inserir dados</button>
        <button onclick="esconderOutrosForm(document.getElementById('pesquisarForm'))">Pesquisar dados</button>
        <button onclick="esconderOutrosForm(document.getElementById('atualizarForm'))">Atualizar dados</button>
        <button onclick="esconderOutrosForm(document.getElementById('removerForm'))">Remover dados</button>
        <div id="divForms">
            <!-- Formulário de inserção de produto -->
            <form class="visible" id="inserirForm" name="inserirForm" enctype="multipart/form-data" method="POST" action="">
                <fieldset>
                    <label>Nome: </label><input type="text" name="nome" required><br><br>
                    <label>Tipo do produto: </label><input type="text" name="tipoproduto" required><br><br>
                    <label>Preço: </label><input type="number" name="preco" step="0.01" min="0" required><br><br>
                    <label>Categoria: </label><select name="categoria" required>
                        <option value="computador">Computador Montado</option>
                        <option value="hardware">Hardware</option>
                        <option value="periferico">Periférico</option>
                    </select><br><br>
                    <label>Descrição: </label><br>
                    <textarea name="descricao" rows="4" cols="50" required></textarea><br><br>
                    <label>Imagem: </label><input type="file" name="img" required><br><br>
                    <input type="submit" name="inserir" value="Inserir">
                </fieldset>
            </form>
            <!-- Formulário de pesquisa de registros -->
            <form class="invisible" id="pesquisarForm" name="pesquisarForm" method="POST" action="">
                <fieldset>
                    <label>Selecionar registros da tabela: </label>
                    <select id="searchtable" name="searchtable" oninput="updateAttributes(document.getElementById('searchtable'), document.getElementById('searchattrib'))" required>
                        <option value="users">Usuários</option>
                        <option value="item">Produtos</option>
                        <option value="pedido">Pedidos</option>
                        <option value="pedidoitem">Pedidos de itens</option>
                    </select>
                    <label>Onde: </label>
                    <select id="searchattrib" name="searchattrib" oninput="updateOperators(document.getElementById('searchattrib'), document.getElementById('searchoperator'))">
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                    <select id="searchoperator" name="searchoperator">
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                    <input type="text" id="searchbar" name="search" placeholder="(Opcional) Caracter/Numérico"><br><br>
                    <input type="submit" name="pesquisar" value="Pesquisar">
                </fieldset>
            </form>
            <!-- Formulário de atualização de registros -->
            <form class="invisible" id="atualizarForm" name="atualizarForm" enctype="multipart/form-data" method="POST" action="">
                <fieldset>
                <label>Atualizar registros da tabela: </label>
                    <select id="updtable" name="updtable" required oninput="updateAttributes(document.getElementById('updtable'), document.getElementById('updattrib'))">
                        <option value="users">Usuários</option>
                        <option value="item">Produtos</option>
                        <option value="pedido">Pedidos</option>
                        <option value="pedidoitem">Pedidos de itens</option>
                    </select>
                    <label>Para: </label>
                    <select id="updattrib" name="updattrib" required>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                    <p>=</p>
                    <input type="text" id="inputbar" name="input" placeholder="Caracter/Numérico" required oninput="updateAttributes(document.getElementById('updtable'), document.getElementById('updwhereattrib'))">
                    <label>Onde: </label>
                    <select id="updwhereattrib" name="updwhereattrib" required oninput="updateOperators(document.getElementById('updwhereattrib'), document.getElementById('updwhereoperator'))">
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                    <select id="updwhereoperator" name="updwhereoperator" required>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                    <input type="text" id="searchbar" name="search" placeholder="Caracter/Numérico" required><br><br>
                    <input type="submit" name="atualizar" value="Atualizar">
                </fieldset>
            </form>
            <!-- Formulário de remoção de registros -->
            <form class="invisible" id="removerForm" name="removerForm" method="POST" action="">
                <fieldset>
                    <label>Remover registros da tabela: </label>
                    <select id="deltable" name="deltable" required oninput="updateAttributes(document.getElementById('deltable'), document.getElementById('delattrib'))" required>
                        <option value="users">Usuários</option>
                        <option value="item">Produtos</option>
                        <option value="pedido">Pedidos</option>
                        <option value="pedidoitem">Pedidos de itens</option>
                    </select>
                    <label>Onde: </label>
                    <select id="delattrib" name="delattrib" required oninput="updateOperators(document.getElementById('delattrib'), document.getElementById('deloperator'))">
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                    <select id="deloperator" required name="deloperator">
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                    <input type="text" id="searchbar" required name="delsearch" placeholder="Caracter/Numérico"><br><br>
                    <input type="submit" name="remover" value="Remover">
                </fieldset>
            </form>
        </div>
        <?php
        if ($exibirTabela){
            echo '<table class="tabela">';
            //Enquanto a linha gerada for menor que o número de tuplas + a linha de nome dos atributos
            for ($iLinha = 0; $iLinha <= $numtuplas; $iLinha++){
                echo '<tr class="celula">';
                //Enquanto coluna gerada for menor que número de atributos
                for ($jColuna = 0; $jColuna < $numfields; $jColuna++){
                    //Se for a primeira linha, gerar nome dos atributos
                    if ($iLinha == 0){
                        //$jColuna indica o atributo a ser carregado, o índice 0 indica seu nome
                        echo '<th class="cabeçalho">'. $arrayfields[$jColuna][0] .'</th>';
                    //Senão, gerar os registros de cada atributo
                    }else{
                        //$iLinha-1 indica a tupla a ser carregada, e $jColuna o registro do atributo
                        echo '<td class="celula">'. $arrayresult[$iLinha-1][$jColuna] .'</td>';
                    }
                }
                echo '</tr>';
            }
            echo '</table>';
        }
        ?>
    </section>
    <?php include '../phpInclude/footer.php'; ?>
    <script src="../JS/funcionalides.js"></script>
</body>
</html>