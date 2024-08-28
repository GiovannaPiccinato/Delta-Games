// Deixar a opção selecionada pelo click

var menu_item = document.querySelectorAll('.menu_item') // irá pegar todos que tiverem a class item menu e transformalas em um variavel
function selectItem () {
	menu_item.forEach((item) => 
item.classList.remove('ativo')); // irá remover a classe 'ativo'

this.classList.add('ativo'); // irá adcionar a classe ativo
}

menu_item.forEach ((item) => 
item.addEventListener('click', selectItem));


	//irá adicionar um nvo campo de imagem URL
	let numImagens = 1; // Inicializa com 1, pois já há um campo de imagem na inicialização

	function adicionarImagem() {
			const containerImagens = document.getElementById('containerImagens');
					const novoDiv = document.createElement('div');
					novoDiv.className = 'imagem_container';
	
					const novoInputURL = document.createElement('input');
					novoInputURL.type = "text";
					novoInputURL.name = 'imagem_url[]';
					novoInputURL.placeholder = 'URL da Imagem';
					novoInputURL.required = true;
	
					const novoInputOrdem = document.createElement('input');
					novoInputOrdem.type = "number";
					novoInputOrdem.name = 'imagem_ordem[]';
					novoInputOrdem.placeholder = 'Ordem da Imagem';
					novoInputOrdem.min = "1";
					novoInputOrdem.required = true;
	
					const removeButton = document.createElement('a');
					removeButton.className = 'remove-icon';
					removeButton.innerHTML = '<i class="bi bi-x-circle-fill"></i>';
					removeButton.onclick = function() {
							removerImagem(this);
					};
	
					novoDiv.appendChild(novoInputURL);
					novoDiv.appendChild(novoInputOrdem);
					novoDiv.appendChild(removeButton);
	
					containerImagens.appendChild(novoDiv);
	
					numImagens++;
	}
	
	function removerImagem(element) {
			const containerImagem = element.parentElement;
			const containerImagens = document.getElementById('containerImagens');
			
			if (containerImagens.children.length > 1) {
					containerImagem.remove();
					numImagens--;
			} else {
					alert("Não é possível remover o último campo.");
			}
	}
	

		// voltar para a pagina de listagem quando clicar no cadastrar
		function onSubmit(event) {
			event.preventDefault(); // Evita o envio automático do formulário
	
			const form = document.querySelector("form");
			const formData = new FormData(form); // Obtem os dados do formulário
	
			// Envia uma requisição assíncrona para submeter o formulário
			fetch(form.action, {
					method: form.method,
					body: formData
				})
				.then(response => {
					if (response.ok) {
						// Redireciona para a página de listagem de administradores
						window.location.href = "./listar_produto.php";
					} else {
						// Se houver um erro na requisição, exibe uma mensagem de erro
						console.error('Erro ao enviar formulário:', response.statusText);
					}
				})
				.catch(error => {
					console.error('Erro inesperado:', error);
				});
		}

		// remover imagens adicionadas
function removerImagem(element) {
	element.parentNode.remove(); // Remove o pai do ícone (o container da imagem)
}

// sair e excluir o historico 
function sair() {
  // Adicionar um novo estado ao histórico
  history.pushState(null, null, window.location.href);

  // Substituir o estado atual com o novo estado
  history.replaceState(null, null, '../login.php');

  // Redirecionar para a página de login
  window.location.replace('../login.php');
}

// Adicionar um evento 'popstate' para lidar com o botão "voltar" do navegador
window.addEventListener('popstate', function(event) {
  window.location.replace('../login.php');
});

