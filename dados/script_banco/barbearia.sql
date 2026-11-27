CREATE SCHEMA IF NOT EXISTS `barbearia` DEFAULT CHARACTER SET utf8;
USE `barbearia`;

-- CRIAÇÃO DAS TABELAS 
-- TABELA USUARIO
CREATE TABLE IF NOT EXISTS barbearia.usuario (
    idUsuario INT AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    -- EXPLICITAR NA CRIACAO DO USUARIO
    role ENUM('BARBEIRO', 'CLIENTE') NOT NULL DEFAULT 'CLIENTE',
    PRIMARY KEY (idUsuario)
);

-- TABELA BARBEIRO
CREATE TABLE IF NOT EXISTS barbearia.barbeiro (
    idBarbeiro INT AUTO_INCREMENT PRIMARY KEY,
    idUsuario INT NOT NULL UNIQUE,
    CONSTRAINT fk_barbeiro_usuario
        FOREIGN KEY (idUsuario)
        REFERENCES barbearia.usuario(idUsuario)
);

-- TABELA AGENDA
CREATE TABLE IF NOT EXISTS barbearia.agenda (
    idAgenda INT AUTO_INCREMENT PRIMARY KEY,

    idBarbeiro INT NOT NULL,
    data DATE NOT NULL,
    disponivel BOOLEAN NOT NULL DEFAULT TRUE,

    CONSTRAINT fk_agenda_barbeiro
        FOREIGN KEY (idBarbeiro)
        REFERENCES barbearia.barbeiro(idBarbeiro),

    UNIQUE (idBarbeiro, data)
);

-- TABELA HORARIO
CREATE TABLE IF NOT EXISTS barbearia.horario (
    idHorario INT AUTO_INCREMENT PRIMARY KEY,

    idAgenda INT NOT NULL,
    hora TIME NOT NULL,

    disponivel BOOLEAN NOT NULL DEFAULT TRUE,

    CONSTRAINT fk_horario_agenda
        FOREIGN KEY (idAgenda)
        REFERENCES barbearia.agenda(idAgenda),
    UNIQUE (idAgenda, hora)
);

-- TABELA SERVICOS
CREATE TABLE IF NOT EXISTS barbearia.servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL DEFAULT 0,
    -- VALIDACAO DO VALOR
    CHECK (preco >= 0)
);

-- TABELA AGENDAMENTO
CREATE TABLE IF NOT EXISTS barbearia.agendamento (
    idAgendamento INT AUTO_INCREMENT PRIMARY KEY,
    idUsuario   INT NOT NULL,
    idHorario   INT NOT NULL UNIQUE,
    idServico   INT NOT NULL,
    observacoes TEXT,
    CONSTRAINT fk_agendamento_usuario FOREIGN KEY (idUsuario) REFERENCES barbearia.usuario(idUsuario),
    CONSTRAINT fk_agendamento_horario FOREIGN KEY (idHorario) REFERENCES barbearia.horario(idHorario),
    CONSTRAINT fk_agendamento_servico FOREIGN KEY (idServico) REFERENCES barbearia.servicos(id)
);