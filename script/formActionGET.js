const parametros = new URLSearchParams(window.location.search);

const nome = parametros.get("nome");
const telefone = parametros.get("telefone");
const email = parametros.get("email");
const servico = parametros.get("servico");
const barbeiroNome = parametros.get("barbeiroNome");
const data = parametros.get("data");
const horario = parametros.get("horario");
const observacoes = parametros.get("observacoes")

if (!nome) {
    document.getElementById("titulo").textContent = "Nenhum agendamento realizado"
    document.getElementById("comprovante").hidden = true;
} else { 
    document.getElementById("nomeCliente").textContent = nome;
    document.getElementById("telefone").textContent = telefone;
    document.getElementById("email").textContent = email;
    document.getElementById("tipoServico").textContent = servico;
    document.getElementById("nomeBarbeiro").textContent = barbeiroNome;
    document.getElementById("data").textContent = data;
    document.getElementById("horario").textContent = horario;
    document.getElementById("observacoes").textContent = observacoes;
}