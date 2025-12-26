# 🚀 GUIA DE INSTALAÇÃO RÁPIDA - ARENA BRB

## ✅ PRÉ-REQUISITOS

- PHP 7.4+
- MySQL 5.7+
- Servidor web (Apache/Nginx)
- Extensões PHP: PDO, PDO_MySQL, GD, Fileinfo

---

## 📦 INSTALAÇÃO DO BANCO DE DADOS

### Opção 1: Instalação Automática (Recomendado)

Execute o script SQL completo que cria todas as tabelas e insere os dados iniciais:

```bash
mysql -u u568843907_gestaoarenaadm -p u568843907_arenabrbweb < database/install.sql
```

Quando solicitado, digite a senha do MySQL.

### Opção 2: Instalação Manual

```bash
# 1. Schema (criar tabelas)
mysql -u u568843907_gestaoarenaadm -p u568843907_arenabrbweb < database/schema.sql

# 2. Seeds (dados iniciais)
mysql -u u568843907_gestaoarenaadm -p u568843907_arenabrbweb < database/seeds/001_usuario_admin.sql
mysql -u u568843907_gestaoarenaadm -p u568843907_arenabrbweb < database/seeds/002_categorias.sql
mysql -u u568843907_gestaoarenaadm -p u568843907_arenabrbweb < database/seeds/003_locais.sql
mysql -u u568843907_gestaoarenaadm -p u568843907_arenabrbweb < database/seeds/004_eventos_iniciais.sql
```

---

## 🔑 CONFIGURAR SENHA DO BANCO

Abra o arquivo `config/database.php` e adicione a senha do MySQL:

```php
define('DB_PASS', 'SUA_SENHA_AQUI');
```

---

## 📁 CONFIGURAR PERMISSÕES

Configure permissões da pasta de uploads:

```bash
chmod 755 public/assets/uploads/
chmod 755 public/assets/uploads/eventos/
chmod 755 public/assets/uploads/noticias/
```

---

## ✅ VERIFICAR INSTALAÇÃO

### 1. Testar Conexão com Banco

Crie um arquivo `test-db.php` na raiz:

```php
<?php
require_once 'config/database.php';
require_once 'includes/db/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "✅ Conexão com banco de dados estabelecida com sucesso!<br>";

    // Verificar tabelas
    $tables = ['usuarios_admin', 'categorias', 'locais', 'eventos', 'posts'];
    foreach ($tables as $table) {
        $stmt = $db->query("SELECT COUNT(*) as total FROM {$table}");
        $result = $stmt->fetch();
        echo "✅ Tabela {$table}: {$result['total']} registros<br>";
    }
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage();
}
?>
```

Acesse: `http://seu-dominio.com/test-db.php`

### 2. Testar Login Admin

Acesse: `http://seu-dominio.com/admin/login.php`

**Credenciais padrão:**
- Email: `admin@arenabrb.com.br`
- Senha: `Admin@123`

⚠️ **IMPORTANTE:** Altere a senha após o primeiro login!

---

## 📊 DADOS INSTALADOS

Após a instalação, você terá:

### Usuários
- ✅ 1 administrador padrão

### Categorias
- ✅ 6 categorias de eventos (Shows, Basquete, Festivais, Corporativo, Família, Esportes)
- ✅ 5 categorias de notícias (Notícias, Destaques, Infraestrutura, Sustentabilidade, Eventos)

### Locais
- ✅ Arena BRB Mané Garrincha
- ✅ Gramado - Arena BRB Mané Garrincha
- ✅ Arena BRB Nilson Nelson
- ✅ Setor Interno - Arena BRB Mané Garrincha
- ✅ Área VIP - Arena BRB

### Eventos
- ✅ 3 eventos de exemplo (migrados do site atual)

---

## 🎨 PRÓXIMOS PASSOS

1. **Acessar Painel Admin**
   - URL: `/admin/login.php`
   - Login: `admin@arenabrb.com.br`
   - Senha: `Admin@123`

2. **Alterar Senha do Admin**
   - Vá em Configurações > Perfil
   - Altere a senha padrão

3. **Gerenciar Categorias**
   - Vá em Categorias
   - Adicione/edite/remova categorias

4. **Gerenciar Locais**
   - Vá em Locais
   - Adicione/edite/remova locais

5. **Criar Eventos**
   - Vá em Eventos > Novo Evento
   - **ATENÇÃO:** Imagem obrigatória 475x180px
   - Preencha todos os campos obrigatórios (*)

6. **Modificar Home**
   - Edite `index.php`
   - Substitua eventos hardcoded por dinâmicos
   - Veja exemplos em `README_IMPLEMENTACAO.md`

---

## ⚠️ VALIDAÇÕES RÍGIDAS

### Eventos

Ao criar/editar eventos, os seguintes campos são **OBRIGATÓRIOS**:

- ✅ Título
- ✅ Data do evento
- ✅ Hora do evento
- ✅ Local (selecionar da lista)
- ✅ Categoria (selecionar da lista)
- ✅ Preço mínimo
- ✅ Link de ingressos (URL válida)
- ✅ **Imagem: EXATAMENTE 475x180px** (rejeita se diferente)

### Notícias

- ✅ Título
- ✅ Conteúdo
- ✅ Categoria (selecionar da lista)
- ✅ Imagem: 800x450px

---

## 🔒 SEGURANÇA EM PRODUÇÃO

Após instalação, edite `config/database.php`:

```php
// Desabilitar exibição de erros
error_reporting(0);
ini_set('display_errors', 0);

// Habilitar HTTPS
ini_set('session.cookie_secure', 1);
```

---

## 🆘 PROBLEMAS COMUNS

### Erro: "Access denied for user"
- Verifique a senha em `config/database.php`
- Confirme que o usuário tem permissões no banco

### Erro: "Table doesn't exist"
- Execute o script `database/install.sql`
- Verifique se está usando o banco correto

### Erro ao fazer upload de imagem
- Verifique permissões da pasta `public/assets/uploads/`
- Confirme dimensões da imagem (475x180px para eventos)

### Erro: "Headers already sent"
- Remova espaços em branco antes de `<?php` nos arquivos
- Verifique encoding dos arquivos (UTF-8 sem BOM)

---

## 📞 SUPORTE

Documentação completa:
- `PLANO_MODULARIZACAO_ARENA_BRB.md` - Plano completo
- `README_IMPLEMENTACAO.md` - Guia de desenvolvimento

---

✅ **Instalação concluída! Sistema pronto para uso.**
