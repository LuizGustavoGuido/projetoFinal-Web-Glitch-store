<?php
//Header da página caso o usuário esteja logado
echo '<header>
        <div class="navbar">
            <div class="logo">GLITCH Store</div>
                <a href="user.php"><h1>Olá, '. $_SESSION['name'] .'!</h1></a>
                <nav>
                    <a href="../site/produtos.php">Produtos</a>
                    <a href="../site/suporte.php">Suporte</a>
                    <a href="../phpExec/deslogar.php">Sair</a>
                    <a href="../site/carrinho.php">
                    <div class="cart">CARRINHO</div>
                    </a>
                </nav>
        </div>
    </header>'
?>