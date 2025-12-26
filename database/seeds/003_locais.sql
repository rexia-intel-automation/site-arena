-- ============================================
-- SEED: Locais Padrão
-- ============================================

USE arena_brb;

-- Locais da Arena BRB
INSERT INTO locais (nome, slug, descricao, endereco, capacidade, tipo, ordem, ativo) VALUES
(
    'Arena BRB Mané Garrincha',
    'arena-brb-mane-garrincha',
    'Estádio de futebol e arena multiuso localizado no Setor de Recreação Pública Norte',
    'SRPN - Asa Norte, Brasília - DF, 70070-040',
    72788,
    'estadio',
    1,
    TRUE
),
(
    'Gramado - Arena BRB Mané Garrincha',
    'gramado-arena-brb-mane-garrincha',
    'Gramado externo da Arena BRB Mané Garrincha para eventos ao ar livre',
    'SRPN - Asa Norte, Brasília - DF, 70070-040',
    100000,
    'gramado',
    2,
    TRUE
),
(
    'Arena BRB Nilson Nelson',
    'arena-brb-nilson-nelson',
    'Ginásio poliesportivo para eventos esportivos e shows',
    'SRPN - Asa Norte, Brasília - DF, 70070-200',
    14000,
    'ginasio',
    3,
    TRUE
),
(
    'Setor Interno - Arena BRB Mané Garrincha',
    'setor-interno-arena-brb-mane-garrincha',
    'Área interna coberta do estádio',
    'SRPN - Asa Norte, Brasília - DF, 70070-040',
    50000,
    'arena',
    4,
    TRUE
),
(
    'Área VIP - Arena BRB',
    'area-vip-arena-brb',
    'Espaço exclusivo para eventos corporativos e VIP',
    'SRPN - Asa Norte, Brasília - DF',
    1000,
    'outro',
    5,
    TRUE
);
