# Correção: Imagens de Eventos não aparecendo nos Cards

## Problema Identificado

Os cards de eventos não estavam mostrando as imagens enviadas via painel admin devido a um problema no caminho das imagens.

### Causa Raiz

No arquivo `includes/helpers/upload.php`, o caminho salvo no banco de dados estava com uma barra inicial desnecessária:

```php
// ANTES (INCORRETO)
$relativePath = '/public/assets/uploads/eventos/' . $fileName;
```

Quando esse caminho era usado em `eventos.php`:

```php
style="background-image: url('/' . htmlspecialchars($evento['imagem_destaque']) . '');
```

Resultava em um caminho com barras duplicadas: `//public/assets/uploads/eventos/imagem.jpg`

## Solução Implementada

### 1. Correção do Upload (Novos Eventos)

Arquivo: `includes/helpers/upload.php`

**Linha 115 - Eventos:**
```php
// DEPOIS (CORRETO)
$relativePath = 'public/assets/uploads/eventos/' . $fileName;
```

**Linha 237 - Notícias:**
```php
// DEPOIS (CORRETO)
$relativePath = 'public/assets/uploads/noticias/' . $fileName;
```

### 2. Correção de Eventos Existentes

Para corrigir os eventos/notícias já cadastrados no banco de dados, execute um dos scripts abaixo:

#### Opção 1: Script PHP

```bash
php fix-image-paths.php
```

#### Opção 2: Script SQL Direto

Execute o arquivo `fix-image-paths.sql` no MySQL:

```bash
mysql -u [usuario] -p [banco_de_dados] < fix-image-paths.sql
```

Ou via phpMyAdmin/linha de comando do MySQL:

```sql
UPDATE eventos
SET imagem_destaque = TRIM(LEADING '/' FROM imagem_destaque)
WHERE imagem_destaque LIKE '/%';

UPDATE noticias
SET imagem_destaque = TRIM(LEADING '/' FROM imagem_destaque)
WHERE imagem_destaque LIKE '/%';
```

## Resultado

Após aplicar as correções:
- ✅ Novos eventos terão o caminho correto automaticamente
- ✅ Eventos existentes serão corrigidos após executar o script de migração
- ✅ As imagens serão exibidas corretamente nos cards de eventos
- ✅ Mesma correção aplicada para notícias

## Arquivos Modificados

- `includes/helpers/upload.php` - Correção dos caminhos de upload
- `fix-image-paths.php` - Script PHP de migração (opcional)
- `fix-image-paths.sql` - Script SQL de migração (opcional)
- `FIX_IMAGENS_EVENTOS.md` - Esta documentação

## Teste

Para testar se a correção funcionou:

1. Acesse o painel admin
2. Crie um novo evento com imagem
3. Acesse a página de eventos públicos
4. Verifique se a imagem aparece corretamente no card

Se eventos antigos ainda não mostrarem imagens, execute o script de migração.
