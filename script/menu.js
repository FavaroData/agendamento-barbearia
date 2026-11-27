/*Criação do menu co js*/
/* removi o aria-current page fixo do Agendamentos pq tava bugando, e coloquei na função do js para ele ler somente a pagina ativa */
const raizProjeto = new URL("../", document.currentScript.src);

document.getElementById("menu").innerHTML = `
<header class="cabecalho">
    <nav class="menu" aria-label="Menu principal">
        <a href="${raizProjeto}index.html" class="marca">
            Barbearia Antônios
        </a>

        <ul class="menu-links">
            <li><a href="${raizProjeto}index.html">Menu principal</a></li>
            <li data-requer-login hidden><a href="${raizProjeto}form.php">Agendar</a></li>
            <li data-requer-login hidden><a href="${raizProjeto}agendamentos.php">Agendamentos</a></li>
            <li data-apenas-visitante><a href="${raizProjeto}form.php">Realizar agendamento</a></li>
            <li><a href="${raizProjeto}about.php">Sobre</a></li>
            <li data-requer-login hidden><a href="${raizProjeto}login/logout.php">Sair</a></li>
        </ul>
    </nav>
    <div class="listra" aria-hidden="true"></div>
</header>
`;

let paginaAtual = location.pathname;

/* Se o endereço termina em "/", o navegador está mostrando o index */
if (paginaAtual === raizProjeto.pathname) {
    paginaAtual = raizProjeto.pathname + "index.html";
}

/* Pegar todos os links do menu */
const links = document.querySelectorAll(".menu-links a");

/* Para cada link, comparar o href com a página atual */
links.forEach(function (link) {
    if (link.pathname === paginaAtual) {
        link.classList.add("active");
        link.setAttribute("aria-current", "page");
    }
});

async function atualizarMenuDaSessao() {
    try {
        const resposta = await fetch(new URL("login/sessao.php", raizProjeto));
        if (!resposta.ok) return;

        const sessao = await resposta.json();
        if (sessao.autenticado !== true) return;

        document.querySelector("#menu [data-apenas-visitante]").hidden = true;

        document.querySelectorAll("#menu [data-requer-login]").forEach((item) => {
            item.hidden = false;
        });
    } catch {
        // Se a consulta falhar, o menu mantém os itens de visitante.
    }
}

atualizarMenuDaSessao();
