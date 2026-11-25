// Carrega as datas em que o barbeiro escolhido atende (vem do banco, via datas.php)
async function carregarDatas() {
    const listaDatas = document.getElementById("agendamentoData");
    const listaHorarios = document.getElementById("agendamentoHorario");

    // Limpa as datas e os horários anteriores
    listaDatas.innerHTML = "<option value=''>Selecione uma data</option>";
    listaHorarios.innerHTML = "<option value=''>Selecione um horário</option>";

    const idBarbeiro = document.getElementById("agendamentoBarbeiro").value;
    if (idBarbeiro === "") {
        return; // nenhum barbeiro escolhido ainda
    }

    const resposta = await fetch("datas.php?barbeiro=" + idBarbeiro);
    const datas = await resposta.json();

    // <option value="idAgenda">dd/mm/aaaa</option>
    for (let i = 0; i < datas.length; i++) {
        listaDatas.innerHTML +=
            "<option value='" + datas[i].idAgenda + "'>" + formatarData(datas[i].data) + "</option>";
    }
}

// Carrega os horários livres do dia escolhido (vem do banco, via horarios.php)
async function carregarHorarios() {
    const listaHorarios = document.getElementById("agendamentoHorario");

    // Limpa os horários anteriores
    listaHorarios.innerHTML = "<option value=''>Selecione um horário</option>";

    const idAgenda = document.getElementById("agendamentoData").value;
    if (idAgenda === "") {
        return; // nenhuma data escolhida ainda
    }

    const resposta = await fetch("horarios.php?agenda=" + idAgenda);
    const horarios = await resposta.json();

    // <option value="idHorario">09:00</option>
    for (let i = 0; i < horarios.length; i++) {
        listaHorarios.innerHTML +=
            "<option value='" + horarios[i].idHorario + "'>" + horarios[i].hora + "</option>";
    }
}

// Transforma "2026-10-21" (formato do banco) em "21/10/2026"
function formatarData(data) {
    const partes = data.split("-");
    return partes[2] + "/" + partes[1] + "/" + partes[0];
}

// Ao trocar o barbeiro, recarrega as datas; ao trocar a data, recarrega os horários
document.getElementById("agendamentoBarbeiro").addEventListener("change", carregarDatas);
document.getElementById("agendamentoData").addEventListener("change", carregarHorarios);
