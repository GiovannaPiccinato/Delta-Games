// Deixar a opção selecionada pelo click

var menu_item = document.querySelectorAll('.menu_item') // irá pegar todos que tiverem a class item menu e transformalas em um variavel
function selectItem () {
	menu_item.forEach((item) => 
item.classList.remove('ativo')); // irá remover a classe 'ativo'

this.classList.add('ativo'); // irá adcionar a classe ativo
}

menu_item.forEach ((item) => 
item.addEventListener('click', selectItem));


//barra de pesquisa 
document.addEventListener('DOMContentLoaded', function() {
	const searchInput = document.getElementById('searchInput');
	const tableRows = document.querySelectorAll('#table_body tr');

	searchInput.addEventListener('keyup', () => {
			let searchTerm = searchInput.value.toLowerCase().trim();

			if (searchTerm.length < 0) {
					tableRows.forEach(row => {
							row.style.display = ''; // Exibe todas as linhas da tabela se o termo de pesquisa for muito curto
					});
					return;
			}

			tableRows.forEach(row => {
					let rowContent = row.innerHTML.toLowerCase();
					if (rowContent.includes(searchTerm)) {
							row.style.display = ''; // Exibe a linha se o termo de pesquisa estiver presente nela
					} else {
							row.style.display = 'none'; // Oculta a linha se o termo de pesquisa não estiver presente nela
					}
			});
	});
});

// Função para mostrar o cadastro e depois talvez de para incluir tambem o de editar
function confirm() {
  document.getElementById("modal_close").style.display = "block";
}

// Função para fechar a tela se necessario
function fechar() {
  document.getElementById("modal_close").style.display = "none";
}

