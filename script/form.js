
async function carregarDatas() {
    // variavel de leitura do json e atribuição a ele na const "datas"
    const datasJson = await fetch("data/datas.json");
    const datas = await datasJson.json();

    // variavel do listbox das datas no formulário
    const lista = document.getElementById("agendamentoData");

    // logica principal de leitura onde: se disponivel = true, então ele exibe no listbox, caso contrário não mostra
    for (let i = 0; i < datas.length; i++) {
        if (datas[i].disponivel == true) {
            lista.innerHTML +=
            // <option value="(todas as datas no arquivo de datas)"></option>
                "<option value='" + datas[i].data + "'>" + datas[i].data + "</option>";
        } 
    }
}

carregarDatas();

const agendamentoNome = document.getElementById("agendamentoNome").value;

agendamentoNome.addEventListener("input", function() {
    document.getElementById("teste").innerHTML = agendamentoNome.value;
});
