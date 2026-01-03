-- ============================================
-- SEED: Eventos Iniciais
-- Migração dos 3 eventos hardcoded do index.php
-- ============================================

USE arena_brb;

-- Evento 1: Turma do Pagode + Rodriguinho
INSERT INTO eventos (
    titulo,
    slug,
    descricao,
    conteudo,
    data_evento,
    hora_evento,
    local_id,
    categoria_id,
    tipo_evento,
    preco_minimo,
    link_ingressos,
    imagem_destaque,
    status,
    destaque,
    publicado_em
) VALUES (
    'Turma do Pagode + Rodriguinho',
    'turma-do-pagode-rodriguinho',
    'Uma noite épica de pagode com os maiores sucessos',
    '<p>Prepare-se para uma noite inesquecível com <strong>Turma do Pagode</strong> e <strong>Rodriguinho</strong>!</p><p>Os maiores sucessos do pagode brasileiro em um único show na Arena BRB Mané Garrincha.</p><p>Não perca essa oportunidade única de curtir os hits que marcaram gerações.</p>',
    '2025-12-15',
    '20:00:00',
    (SELECT id FROM locais WHERE slug = 'arena-brb-mane-garrincha' LIMIT 1),
    (SELECT id FROM categorias WHERE slug = 'shows' AND tipo = 'evento' LIMIT 1),
    'show',
    80.00,
    'https://www.bilheteriadigital.com/',
    'public/assets/uploads/eventos/turma-pagode.jpg',
    'publicado',
    TRUE,
    NOW()
);

-- Evento 2: Brasília Basquete vs Flamengo
INSERT INTO eventos (
    titulo,
    slug,
    descricao,
    conteudo,
    data_evento,
    hora_evento,
    local_id,
    categoria_id,
    tipo_evento,
    preco_minimo,
    link_ingressos,
    imagem_destaque,
    status,
    destaque,
    publicado_em
) VALUES (
    'Brasília Basquete vs Flamengo',
    'brasilia-basquete-vs-flamengo',
    'Clássico do basquete brasileiro pelo NBB',
    '<p><strong>Brasília Basquete</strong> enfrenta o <strong>Flamengo</strong> em um dos jogos mais aguardados da temporada do NBB!</p><p>Venha torcer pelo time da capital e ajudar a fazer a diferença nas arquibancadas.</p><p>Ingressos com preços especiais para torcedores locais.</p>',
    '2025-12-18',
    '19:30:00',
    (SELECT id FROM locais WHERE slug = 'arena-brb-nilson-nelson' LIMIT 1),
    (SELECT id FROM categorias WHERE slug = 'basquete' AND tipo = 'evento' LIMIT 1),
    'basquete',
    50.00,
    'https://www.ticket360.com.br/',
    'public/assets/uploads/eventos/basquete-flamengo.jpg',
    'publicado',
    TRUE,
    NOW()
);

-- Evento 3: Festival de Verão Brasília
INSERT INTO eventos (
    titulo,
    slug,
    descricao,
    conteudo,
    data_evento,
    hora_evento,
    local_id,
    categoria_id,
    tipo_evento,
    preco_minimo,
    link_ingressos,
    imagem_destaque,
    status,
    destaque,
    publicado_em
) VALUES (
    'Festival de Verão Brasília',
    'festival-de-verao-brasilia',
    'O maior festival de verão do Centro-Oeste com atrações nacionais',
    '<p>Chegou a hora do <strong>Festival de Verão Brasília 2025</strong>!</p><p>12 horas de muita música, cultura, gastronomia e diversão no gramado da Arena BRB Mané Garrincha.</p><p>Lineup confirmado:</p><ul><li>Wesley Safadão</li><li>Anitta</li><li>Thiaguinho</li><li>Jorge & Mateus</li><li>Ludmilla</li><li>E muito mais!</li></ul><p>Traga a família e aproveite o melhor do verão brasiliense!</p>',
    '2025-12-22',
    '16:00:00',
    (SELECT id FROM locais WHERE slug = 'gramado-arena-brb-mane-garrincha' LIMIT 1),
    (SELECT id FROM categorias WHERE slug = 'festivais' AND tipo = 'evento' LIMIT 1),
    'festival',
    120.00,
    'https://www.eventim.com.br/',
    'public/assets/uploads/eventos/festival-verao.jpg',
    'publicado',
    TRUE,
    NOW()
);
