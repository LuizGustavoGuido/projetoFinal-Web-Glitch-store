<?php
session_start();
if (!isset($_SESSION['usercod'])){
    header("Location:../site/login.php");
}
if ($_SERVER['REQUEST_METHOD']== 'POST'){
    if (isset($_POST['atualizar'])){
        require '../phpExec/editarcarrinho.php';
        editarcarrinho();
    }
    if (isset($_POST['finalizar'])){
        require '../phpExec/adicionarpedido.php';
        $cep = $_POST['cepDestino'];
        $metodoPagamento = $_POST['metodoPagamento'];
        adicionarpedido($cep, $metodoPagamento);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="stylesheet" href="../CSS/style_carrinho.css?v=2">
    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
</head>
<body>
    <div id="particles-js"></div>
    <?php
        if (isset($_SESSION['usercod'])){
            include '../phpInclude/headerlogado.php';
        }else{
            include '../phpInclude/header.php';
        }
        ?>
<?php
if (isset($_SESSION['carrinho']) && sizeof($_SESSION['carrinho']) > 0){
    echo   '<div class="grid">
                <div class="container">
                    <form method="POST" action="">';
                    $precototal = 0;
                    foreach ($_SESSION['carrinho'] as $keyitem => $item){
                        $precototal += $item['preco'] * $item['qnt'];
                        echo '
                        <div class="product-info">
                            <img src="'.$item['imgpath'].'" alt="Imagem do Produto">
                            <div class="product-details">
                                <h3>'.$item['nome'].'</h3>
                                <p>'.$item['tipoproduto'].'</p>
                                <p><strong>'.$item['preco'].'</strong></p>
                                <p id="qntatual'.$keyitem.'">Quantidade atual: '.$item['qnt'].'</p>
                                <button id="editarbotao'.$keyitem.'" type="button" onclick="editar(document.getElementById(\'editardiv'.$keyitem.'\'), document.getElementById(\'editarbotao'.$keyitem.'\'), document.getElementById(\'atualizar\'))">Editar</button>
                            </div>
                            <div id="editardiv'.$keyitem.'" class="invisible">
                                <button type="button" onclick="ajustarqnt(document.getElementById(\'qnt'.$keyitem.'\'), 0)">-</button>
                                <input id="qnt'.$keyitem.'" name="qnt'.$keyitem.'" type="text" value="'.$item['qnt'].'" min="0" pattern="[0-9]{1,}">
                                <button type="button" onclick="ajustarqnt(document.getElementById(\'qnt'.$keyitem.'\'), 1)">+</button>
                            </div>
                        </div>';
                    }
                    echo '
                    <button id="atualizar" name="atualizar" class="invisible" type="submit">Atualizar carrinho</button>
                    </form>
                    <h2>Cálculo de Frete</h2>
                    <form method="POST" action="">
                        <input type="hidden" name="metodoPagamento" id="metodoPagamento" value="">
                        <div class="form-group">
                            <label for="cepDestino">Insira seu CEP:</label>
                            <input type="text" name="cepDestino" id="cepDestino" placeholder="00000-000" pattern="[0-9]{5}-[0-9]{3}" required>
                            <button class="button" onclick="calcularFrete()">Calcular Frete</button>
                        </div>

                        <h2>Escolha o Método de Pagamento</h2>
                        <div class="payment-methods">
                            <div class="payment-method" onclick="selecionarPagamento(\'credito\')" id="credito">Crédito</div>
                            <div class="payment-method" onclick="selecionarPagamento(\'debito\')" id="debito">Débito</div>
                            <div class="payment-method" onclick="selecionarPagamento(\'pix\')" id="pix">Pix</div>
                        </div>

                        <div id="cartao-info" class="hidden">
                            <div class="form-group">
                                <label for="numero-cartao">Número do Cartão:</label>
                                <input type="text" name="numcartao" id="numero-cartao">
                            </div>
                            <div class="form-group">
                                <label for="cvv">Código de Segurança (CVV):</label>
                                <input type="number" name="CVV" id="cvv" max="999" placeholder="123">
                            </div>
                            <div class="form-group">
                                <label for="validade">Data de Validade:</label>
                                <input type="text" name="cartaovalid" id="validade" placeholder="MM/AA">
                            </div>
                        </div><button class="button" name="finalizar" type="submit">Finalizar Compra</button>  
                    </form>
                    
                </div>
            
                    <div class="container small-container">
                        <div class="summary">
                            <h3>Resumo do Pedido</h3>
                            <p>Itens: <strong>R$'.$precototal.'</strong></p>
                            <p>Frete e Manuseio: <strong id="frete">R$ 0,00</strong></p>
                            <div class="total">
                                Total do Pedido: <strong id="total">R$ '.$precototal.'</strong>
                            </div>
                            <p>Em até 10x de R$ '.sprintf("%.2f", $precototal/10).' sem juros</p>
                        </div>
                        <div class="divider"></div>
                    </div>
            </div>';
}?>
    <?php include '../phpInclude/footer.php'; ?>
    <script src="../JS/funcionalides.js?v=3"></script>
    <script>
        /*Funcionalidades para o Carrinho*/

        window.calcularFrete = function calcularFrete() {
        const cepDestino = document.getElementById('cepDestino').value;
        const peso = 0.8;

        if (!cepDestino) {
            alert("Por favor, insira um CEP válido.");
            return;
        }

        let precoFrete = 0;

        if (cepDestino.startsWith("1")) {
            precoFrete = peso * 5;
        } else if (cepDestino.startsWith("2")) {
            precoFrete = peso * 7;
        } else {
            precoFrete = peso * 10;
        }

        // Atualiza o valor do frete no resumo do pedido
        document.getElementById('frete').textContent = `R$ ${precoFrete.toFixed(2)}`;

        // Atualiza o total do pedido
        const precoItens = <?php printf("%.2f", $precototal) ?>;
        const total = precoItens + precoFrete;
        document.getElementById('total').textContent = `R$ ${total.toFixed(2)}`;
        };

        function selecionarPagamento(metodo) {
        const metodos = ['credito', 'debito', 'pix'];
        metodos.forEach(m => {
            document.getElementById(m).classList.remove('selected');
        });

        document.getElementById(metodo).classList.add('selected');

        const cartaoInfo = document.getElementById('cartao-info');
        if (metodo === 'credito' || metodo === 'debito') {
            cartaoInfo.classList.remove('hidden');
        } else {
            cartaoInfo.classList.add('hidden');
        }

        // Atualiza o campo oculto com o método de pagamento selecionado
        document.getElementById('metodoPagamento').value = metodo;
        }

        particlesJS('particles-js', {
            particles: {
            number: { value: 100 },
            size: { value: 3 },
            move: { speed: 2 }
            },
            interactivity: {
            events: {
                onhover: { enable: true, mode: 'repulse' }
            }
            }
        });
    </script>
</body>
</html>
