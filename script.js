document.addEventListener("DOMContentLoaded", function () {
    const cartCount = document.querySelector(".cart-count");
    const cartList = document.querySelector("#carrinho-list");
    const totalPriceEl = document.querySelector("#total-price");
    const loginForm = document.querySelector("#login-form");
    const cadastroForm = document.querySelector("#cadastro-form");
    const loginMensagem = document.querySelector("#login-mensagem");
    const cadastroMensagem = document.querySelector("#cadastro-mensagem");

    let cart = [];
    let users = {}; 

    function updateCart() {
        cartCount.textContent = cart.length;
        cartList.innerHTML = '';
        let totalPrice = 0;

        cart.forEach((item, index) => {
            const listItem = document.createElement('li');
            listItem.textContent = `${item.nome} - R$ ${item.preco}`;

            const removeBtn = document.createElement('button');
            removeBtn.textContent = "Remover";
            removeBtn.classList.add("btn-remover");
            removeBtn.addEventListener("click", function () {
                cart.splice(index, 1);
                updateCart();
            });

            listItem.appendChild(removeBtn);
            cartList.appendChild(listItem);
            totalPrice += parseFloat(item.preco);
        });

        totalPriceEl.textContent = totalPrice.toFixed(2);
    }

    document.querySelectorAll(".btn-adicionar").forEach(button => {
        button.addEventListener("click", function () {
            const nome = this.getAttribute("data-nome");
            const preco = this.getAttribute("data-preco");
            cart.push({ nome, preco });
            updateCart();
        });
    });

    cadastroForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const usuario = document.querySelector("#novo-usuario").value;
        const email = document.querySelector("#novo-email").value;
        const senha = document.querySelector("#nova-senha").value;
        users[usuario] = { email, senha };
        cadastroMensagem.textContent = "Cadastro realizado!";
    });

    loginForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const loginInput = document.querySelector("#login-usuario-email").value;
        const senha = document.querySelector("#senha").value;

        for (let user in users) {
            if ((user === loginInput || users[user].email === loginInput) && users[user].senha === senha) {
                loginMensagem.textContent = "Login bem-sucedido!";
                return;
            }
        }

        loginMensagem.textContent = "Usuário ou senha incorretos!";
    });
});
