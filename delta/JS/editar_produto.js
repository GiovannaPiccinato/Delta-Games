// adiciona mais imagens
let numImagens = 1; // Inicializa com 1, pois já há um campo de imagem na inicialização

function adicionarImagem() {
    if (numImagens < 5) { // Limite de 4 imagens adicionais + 1 inicial
        const containerImagens = document.getElementById('containerImagens');
        const novoDiv = document.createElement('div');
        novoDiv.className = 'imagem_container'; // Mantém a mesma classe

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
    } else {
        alert("Você já adicionou o limite máximo de imagens.");
    }
}

// remove os quadrados vazios de adicionar imagem
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