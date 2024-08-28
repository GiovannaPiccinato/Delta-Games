// Deixar a opção selecionada pelo click

var menu_item = document.querySelectorAll('.menu_item') // irá pegar todos que tiverem a class item menu e transformalas em um variavel
function selectItem () {
	menu_item.forEach((item) => 
item.classList.remove('ativo')); // irá remover a classe 'ativo'

this.classList.add('ativo'); // irá adcionar a classe ativo
}

menu_item.forEach ((item) => 
item.addEventListener('click', selectItem));


