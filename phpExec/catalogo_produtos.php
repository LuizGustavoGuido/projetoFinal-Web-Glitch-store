<?php
require '../phpInclude/dbinfo.php';

const debugBol = False;
const linhasporPag = 6; // Linhas de produtos por página
const itemsporLinha = 3; //Produtos por linha duh

function gerarPagina($pagina, $categoria, $filtro){
  global $dbhost; global $dbuser; global $dbpsswd; global $dbname;

  //Cria os botões de página de produtos
  function criarBotoes($pagina, $totalpaginas){
    $i = $pagina;
    $maxbotoes = $i+6;
    echo '<div>
    <form action="">';
    echo '<button name="pagina" value="1"><<</button>';
    if ($i > 3){
      echo '<button name="pagina" value="'. $i-3 .'">'. $i-3 .'</button>';
    }
    if ($i > 2){
      echo '<button name="pagina" value="'. $i-2 .'">'. $i-2 .'</button>';
    }
    if ($i > 1){
      echo '<button name="pagina" value="'. $i-1 .'">'. $i-1 .'</button>';
    }
    while ($i <= $maxbotoes && $i <= $totalpaginas){
      echo '<button name="pagina" value="'. $i .'">'. $i .'</button>';
      if ($i+1 > $maxbotoes && $i != $totalpaginas){
        echo '...';
      }
      $i++;
    }
    echo '<button name="pagina" value="'. $totalpaginas .'">>></button>';
    echo '</form>
  </div>';
  }
  
  // Conexão com o banco de dados
  $connection = mysqli_connect($dbhost, $dbuser, $dbpsswd, $dbname) 
  or die('Não foi possível conectar-se, tente mais tarde' . mysqli_connect_error());

  //Prepara o query:
  $query = 'SELECT * FROM item';

  //Se o usuário tiver feito alguma pesquisa de categoria ou filtro
  if ($categoria != "" AND $filtro != ""){
    $query = $query . ' WHERE categoria = ?';
    $filtro = "%" . $filtro . "%";
    $query = $query . ' AND (nome LIKE ? or descricao LIKE ? or tipoproduto LIKE ?)';
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'ssss', $categoria, $filtro, $filtro, $filtro);

  //Se o usuário fez apenas uma pesquisa de categoria
  }elseif($categoria != ""){
    $query = $query . ' WHERE categoria = ?';
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 's', $categoria);

  //Se o usuário fez apenas uma pesquisa de filtro
  }elseif($filtro != ""){
    $filtro = "%" . $filtro . "%";
    $query = $query . ' WHERE nome LIKE ? or descricao LIKE ? or tipoproduto LIKE ?';
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $filtro, $filtro, $filtro);

  //Se ele não fez pesquisa de filtro nem de categoria
  }else{
    $stmt = mysqli_prepare($connection, $query);
  }

  mysqli_stmt_execute($stmt) //Executar query
  or die('Erro na consulta' . mysqli_connect_error()); //Erro na execução

  //DEBUG MODE
  if (debugBol){
    echo $query;
    echo $categoria;
    echo $filtro;
    echo (int) $filtro;
    if (is_numeric((int) $filtro) == false){
      echo 'False';
    }else{
      echo 'True';
    }
  }

  $result = mysqli_stmt_get_result($stmt); // Resultado mysqli object da tabela selecionada 
  $numitems = mysqli_num_rows($result); // Número de tuplas
  $arrayresult = mysqli_fetch_all($result, MYSQLI_BOTH); //Array da tabela selecionada
  $totalpaginas = ceil($numitems/linhasporPag/itemsporLinha);
  $indexInic = ($pagina-1) * linhasporPag * itemsporLinha; //Index do primeiro item que aparecerá na página

  $iLinha = 0;
  $iTotal = $indexInic;
  echo '<section class="products">';

  //Enquanto o número de linhas geradas for menor que 6 AND total de produtos gerados for menor que o número de tuplas
  while ($iLinha<linhasporPag && $iTotal<$numitems){
    echo '<div class="product-grid" data-aos="fade-up">';

    $iProduto = 0;
    //Enquanto o número de produtos gerados for menor que 3 AND total de produtos gerados for menor que o número de tuplas
    while ($iProduto<itemsporLinha && $iTotal<$numitems){
      //Gerar produto
      echo '<form method="POST" action="exibicao-produto.php">
              <button class="product-link" type="submit">
                  <div class="product">
                      <img src="'. $arrayresult[$iTotal]['imgpath'] .'" alt="'. $arrayresult[$iTotal]['nome'] .'">
                      <div class="product-info">
                          <div class="product-subtitle">'. $arrayresult[$iTotal]["tipoproduto"] .'</div>
                          <div class="product-title">'. $arrayresult[$iTotal]["nome"] .'</div>
                          <div class="product-price">R$'. $arrayresult[$iTotal]["preco"] .'</div>
                      </div>
                  </div>
              </button>
              
              <!-- Campos ocultos para enviar informações -->
              <input type="hidden" name="id" value="'. $arrayresult[$iTotal]['id'] .'">
              <input type="hidden" name="nome" value="'. $arrayresult[$iTotal]['nome'] .'">
              <input type="hidden" name="tipoproduto" value="'. $arrayresult[$iTotal]['tipoproduto'] .'">
              <input type="hidden" name="categoria" value="'. $arrayresult[$iTotal]['categoria'] .'">
              <input type="hidden" name="descricao" value="'. $arrayresult[$iTotal]['descricao'] .'">
              <input type="hidden" name="preco" value="'. $arrayresult[$iTotal]['preco'] .'">
              <input type="hidden" name="imgpath" value="'. $arrayresult[$iTotal]['imgpath'] .'">
              <input type="hidden" name="parcelas" value="'. $arrayresult[$iTotal]['parcelas'] .'">
          </form>';
      $iProduto++;
      $iTotal++;
    }
    $iLinha++;

    echo '</div>';
  }

  criarBotoes($pagina, $totalpaginas);
  mysqli_close($connection);
  
echo '</section>';
}
?>