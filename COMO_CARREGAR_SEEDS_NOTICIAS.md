# Como Carregar Seeds de Notícias

Este documento explica como popular o banco de dados com notícias de exemplo.

## Método 1: Via phpMyAdmin

1. Acesse o phpMyAdmin
2. Selecione o banco de dados `u568843907_arenabrbweb`
3. Clique na aba "SQL"
4. Copie e cole o conteúdo do arquivo `database/seeds/005_posts_iniciais.sql`
5. Clique em "Executar"

## Método 2: Via linha de comando MySQL

```bash
mysql -u u568843907_gestaoarenaadm -p u568843907_arenabrbweb < database/seeds/005_posts_iniciais.sql
```

Quando solicitado, digite a senha do banco de dados.

## Verificação

Após executar o seed, você pode verificar se as notícias foram inseridas corretamente:

1. Acesse a página de notícias: `http://seu-dominio/noticias`
2. Você deve ver 7 notícias de exemplo
3. A primeira notícia (sobre shows internacionais) deve aparecer em destaque no topo

## Nota

- As notícias de exemplo usam categorias existentes no banco de dados
- Se alguma categoria não existir, a seed irá buscar a primeira disponível
- As datas das notícias são geradas dinamicamente a partir da data atual
