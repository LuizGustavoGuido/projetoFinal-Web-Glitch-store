window.calcularFrete = function calcularFrete() {
  // Obtendo os valores dos campos
  const cepDestino = document.getElementById('cepDestino').value;
  const peso = 0.8;

  // Verificando se os campos estão preenchidos
  if (!cepDestino || isNaN(peso)) {
    alert("Por favor, preencha todos os campos corretamente.");
    return;
  }

  // Simulação de cálculo de frete baseado em peso e faixa de CEP
  let precoFrete = 0;

  if (cepDestino.startsWith("1")) {
    precoFrete = peso * 5; // Exemplo: R$5 por kg para região "1"
  } else if (cepDestino.startsWith("2")) {
    precoFrete = peso * 7; // Exemplo: R$7 por kg para região "2"
  } else {
    precoFrete = peso * 10; // Exemplo: R$10 por kg para outras regiões
  }

  // Exibindo o resultado
  const resultadoDiv = document.getElementById('resultado');
  resultadoDiv.innerHTML = `
    <p><strong>CEP de Destino:</strong> ${cepDestino}</p>
    <p><strong>Preço do Frete:</strong> R$ ${precoFrete.toFixed(2)}</p>
  `;
};
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

AOS.init({
    duration: 1000,
    easing: 'ease-in-out', 
    once: true, 
});

/*Funcionalidades para o Carrinho*/

window.calcularFrete = function calcularFrete1() {
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
  const precoItens = 999.99; // Valor fixo do exemplo
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
}
function ajustarqnt(elemento, operador){
  console.log(elemento);
  console.log(operador);
  if (operador == 1){
    elemento.value = parseInt(elemento.value) + 1;
  } else if (operador == 0 && elemento.value > 0){
    elemento.value = parseInt(elemento.value) - 1;
  }
}
function editar(div,botao,submit){
  div.classList.remove('invisible');
  botao.classList.add('invisible');
  submit.classList.remove('invisible');
}