# 🚨 EXECUTE ESTE SQL AGORA - Correção de Imagens

## Problema

As imagens não aparecem nos cards porque os caminhos no banco têm uma barra inicial `/` que causa erro.

**Erro no console:** `GET https://public/assets/... net::ERR_NAME_NOT_RESOLVED`

## ✅ Solução Rápida

### Execute este SQL no phpMyAdmin:

```sql
UPDATE eventos
SET imagem_destaque = TRIM(LEADING '/' FROM imagem_destaque)
WHERE imagem_destaque LIKE '/%';
```

### Ou copie o arquivo completo:

Abra o arquivo `fix-eventos-images.sql` no phpMyAdmin e execute todo o conteúdo.

## 📋 Como executar no phpMyAdmin

1. Acesse phpMyAdmin
2. Selecione o banco de dados `u568843907_arenabrbweb`
3. Clique na aba **SQL**
4. Cole o comando acima
5. Clique em **Executar**

## ✅ Como verificar se funcionou

Execute este SELECT para ver os caminhos:

```sql
SELECT id, titulo, imagem_destaque
FROM eventos
WHERE imagem_destaque IS NOT NULL
LIMIT 5;
```

**Caminhos DEVEM estar assim:**
- ✅ CORRETO: `public/assets/uploads/eventos/nome.jpg` (SEM barra inicial)
- ❌ ERRADO: `/public/assets/uploads/eventos/nome.jpg` (COM barra inicial)

## 🎯 Após executar

1. Recarregue a página de eventos
2. As imagens aparecerão nos cards
3. Novos eventos criados já terão o caminho correto automaticamente

## ⚠️ Nota sobre Notícias

Se você receber erro sobre tabela `noticias` não existir, ignore - é normal.
O importante é corrigir os eventos primeiro.
