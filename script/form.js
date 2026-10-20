async function carregarDatas() {
    // variavel de leitura do json e atribuição a ele na const "datas"
    const datasJson = await fetch("dados/datas.json");
    const datas = await datasJson.json();

    // variavel do listbox das datas no formulário
    const listaDatas = document.getElementById("agendamentoData");

    // logica principal de leitura onde: se disponivel = true, então ele exibe no listbox, caso contrário não mostra
    for(let i = 0; i < datas.length; i++) {
        if (datas[i].disponivel == true) {
            listaDatas.innerHTML +=
            // <option value="(todas as datas no arquivo de datas)"></option>
                "<option value='" + datas[i].data + "'>" + datas[i].data + "</option>";
        } 
    }
}

async function carregarHorarios() {
    const horariosJson = await fetch("dados/horarios.json");
    const horarios = await horariosJson.json();

    const listaDatas = document.getElementById("agendamentoData");
    const listaHorarios = document.getElementById("agendamentoHorario");

    // Limpa os horários anteriores
    listaHorarios.innerHTML = "<option value=''>Selecione um horário</option>";

    // Pega a data selecionada
    const dataSelecionada = listaDatas.value;

    for(let i = 0; i < horarios.length; i++) {
        if (horarios[i].data == dataSelecionada) {
            for(let j = 0; j < horarios[i].horarios.length; j++) {
                if (horarios[i].horarios[j].disponivel == true) {
                    listaHorarios.innerHTML +=
                        "<option value='" + horarios[i].horarios[j].hora + "'>" + horarios[i].horarios[j].hora + "</option>";
                }
            }
        }
    }
}

async function carregarBarbeiros() {
    const barbeirosJson = await fetch("dados/barbeiros.json")
    const barbeiros = await barbeirosJson.json()

    const listaBarbeiros = document.getElementById("agendamentoBarbeiro")

    for(let i = 0; i < barbeiros.length; i++) {
        listaBarbeiros.innerHTML += 
            "<option value='" + barbeiros[i].nome + "'>" + barbeiros[i].nome + "</option"
    }
}

carregarBarbeiros();
carregarDatas();
carregarHorarios();
// evento pra atualizar os horarios disponiveis de acordo com a data selecionada
document.getElementById("agendamentoData").addEventListener("change", carregarHorarios);

// variaveis principais do formulario
const form = document.getElementById("agendamentoForm");
// array dos campos do formulário que são identificados por indices (Ex: Nome = primeiro campo na pagina = 0)
const campos = document.querySelectorAll(".required");
// array para os erros, com a mesma lógica dos campos, com exatamente o mesmo indice pro mesmo campo 
const spans = document.querySelectorAll(".span-required");
const spansNull = document.querySelectorAll(".span-required-null");

const emailRegex = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;

form.addEventListener('submit', (event) => {
    event.preventDefault();

    for(let i = 0; i < campos.length; i++) {
        if(campos[i].value.trim() === "") {
            validarCampoVazio(i)
            setPass(i)
        }
        else {
            removeSpanNull(i)

            if(i === 0) {
                validarNome();
            } 
            else if(i === 1) {
                validarTelefone();
            }
            else if(i === 2) {
                validarEmail();
            }
        }
    }

});

// funções para retornar erro ou pass na validação
function setError(indexCampo) {
    campos[indexCampo].style.border = "1px solid #e63636";
    spans[indexCampo].style.display = "block";
}

function setPass(indexCampo) {
    campos[indexCampo].style.border = "";
    spans[indexCampo].style.display = "none";
}

function setSpanNull(indexCampo) {
    campos[indexCampo].style.border = "1px solid #e63636";
    spansNull[indexCampo].style.display = "block";
}

function removeSpanNull(indexCampo) {
    campos[indexCampo].style.border = "";
    spansNull[indexCampo].style.display = "";
}

// campos vazios
function validarCampoVazio(indexCampo) {
    if(campos[indexCampo].value.trim() === "") {
        setSpanNull(indexCampo)
    }
    else {
        removeSpanNull(indexCampo)
    }
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
     // campo[1] = agendamentoTelefone
    if (!/^\d{11}$/.test(campos[1].value.trim())) {
        setError(1);
    } else {
        setPass(1);
    }
}

function validarEmail() {
    // campo[2] = agendamentoEmail
    if(!emailRegex.test(campos[2].value)) {
        setError(2)
    }
    else {
        setPass(2)
    }
}
