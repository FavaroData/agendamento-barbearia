/*Criação do menu co js*/
/* removi o aria-current page fixo do Agendamentos pq tava bugando, e coloquei na função do js para ele ler somente a pagina ativa */
document.getElementById("menu").innerHTML = `
<header class="cabecalho">
    <nav class="menu" aria-label="Menu principal">
        <a href="index.html" class="marca">
            Barbearia Antônios
        </a>

        <ul class="menu-links">
            <li><a href="index.html">Menu principal</a></li>
            <li><a href="form.html">Agendar</a></li>
            <li><a href="about.html">Sobre</a></li>
            <li><a href="formAction.html">Agendamentos</a></li>
        </ul>
    </nav>
    <div class="listra" aria-hidden="true"></div>
</header>
`;

/* Descobrir página atual pelo final do endereço */
let paginaAtual = location.pathname.split("/").pop();

/* Se o endereço termina em "/", o navegador está mostrando o index */
if (paginaAtual === "") {
    paginaAtual = "index.html";
}

/* Pegar todos os links do menu */
const links = document.querySelectorAll(".menu-links a");

/* Para cada link, comparar o href com a página atual */
links.forEach(function (link) {
    if (link.getAttribute("href") === paginaAtual) {
        link.classList.add("active");
        link.setAttribute("aria-current", "page");
    }
});
