async function carregarDatas() {
    // variavel de leitura do json e atribuição a ele na const "datas"
    const datasJson = await fetch("dados/datas.json");
    const datas = await datasJson.json();

    // variavel do listbox das datas no formulário
    const listaDatas = document.getElementById("agendamentoData");

    // logica principal de leitura 
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

// execucao das async
carregarBarbeiros();
carregarDatas();
carregarHorarios();
// evento pra atualizar os horarios disponiveis de acordo com a data selecionada
document.getElementById("agendamentoData").addEventListener("change", carregarHorarios);

// funcao de mascara no campo telefone onde coloca o formato como (xx) xxxxx-xxxx
function mascaraTelefone(event) {
    let telefone = event.target.value.replace(/\D/g, "");

    if (telefone.length > 11) {
        telefone = telefone.substring(0, 11);
    }

    if (telefone.length > 7) {
        telefone = telefone.replace(
            /^(\d{2})(\d{5})(\d{0,4})$/,
            "($1) $2-$3"
        );
    } else if (telefone.length > 2) {
        telefone = telefone.replace(
            /^(\d{2})(\d{0,5})$/,
            "($1) $2"
        );
    } else if (telefone.length > 0) {
        telefone = telefone.replace(
            /^(\d{0,2})$/,
            "($1"
        );
    }

    event.target.value = telefone;
}
// evento para executar a funcao em tempo real
document.getElementById('agendamentoTelefone').addEventListener('input', mascaraTelefone);
        

// variaveis principais do formulario
const form = document.getElementById("agendamentoForm");
// array dos campos do formulário que são identificados por indices (Ex: Nome = primeiro campo na pagina = 0)
const campos = document.querySelectorAll(".required");
// array para os erros, com a mesma lógica dos campos, com exatamente o mesmo indice pro mesmo campo 
const spans = document.querySelectorAll(".span-required");
const spansNull = document.querySelectorAll(".span-required-null");

const emailRegex = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;

// evento que executa ao clicar em "agendar":
// valida os campos preenchidos,
// verifica se está vazio, ou se está com escrita inválida
// se tiver todos os campos certos, retorna no console valido ou invalido
// se nao, para a validação e retorna os erros
// cria uma variavel com os dados e envia para o formaction
form.addEventListener("submit", (event) => {
    event.preventDefault();

    let formularioValido = true;

    for (let i = 0; i < campos.length; i++) {
        if (campos[i].value.trim() === "") {
            setPass(i);
            validarCampoVazio(i);
            formularioValido = false;
        } else {
            removeSpanNull(i);

            if (i === 0) {
                validarNome();
                if (campos[i].value.trim().length < 3) formularioValido = false;
            } else if (i === 1) {
                if (!validarTelefone()) formularioValido = false;
            } else if (i === 2) {
                validarEmail();
                if (!emailRegex.test(campos[i].value)) formularioValido = false;
            }
        }
    }

    // validaçãp no console do form 
    console.log("Formulário válido!", formularioValido);

    // define se para a validação ou nao
    if (!formularioValido) {
        return;
    }

    // coloca os dados dos campos dentro dessa const dados para que o método get possa utilizar ele
    const dados = new URLSearchParams();

    dados.append("nome", campos[0].value);
    dados.append("telefone", campos[1].value.replace(/\D/g, ""));
    dados.append("email", campos[2].value);
    dados.append("servico", document.querySelector('input[name="servico"]:checked')?.value || "");
    dados.append("barbeiroNome", document.getElementById("agendamentoBarbeiro").value);
    dados.append("data", document.getElementById("agendamentoData").value);
    dados.append("horario", document.getElementById("agendamentoHorario").value);
    dados.append("observacoes", document.getElementById("agendamentoObservacoes").value);

    // envia os dados e redireciona a página
    window.location.href = "formAction.html?" + dados.toString();
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

// remover caracteres invalidos do proprio campo id=agendamentoTelefone 
function tratarCampoTelefone(indexCampo) {
    let telefone = campos[indexCampo].value;

    telefone = telefone.replace(/\D/g, "");

    campos[indexCampo].value = telefone;
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
    // remove os caracteres da máscara só pra validar
    const telefone = campos[1].value.replace(/\D/g, "");

    if (!/^\d{11}$/.test(telefone)) {
        setError(1);
        return false;
    } else {
        setPass(1);
        return true;
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