/*Criação do menu co js*/

document.getElementById("menu").innerHTML = `
    <nav class="menu">
    <a href="index.html" class="marca">Barbearia Antônios</a>
        <ul>
            <li><a href="index.html">Menu principal</a></li>
            <li><a href="form.html">Agendar</a></li>
            <li><a href="about.html">Sobre</a></li>
            <li><a href="formAction.html">Agendamentos</a></li>
        </ul>
    </nav>
    <div class="listra"></div>
`;

/* Descobrir página atual pelo final do endereço*/
let paginaAtual = location.pathname.split("/").pop();

/* Se o endereço termina em "/", o navegador está mostrando o index*/
if (paginaAtual === "") {
    paginaAtual= "indexhtml";
}

/* Pegar todos os links do menu*/

const links = document.querySelectorAll(".menu ul a");

/* Para cada link, comparar o href com a página atual */
links.forEach(function (link) {
    if (link.getAttribute("href") === paginaAtual) {
        link.classList.add("active");
    }
});
