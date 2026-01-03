# 🔧 CORREÇÃO URGENTE - Imagens dos Eventos

## ⚠️ IMPORTANTE: Execute este SQL AGORA

Os eventos existentes no banco de dados têm caminhos incorretos que impedem as imagens de aparecerem.

### Execute este SQL via phpMyAdmin ou linha de comando:

```sql
-- Corrigir eventos existentes
UPDATE eventos
SET imagem_destaque = TRIM(LEADING '/' FROM imagem_destaque)
WHERE imagem_destaque LIKE '/%';

-- Corrigir notícias existentes
UPDATE noticias
SET imagem_destaque = TRIM(LEADING '/' FROM imagem_destaque)
WHERE imagem_destaque LIKE '/%';
```

### Ou execute o script PHP:

```bash
php fix-image-paths.php
```

## ✅ Após executar o SQL

1. Recarregue a página de eventos
2. As imagens devem aparecer nos cards
3. Novos eventos criados já terão o caminho correto automaticamente

## 📝 O que foi corrigido

- **Problema**: Caminhos salvos como `/public/assets/...` resultavam em `//public/assets/...` (URL inválida)
- **Solução**: Removida a barra inicial, agora é `public/assets/...`
- **Arquivos alterados**:
  - `includes/helpers/upload.php` (linhas 115 e 237)
  - `database/seeds/004_eventos_iniciais.sql` (linhas 37, 72, 107)

## 🔍 Verificar se funcionou

Após executar o SQL, verifique no banco:

```sql
SELECT id, titulo, imagem_destaque FROM eventos LIMIT 5;
```

Os caminhos NÃO devem começar com `/`

**CORRETO**: `public/assets/uploads/eventos/nome.jpg`
**ERRADO**: `/public/assets/uploads/eventos/nome.jpg`
