-- =============================================
-- Seed: Posts/Notícias Iniciais
-- Descrição: Notícias de exemplo para testar a página de notícias
-- =============================================

-- Inserir notícias de exemplo
INSERT INTO posts (
    titulo,
    slug,
    resumo,
    conteudo,
    categoria_id,
    autor_id,
    autor_nome,
    imagem_destaque,
    status,
    destaque,
    permite_comentarios,
    criado_por,
    publicado_em,
    criado_em
) VALUES
(
    'Arena BRB anuncia temporada de shows internacionais para 2026',
    'arena-brb-anuncia-temporada-shows-internacionais-2026',
    'Grandes nomes da música mundial confirmam apresentações no complexo. Line-up traz artistas de diversos gêneros e promete movimentar a capital federal.',
    '<p>A Arena BRB divulgou hoje o calendário de shows internacionais para a temporada 2026, trazendo grandes nomes da música mundial para Brasília. O line-up diversificado contempla diversos gêneros musicais e promete agitar a capital federal.</p>

<p>Entre os artistas confirmados estão nomes do rock, pop, eletrônica e música latina. A programação terá início em março e se estenderá até dezembro de 2026.</p>

<p>"Estamos muito animados em trazer esses artistas para Brasília. A Arena BRB tem se consolidado como um dos principais destinos de shows internacionais no Brasil", afirmou o diretor de eventos do complexo.</p>

<p>Os ingressos começam a ser vendidos no próximo mês através dos canais oficiais. Fique atento às nossas redes sociais para mais informações sobre datas e valores.</p>',
    (SELECT id FROM categorias WHERE nome = 'Shows' LIMIT 1),
    1,
    'Admin Arena',
    'https://i.imgur.com/BPnRSBE.jpeg',
    'publicado',
    1,
    1,
    1,
    NOW() - INTERVAL 3 DAY,
    NOW() - INTERVAL 3 DAY
),
(
    'Final do Campeonato Brasiliense será na Arena BRB',
    'final-campeonato-brasiliense-arena-brb',
    'Decisão do campeonato local acontece no estádio. Evento promete grande público e infraestrutura completa para torcedores.',
    '<p>A Arena BRB Mané Garrincha foi escolhida para sediar a grande final do Campeonato Brasiliense de 2026. O jogo decisivo acontecerá no próximo domingo e promete reunir milhares de torcedores.</p>

<p>O estádio oferecerá toda a infraestrutura necessária para garantir conforto e segurança ao público. Haverá reforço de segurança, estacionamento especial e opções diversificadas de alimentação.</p>

<p>Os ingressos já estão à venda e podem ser adquiridos através dos canais oficiais dos clubes participantes e no site da Arena BRB.</p>',
    (SELECT id FROM categorias WHERE nome = 'Esportes' LIMIT 1),
    1,
    'Admin Arena',
    'https://i.imgur.com/xqyCXoQ.png',
    'publicado',
    0,
    1,
    1,
    NOW() - INTERVAL 5 DAY,
    NOW() - INTERVAL 5 DAY
),
(
    'Novo espaço para eventos corporativos inaugurado',
    'novo-espaco-eventos-corporativos-inaugurado',
    'Arena BRB expande suas opções com ambiente moderno para congressos e convenções empresariais.',
    '<p>A Arena BRB inaugurou nesta semana um novo espaço dedicado a eventos corporativos. O ambiente moderno e tecnológico está preparado para receber congressos, convenções e reuniões empresariais de grande porte.</p>

<p>O novo espaço conta com capacidade para até 500 pessoas, equipamentos audiovisuais de última geração, conexão de internet de alta velocidade e serviços de catering diferenciados.</p>

<p>"Este novo espaço amplia nossas possibilidades de atender o mercado corporativo com excelência", destacou o gerente comercial da Arena.</p>

<p>Para mais informações sobre locação do espaço, entre em contato através do nosso canal comercial.</p>',
    (SELECT id FROM categorias WHERE nome = 'Infraestrutura' LIMIT 1),
    1,
    'Admin Arena',
    NULL,
    'publicado',
    0,
    1,
    1,
    NOW() - INTERVAL 7 DAY,
    NOW() - INTERVAL 7 DAY
),
(
    'Arena BRB recebe certificação de sustentabilidade',
    'arena-brb-certificacao-sustentabilidade',
    'Complexo é reconhecido por práticas ambientais e obtém selo internacional de sustentabilidade.',
    '<p>A Arena BRB recebeu a certificação internacional de sustentabilidade, reconhecendo as práticas ambientais implementadas no complexo. O selo atesta o compromisso da arena com o meio ambiente e a responsabilidade social.</p>

<p>Entre as iniciativas que garantiram a certificação estão: sistema de captação de água da chuva, uso de energia solar, programa de reciclagem, gestão eficiente de resíduos e uso de materiais sustentáveis.</p>

<p>"Estamos orgulhosos em receber este reconhecimento. A sustentabilidade é um pilar fundamental em nossa operação", afirmou a diretora executiva.</p>',
    (SELECT id FROM categorias WHERE nome = 'Sustentabilidade' LIMIT 1),
    1,
    'Admin Arena',
    NULL,
    'publicado',
    0,
    1,
    1,
    NOW() - INTERVAL 10 DAY,
    NOW() - INTERVAL 10 DAY
),
(
    'Festival de Música Eletrônica confirmado para março',
    'festival-musica-eletronica-marco',
    'Grande festival de música eletrônica terá duas noites de apresentações com DJs nacionais e internacionais.',
    '<p>Está confirmado para março o maior festival de música eletrônica de Brasília. O evento acontecerá na Arena BRB durante dois dias consecutivos e contará com a participação de DJs renomados do cenário nacional e internacional.</p>

<p>A programação completa será divulgada em breve, mas já estão confirmados alguns dos principais nomes da cena eletrônica mundial.</p>

<p>O festival contará com múltiplos palcos, área gastronômica diversificada e infraestrutura completa para garantir a melhor experiência aos participantes.</p>

<p>Fique atento às nossas redes sociais para informações sobre venda de ingressos.</p>',
    (SELECT id FROM categorias WHERE nome = 'Eventos' LIMIT 1),
    1,
    'Admin Arena',
    NULL,
    'publicado',
    0,
    1,
    1,
    NOW() - INTERVAL 12 DAY,
    NOW() - INTERVAL 12 DAY
),
(
    'Tour virtual 360° já disponível no site',
    'tour-virtual-360-disponivel-site',
    'Conheça a Arena BRB sem sair de casa através da nova experiência imersiva em 360 graus.',
    '<p>A Arena BRB lança hoje seu tour virtual 360°, permitindo que visitantes de todo o mundo conheçam o complexo sem sair de casa. A tecnologia imersiva oferece uma experiência realista de todos os espaços da arena.</p>

<p>O tour virtual permite explorar o estádio, as arquibancadas, os camarotes, os espaços de eventos e até mesmo áreas técnicas normalmente restritas ao público.</p>

<p>A ferramenta está disponível gratuitamente no site oficial e pode ser acessada através de computadores, tablets e smartphones. Para uma experiência ainda mais imersiva, é possível utilizar óculos de realidade virtual.</p>

<p>Acesse agora e conheça a Arena BRB!</p>',
    (SELECT id FROM categorias WHERE nome = 'Tecnologia' LIMIT 1),
    1,
    'Admin Arena',
    NULL,
    'publicado',
    0,
    1,
    1,
    NOW() - INTERVAL 15 DAY,
    NOW() - INTERVAL 15 DAY
),
(
    'Arena BRB completa 12 anos de história',
    'arena-brb-completa-12-anos-historia',
    'Complexo celebra mais de uma década de grandes eventos e momentos históricos na capital federal.',
    '<p>A Arena BRB Mané Garrincha celebra neste mês 12 anos desde sua reinauguração para a Copa do Mundo de 2014. Durante este período, o complexo se consolidou como um dos principais centros de eventos do Brasil.</p>

<p>Foram mais de 500 eventos realizados, incluindo jogos de futebol, shows internacionais, eventos esportivos, festivais e conferências. O complexo já recebeu milhões de visitantes e se tornou um símbolo de Brasília.</p>

<p>"São 12 anos de muita história e momentos inesquecíveis. Agradecemos a todos que fazem parte desta jornada", destacou a direção da Arena.</p>

<p>Para celebrar a data, estão programadas diversas atividades especiais ao longo do mês. Confira a programação completa em nosso site.</p>',
    (SELECT id FROM categorias WHERE nome = 'Institucional' LIMIT 1),
    1,
    'Admin Arena',
    NULL,
    'publicado',
    0,
    1,
    1,
    NOW() - INTERVAL 18 DAY,
    NOW() - INTERVAL 18 DAY
);

-- Atualizar contadores
UPDATE posts SET visualizacoes = FLOOR(RAND() * 1000) + 100 WHERE status = 'publicado';
