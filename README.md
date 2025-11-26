# Arena BRB Mané Garrincha - Website Oficial

Site oficial da Arena BRB Mané Garrincha em Brasília - O maior complexo de eventos do Brasil.

## 🏟️ Sobre o Projeto

Este é o site institucional da Arena BRB Mané Garrincha, desenvolvido para apresentar os espaços, eventos e serviços oferecidos pelo complexo. O site conta com design moderno, responsivo e modo claro/escuro.

## 📁 Estrutura de Arquivos

```
site-arena/
├── index.php                 # Página principal (pode ser renomeada para index.html)
├── assets/
│   ├── css/
│   │   └── styles.css       # Estilos do site
│   ├── js/
│   │   └── main.js          # Scripts JavaScript
│   └── images/              # Pasta para imagens locais (opcional)
└── README.md                # Este arquivo
```

## 🚀 Como Implantar no hPanel da Hostinger

### Passo 1: Acesse o hPanel

1. Faça login na sua conta da Hostinger
2. Acesse o **hPanel** (painel de controle)
3. Localize a seção **Arquivos** > **Gerenciador de Arquivos**

### Passo 2: Prepare os Arquivos

Você tem duas opções:

**Opção A: Usar index.php (Recomendado)**
- Mantenha o arquivo como `index.php`
- Permite usar recursos PHP no futuro (formulários, integração com banco de dados, etc.)

**Opção B: Usar index.html**
- Renomeie `index.php` para `index.html`
- Funciona perfeitamente, mas sem recursos PHP

### Passo 3: Upload dos Arquivos

1. No Gerenciador de Arquivos, navegue até a pasta `public_html`
2. Faça upload dos seguintes arquivos e pastas:
   - `index.php` (ou `index.html`)
   - Pasta `assets/` completa (com css, js e images)

3. A estrutura final deve ficar assim:
   ```
   public_html/
   ├── index.php
   └── assets/
       ├── css/
       │   └── styles.css
       └── js/
           └── main.js
   ```

### Passo 4: Configure as Permissões

1. Selecione todos os arquivos
2. Clique em **Permissões** ou **Chmod**
3. Configure as permissões como:
   - Arquivos: **644** (rw-r--r--)
   - Pastas: **755** (rwxr-xr-x)

### Passo 5: Teste o Site

1. Acesse seu domínio no navegador (ex: `seudominio.com.br`)
2. O site deve carregar corretamente
3. Teste todas as funcionalidades:
   - Toggle de tema (modo claro/escuro)
   - Menu de navegação
   - Scroll suave entre seções
   - Responsividade em dispositivos móveis

## ✨ Funcionalidades

- ✅ **Design Responsivo**: Funciona perfeitamente em desktop, tablet e mobile
- ✅ **Modo Claro/Escuro**: Troca dinâmica de tema com persistência no localStorage
- ✅ **Logos Dinâmicas**: Logos diferentes para cada modo (claro/escuro)
- ✅ **Animações Suaves**: Efeitos de scroll e hover para melhor experiência
- ✅ **Performance Otimizada**: Código limpo e otimizado
- ✅ **SEO Friendly**: Meta tags e estrutura semântica

## 🎨 Logos Utilizadas

### Header (Navegação)
- **Modo Escuro**: Logo branca da Arena BRB - `https://i.imgur.com/51FYi3K.png`
- **Modo Claro**: Logo azul da Arena BRB - `https://i.imgur.com/qAvyaL0.png`

### Footer
- **Arena BSB**:
  - Modo Escuro: `https://i.imgur.com/xqyCXoQ.png`
  - Modo Claro: `https://i.imgur.com/O0Vv0Y2.png`
- **BRB Banco**:
  - Modo Escuro: `https://i.imgur.com/sfPqjWD.png`
  - Modo Claro: `https://i.imgur.com/OM1Bshn.png`

## 🔧 Personalização

### Alterar Cores

Edite o arquivo `assets/css/styles.css` e modifique as variáveis CSS no início:

```css
:root {
    --brb-blue: #0047BB;
    --brb-dark: #002D7A;
    --brb-light: #3373D9;
    --cyan: #00D4FF;
}
```

### Adicionar Eventos

No arquivo `index.php`, localize a seção `<!-- Events Section -->` e adicione novos cards de eventos seguindo o modelo existente.

### Modificar Textos

Todos os textos podem ser editados diretamente no arquivo `index.php`. Procure pelas seções:
- `.hero-content` - Conteúdo principal
- `.events` - Seção de eventos
- `.features` - Recursos e espaços
- `.cta` - Call to Action
- `footer` - Rodapé

## 🌐 Compatibilidade

- ✅ Chrome, Firefox, Safari, Edge (versões recentes)
- ✅ Dispositivos móveis (iOS e Android)
- ✅ Tablets e desktops
- ✅ Resolução mínima: 320px

## 📱 Recursos Adicionais

### Integração com Redes Sociais

Os links de redes sociais já estão configurados no footer. Atualize os URLs no `index.php`:

```html
<a href="https://www.instagram.com/arenabsb/" ...>
<a href="https://www.facebook.com/arenabsb" ...>
<a href="https://twitter.com/arenabsb" ...>
```

### Google Analytics (Opcional)

Para adicionar Google Analytics, insira o código de rastreamento antes do `</head>` no `index.php`:

```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXXXXXXX-X"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-XXXXXXXXX-X');
</script>
```

## 🐛 Solução de Problemas

### O site não carrega corretamente

1. Verifique se todos os arquivos foram enviados
2. Confirme que a estrutura de pastas está correta
3. Limpe o cache do navegador (Ctrl + F5)

### As imagens não aparecem

1. Verifique se as URLs das logos estão corretas
2. Confirme que você tem conexão com a internet
3. As logos estão hospedadas no Imgur - certifique-se de que os links estão acessíveis

### O modo claro/escuro não funciona

1. Verifique se o arquivo `assets/js/main.js` foi carregado
2. Abra o Console do navegador (F12) e verifique se há erros
3. Limpe o localStorage do navegador

## 📞 Suporte

Para dúvidas ou problemas com a implantação:

1. Verifique a documentação da Hostinger: https://support.hostinger.com
2. Entre em contato com o suporte da Hostinger via chat ou ticket

## 📄 Licença

Este projeto é de propriedade da Arena BRB Mané Garrincha.

---

**Desenvolvido com ❤️ para Brasília**

Arena BRB Mané Garrincha - Onde Brasília vive suas maiores experiências
