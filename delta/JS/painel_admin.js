// Deixar a opção selecionada pelo click

var menu_item = document.querySelectorAll('.menu_item') // irá pegar todos que tiverem a class item menu e transformalas em um variavel
function selectItem () {
	menu_item.forEach((item) => 
item.classList.remove('ativo')); // irá remover a classe 'ativo'

this.classList.add('ativo'); // irá adcionar a classe ativo
}

menu_item.forEach ((item) => 
item.addEventListener('click', selectItem));


// sair e excluir o historico 
function sair() {
  // Adicionar um novo estado ao histórico
  history.pushState(null, null, window.location.href);

  // Substituir o estado atual com o novo estado
  history.replaceState(null, null, './login.php');

  // Redirecionar para a página de login
  window.location.replace('./login.php');
}

// Adicionar um evento 'popstate' para lidar com o botão "voltar" do navegador
window.addEventListener('popstate', function(event) {
  window.location.replace('./login.php');
});


