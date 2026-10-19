async function carregarDatas() {
    // variavel de leitura do json e atribuição a ele na const "datas"
    const datasJson = await fetch("dados/datas.json");
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

const form = document.getElementById("form");
// array dos campos do formulário que são identificados por indices (Ex: Nome = primeiro campo na pagina = 0)
const campos = document.querySelectorAll(".required");
// mesma lógica dos campos, com exatamente o mesmo indice pro mesmo campo 
const spans = document.querySelectorAll(".span-required");
const emailRegex = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;

// funções para retornar erro ou pass na validação
function setError(indexCampo) {
    campos[indexCampo].style.border = "1px solid #e63636";
    spans[indexCampo].style.display = "block";
}

function setPass(indexCampo) {
    campos[indexCampo].style.border = "";
    spans[indexCampo].style.display = "none";
}

// funções de validação
function validarNome(){
    // campo[0] = agendamentoNome
    if(campos[0].value.length < 3) {
        setError(0);
    }
    else {
        setPass(0);
    }
}

function validarTelefone() {
    if(campos[1].value.length < 11) {
        setError(1)
    }
    else {
        setPass(1)
    }
}

function validarEmail() {
    if(!emailRegex.test.value(campos[1].value)) {
        setError(1);
    }
    else {
        setPass(1);
    }
}

