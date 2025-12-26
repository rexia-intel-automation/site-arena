-- ============================================
-- SEED: Categorias Padrão
-- ============================================

USE arena_brb;

-- Categorias de Eventos
INSERT INTO categorias (nome, slug, descricao, tipo, cor, icone, ordem, ativo) VALUES
('Shows', 'shows', 'Apresentações musicais e shows', 'evento', '#FF5733', 'music', 1, TRUE),
('Basquete', 'basquete', 'Jogos e eventos de basquete', 'evento', '#3498DB', 'basketball', 2, TRUE),
('Festivais', 'festivais', 'Festivais e eventos culturais', 'evento', '#9B59B6', 'festival', 3, TRUE),
('Corporativo', 'corporativo', 'Eventos corporativos e empresariais', 'evento', '#2ECC71', 'business', 4, TRUE),
('Família', 'familia', 'Eventos para toda a família', 'evento', '#F39C12', 'family', 5, TRUE),
('Esportes', 'esportes', 'Eventos esportivos diversos', 'evento', '#E74C3C', 'sports', 6, TRUE);

-- Categorias de Notícias
INSERT INTO categorias (nome, slug, descricao, tipo, cor, icone, ordem, ativo) VALUES
('Notícias', 'noticias', 'Notícias gerais da Arena BRB', 'noticia', '#E74C3C', 'news', 1, TRUE),
('Destaques', 'destaques', 'Destaques e novidades importantes', 'noticia', '#1ABC9C', 'star', 2, TRUE),
('Infraestrutura', 'infraestrutura', 'Melhorias e obras na infraestrutura', 'noticia', '#34495E', 'building', 3, TRUE),
('Sustentabilidade', 'sustentabilidade', 'Ações e iniciativas sustentáveis', 'noticia', '#27AE60', 'eco', 4, TRUE),
('Eventos', 'eventos-noticias', 'Notícias sobre eventos realizados', 'noticia', '#8E44AD', 'calendar', 5, TRUE);
