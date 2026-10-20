const parametros = new URLSearchParams(window.location.search);

const nome = parametros.get("nome");
const telefone = parametros.get("telefone");
const email = parametros.get("email");
const servico = parametros.get("servico");
const barbeiroNome = parametros.get("barbeiroNome");
const data = parametros.get("data");
const horario = parametros.get("horario");

document.getElementById("nome").textContent = nome;
document.getElementById("telefone").textContent = telefone;
document.getElementById("email").textContent = email;
document.getElementById("servico").textContent = servico;
document.getElementById("barbeiroNome").textContent = barbeiroNome;
document.getElementById("data").textContent = data;
document.getElementById("horario").textContent = horario;