USE barbearia;
START TRANSACTION;

-- SERGIO ANTONIO
INSERT INTO usuario (nome, email, senha, role) VALUES ('Sérgio Antônio', 'barbeiro1@example.invalid', '!SEM_SENHA_CONFIGURADA!', 'BARBEIRO');
INSERT INTO barbeiro (idBarbeiro, idUsuario) VALUES (1, LAST_INSERT_ID());

-- LUCAS ANTONIO 
INSERT INTO usuario (nome, email, senha, role) VALUES ('Lucas Antônio', 'barbeiro2@example.invalid', '!SEM_SENHA_CONFIGURADA!', 'BARBEIRO');
INSERT INTO barbeiro (idBarbeiro, idUsuario) VALUES (2, LAST_INSERT_ID());

INSERT INTO agenda (idBarbeiro, data, disponivel) VALUES
-- SERGIO
    (1, '2026-10-20', FALSE),
    (1, '2026-10-21', TRUE),
    (1, '2026-10-22', TRUE),
    (1, '2026-10-23', TRUE),
    (1, '2026-10-24', TRUE),
    (1, '2026-10-25', FALSE),
    (1, '2026-10-26', TRUE),
    (1, '2026-10-27', TRUE),
 -- LUCAS
    (2, '2026-10-20', TRUE),
    (2, '2026-10-21', TRUE),
    (2, '2026-10-22', FALSE),
    (2, '2026-10-23', TRUE),
    (2, '2026-10-24', TRUE),
    (2, '2026-10-25', FALSE),
    (2, '2026-10-26', FALSE),
    (2, '2026-10-27', TRUE);

INSERT INTO barbearia.servicos (nome, preco)
VALUES
    ('Corte de cabelo', 35.00),
    ('Barba', 25.00),
    ('Corte e barba', 55.00),
    ('Sobrancelha', 15.00),
    ('Corte infantil', 30.00);

COMMIT;