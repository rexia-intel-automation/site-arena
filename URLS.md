# 🔗 ESTRUTURA DE URLs - ARENA BRB

## ✅ URLs SEM EXTENSÃO .php

Todas as URLs da área pública **não exibem** a extensão `.php`.

---

## 📍 ÁREA PÚBLICA (sem .php)

### Páginas Principais

| URL Amigável | Arquivo Real | Descrição |
|-------------|--------------|-----------|
| `/` | `index.php` | Home |
| `/eventos` | `public/eventos.php` | Listagem de eventos |
| `/noticias` | `public/noticias.php` | Listagem de notícias |

### Páginas Individuais

| URL Amigável | Arquivo Real | Descrição |
|-------------|--------------|-----------|
| `/eventos/turma-do-pagode-rodriguinho` | `public/evento.php?slug=turma-do-pagode-rodriguinho` | Evento individual |
| `/noticias/titulo-da-noticia` | `public/noticia.php?slug=titulo-da-noticia` | Notícia individual |

### Páginas Legais

| URL Amigável | Arquivo Real | Descrição |
|-------------|--------------|-----------|
| `/termos` | `termos.php` | Termos de uso |
| `/privacidade` | `privacidade.php` | Política de privacidade |
| `/consentimento` | `consentimento.php` | Consentimento de cookies |

---

## 🔐 ÁREA ADMINISTRATIVA (mantém .php)

A área administrativa **mantém** a extensão `.php` por segurança.

| URL | Descrição |
|-----|-----------|
| `/admin/login.php` | Login do painel |
| `/admin/index.php` | Dashboard |
| `/admin/eventos/index.php` | Gerenciar eventos |
| `/admin/eventos/criar.php` | Criar evento |
| `/admin/noticias/index.php` | Gerenciar notícias |
| `/admin/categorias/index.php` | Gerenciar categorias |
| `/admin/locais/index.php` | Gerenciar locais |

---

## 🔄 REDIRECIONAMENTOS AUTOMÁTICOS

### URLs com .php são redirecionadas (301 permanente)

```
❌ /eventos.php           → ✅ /eventos
❌ /noticias.php          → ✅ /noticias
❌ /termos.php            → ✅ /termos
❌ /privacidade.php       → ✅ /privacidade
```

**Exceção:** A pasta `/admin` **não** é redirecionada.

---

## 📝 EXEMPLOS DE USO

### Links no HTML/PHP

```php
<!-- ✅ CORRETO: sem .php -->
<a href="/eventos">Ver Eventos</a>
<a href="/eventos/turma-do-pagode-rodriguinho">Ver Evento</a>
<a href="/noticias">Ver Notícias</a>
<a href="/termos">Termos de Uso</a>

<!-- ❌ INCORRETO: com .php -->
<a href="/eventos.php">Ver Eventos</a>
<a href="/public/evento.php?slug=...">Ver Evento</a>
```

### Gerando Links Dinâmicos

```php
// Para eventos
$urlEvento = "/eventos/" . $evento['slug'];
echo "<a href='{$urlEvento}'>{$evento['titulo']}</a>";

// Para notícias
$urlNoticia = "/noticias/" . $post['slug'];
echo "<a href='{$urlNoticia}'>{$post['titulo']}</a>";
```

### Redirecionamentos no PHP

```php
// ✅ CORRETO
header("Location: /eventos");

// ❌ INCORRETO
header("Location: /eventos.php");
```

---

## 🛠️ COMO FUNCIONA (Técnico)

### 1. Redirecionamento 301 (Permanente)

Se alguém acessar `/eventos.php`, o servidor redireciona automaticamente para `/eventos`.

```apache
RewriteCond %{THE_REQUEST} ^[A-Z]{3,}\s([^.]+)\.php [NC]
RewriteRule ^ %1 [R=301,L]
```

### 2. Reescrita Interna (Transparente)

Quando alguém acessa `/eventos`, o servidor internamente chama `eventos.php`.

```apache
RewriteCond %{REQUEST_FILENAME}\.php -f
RewriteRule ^(.*)$ $1.php [L]
```

### 3. Rotas Personalizadas

URLs específicas são mapeadas para arquivos com parâmetros:

```apache
# /eventos/slug-do-evento -> public/evento.php?slug=slug-do-evento
RewriteRule ^eventos/([a-zA-Z0-9-]+)$ public/evento.php?slug=$1 [L]

# /noticias/slug-da-noticia -> public/noticia.php?slug=slug-da-noticia
RewriteRule ^noticias/([a-zA-Z0-9-]+)$ public/noticia.php?slug=$1 [L]
```

---

## ✅ BENEFÍCIOS

### SEO
- URLs mais limpas e amigáveis
- Melhor indexação pelos buscadores
- URLs mais fáceis de compartilhar

### Segurança
- Oculta tecnologia usada (PHP)
- Dificulta ataques direcionados
- Admin mantém .php (segurança por obscuridade não é aplicada)

### Usabilidade
- URLs mais fáceis de lembrar
- Mais profissional
- Melhor experiência do usuário

---

## 🧪 TESTAR URLs

### Teste 1: Redirecionamento Automático

Acesse:
```
http://seusite.com/eventos.php
```

Deve redirecionar automaticamente para:
```
http://seusite.com/eventos
```

### Teste 2: URLs Amigáveis

Acesse:
```
http://seusite.com/eventos
```

Deve exibir a listagem de eventos (arquivo `public/eventos.php`).

### Teste 3: Eventos Individuais

Acesse:
```
http://seusite.com/eventos/turma-do-pagode-rodriguinho
```

Deve exibir o evento (arquivo `public/evento.php?slug=turma-do-pagode-rodriguinho`).

### Teste 4: Admin Mantém .php

Acesse:
```
http://seusite.com/admin/login.php
```

Deve funcionar normalmente (sem redirecionamento).

---

## 🔍 VERIFICAR CONFIGURAÇÃO

### Via Terminal

```bash
# Testar se mod_rewrite está habilitado
apache2ctl -M | grep rewrite

# Deve retornar:
# rewrite_module (shared)
```

### Via PHP

Crie um arquivo `test-rewrite.php`:

```php
<?php
if (in_array('mod_rewrite', apache_get_modules())) {
    echo "✅ mod_rewrite está habilitado";
} else {
    echo "❌ mod_rewrite NÃO está habilitado";
}
?>
```

---

## ⚠️ PROBLEMAS COMUNS

### Erro 404 ao acessar sem .php

**Causa:** mod_rewrite não está habilitado

**Solução:**
```bash
# Ubuntu/Debian
sudo a2enmod rewrite
sudo systemctl restart apache2

# Hostinger: já vem habilitado
```

### Links ainda aparecem com .php

**Causa:** Links hardcoded no código

**Solução:** Atualizar todos os links para usar URLs sem .php

```php
// ❌ ANTES
<a href="/eventos.php">Eventos</a>

// ✅ DEPOIS
<a href="/eventos">Eventos</a>
```

### Admin não funciona

**Causa:** Regras de rewrite estão afetando /admin

**Solução:** Verificar se há condição `RewriteCond %{REQUEST_URI} !^/admin`

---

## 📚 REFERÊNCIAS

- [Apache mod_rewrite Documentation](https://httpd.apache.org/docs/current/mod/mod_rewrite.html)
- [.htaccess Tutorial](https://httpd.apache.org/docs/current/howto/htaccess.html)
- [URL Rewriting Best Practices](https://developers.google.com/search/docs/crawling-indexing/url-structure)

---

✅ **URLs configuradas e prontas para uso!**

Todas as páginas públicas funcionam sem `.php` na URL.
