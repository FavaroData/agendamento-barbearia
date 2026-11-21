/* Rodapé padrão de todas as páginas */

document.getElementById("rodape").innerHTML = `
    <div class="listra" aria-hidden="true"></div>
    <div class="rodape-conteudo">
        <p class="rodape-marca">Barbearia Antônios</p>
        <p>Telefone: (41) 99999-9999</p>
        <p>Rua Exemplo, 123 - Curitiba/PR</p>
        <p>&copy; ${new Date().getFullYear()} Barbearia Antônios. Todos os direitos reservados.</p>
    </div>
`;

