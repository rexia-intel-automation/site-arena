# 📋 BACKLOG DE OTIMIZAÇÃO MOBILE - ARENA BRB

**Status:** 🟡 Em Andamento
**Última Atualização:** 29/12/2025

---

## 🔴 PRIORIDADE ALTA - Performance & UX Crítico

### 1. [ ] Ampliar CTA Card em Mobile
**Tempo:** 5 min | **Impacto:** Alto | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Mudança:**
```css
/* Linha ~507-509 */
/* ANTES */
.cta-card {
    width: 70%;
    align-self: center;
}

/* DEPOIS */
.cta-card {
    width: 90%;
    max-width: 100%;
    margin: 0 auto;
}
```

**Benefício:** +20% de espaço útil para conteúdo

---

### 2. [ ] Padronizar Largura dos Botões Hero
**Tempo:** 5 min | **Impacto:** Médio | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Mudança:**
```css
/* Linha ~352-355 */
/* ANTES */
.btn-primary,
.btn-secondary {
    width: 80%;
}

/* DEPOIS */
.btn-primary,
.btn-secondary {
    width: 100%;
    max-width: 320px;
}
```

**Benefício:** Botões mais fáceis de tocar, consistência visual

---

### 3. [ ] Reduzir Backdrop Filter em Mobile
**Tempo:** 10 min | **Impacto:** Alto | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Adicionar no final da seção `@media (max-width: 768px)`:**
```css
@media (max-width: 768px) {
    /* ... código existente ... */

    /* ADICIONAR */
    /* Reduzir blur para melhor performance */
    nav,
    .theme-toggle-floating,
    .event-card,
    .feature-card {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    /* Remover backdrop-filter de elementos menos críticos */
    .btn-secondary {
        backdrop-filter: none;
        background: rgba(255, 255, 255, 0.1);
    }

    body.light-mode .btn-secondary {
        background: rgba(255, 255, 255, 0.7);
    }
}
```

**Benefício:** +30% performance no scroll

---

### 4. [ ] Desabilitar Parallax em Mobile
**Tempo:** 10 min | **Impacto:** Alto | **Dificuldade:** Baixa

**Arquivo:** `assets/js/main.js`

**Mudança:**
```javascript
/* Linha ~167 */
/* ANTES */
window.addEventListener('DOMContentLoaded', () => {
    const stadiumCards = document.querySelectorAll('.stadium-card');

    stadiumCards.forEach(stadiumCard => {
        stadiumCard.addEventListener('mousemove', (e) => {
            // ... código parallax ...
        });
    });
});

/* DEPOIS */
window.addEventListener('DOMContentLoaded', () => {
    const stadiumCards = document.querySelectorAll('.stadium-card');
    const isMobile = window.innerWidth <= 768;

    // Só habilitar parallax em desktop
    if (!isMobile) {
        stadiumCards.forEach(stadiumCard => {
            stadiumCard.addEventListener('mousemove', (e) => {
                const rect = stadiumCard.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = (y - centerY) / 30;
                const rotateY = (centerX - x) / 30;

                stadiumCard.style.transform = `
                    perspective(1000px)
                    rotateX(${rotateX}deg)
                    rotateY(${rotateY}deg)
                    scale3d(1.02, 1.02, 1.02)
                `;
            });

            stadiumCard.addEventListener('mouseleave', () => {
                stadiumCard.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
            });
        });
    }
});
```

**Benefício:** Economia de processamento em mobile

---

### 5. [ ] Converter Navbar Scroll de JS para CSS
**Tempo:** 15 min | **Impacto:** Médio | **Dificuldade:** Média

**Parte 1 - JavaScript:**
**Arquivo:** `assets/js/main.js`

```javascript
/* Linha ~124-140 */
/* ANTES */
window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > 100) {
        navbar.style.padding = '14px 60px';
        navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.2)';
    } else {
        navbar.style.padding = '20px 60px';
        navbar.style.boxShadow = 'none';
    }

    lastScroll = currentScroll;
});

/* DEPOIS */
window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    const scrollThreshold = window.innerHeight * 0.1; // 10% da viewport

    if (currentScroll > scrollThreshold) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }

    lastScroll = currentScroll;
});
```

**Parte 2 - CSS:**
**Arquivo:** `assets/css/styles.css`

```css
/* Adicionar após definição do nav (linha ~754) */

/* Navbar scrolled state */
nav.scrolled {
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
}

body.light-mode nav.scrolled {
    box-shadow: 0 4px 30px rgba(0, 71, 187, 0.15);
}

/* Desktop only - padding reduzido */
@media (min-width: 1201px) {
    nav.scrolled {
        padding: 14px 60px;
        transition: padding 0.3s ease;
    }
}

/* Mobile - manter padding consistente */
@media (max-width: 768px) {
    nav.scrolled {
        padding: 16px 20px; /* Não mudar em mobile */
    }
}
```

**Benefício:** Melhor performance, menos reflow/repaint

---

### 6. [ ] Garantir Touch Targets Mínimos (44x44px)
**Tempo:** 15 min | **Impacto:** Alto | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Adicionar na seção `@media (max-width: 768px)`:**
```css
@media (max-width: 768px) {
    /* ... código existente ... */

    /* ADICIONAR */
    /* Touch Target Optimization - Apple HIG mínimo 44x44px */

    /* Links de navegação mobile */
    .nav-links.active a {
        min-height: 48px;
        display: flex;
        align-items: center;
    }

    /* Botão de evento */
    .event-btn {
        min-height: 44px;
        padding: 12px 16px;
    }

    /* Social links no footer */
    .social-link {
        min-width: 48px;
        min-height: 48px;
    }

    /* Theme toggle já tem 48px (linha 155) - OK */
}
```

**Benefício:** Melhor usabilidade, menos erros de toque

---

## 🟡 PRIORIDADE MÉDIA - Consistência & UX

### 7. [ ] Criar Sistema de Variáveis CSS - Spacing
**Tempo:** 20 min | **Impacto:** Médio | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Adicionar em `:root` (linha ~18-38):**
```css
:root {
    /* ... variáveis existentes ... */

    /* ADICIONAR */

    /* Spacing System */
    --spacing-xs: 8px;
    --spacing-sm: 12px;
    --spacing-md: 16px;
    --spacing-lg: 20px;
    --spacing-xl: 24px;
    --spacing-2xl: 32px;
    --spacing-3xl: 40px;
    --spacing-4xl: 60px;

    /* Padding Mobile */
    --nav-padding-mobile: 16px 20px;
    --section-padding-mobile: 40px 20px;
    --card-padding-mobile: 16px;

    /* Padding Desktop */
    --nav-padding-desktop: 20px 60px;
    --section-padding-desktop: 60px 60px;
    --card-padding-desktop: 24px;

    /* Border Radius */
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 18px;
    --radius-xl: 22px;
    --radius-2xl: 28px;
}
```

**Benefício:** Fácil customização global

---

### 8. [ ] Criar Sistema de Variáveis CSS - Z-index
**Tempo:** 10 min | **Impacto:** Baixo | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Adicionar em `:root`:**
```css
:root {
    /* ... variáveis existentes ... */

    /* ADICIONAR */

    /* Z-index System */
    --z-base: 0;
    --z-float-cards: 10;
    --z-overlay: 998;
    --z-mobile-menu: 999;
    --z-navbar: 1000;
    --z-theme-toggle: 1001;
}
```

**Benefício:** Sistema organizado, evita conflitos

---

### 9. [ ] Aplicar Variável Z-index nos Componentes
**Tempo:** 10 min | **Impacto:** Baixo | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Mudanças:**
```css
/* Linha ~1154 */
.float-card {
    z-index: var(--z-float-cards);
}

/* Linha ~744 */
nav {
    z-index: var(--z-navbar);
}

/* Linha ~103 */
.theme-toggle-floating {
    z-index: var(--z-theme-toggle);
}

/* Linha ~229 */
.mobile-menu-overlay {
    z-index: var(--z-overlay);
}

/* Linha ~251 */
.nav-links.active {
    z-index: var(--z-mobile-menu);
}
```

**Benefício:** Código mais limpo e manutenível

---

### 10. [ ] Criar Variáveis para Backdrop Blur
**Tempo:** 15 min | **Impacto:** Baixo | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Adicionar em `:root`:**
```css
:root {
    /* ... variáveis existentes ... */

    /* ADICIONAR */

    /* Backdrop Blur */
    --blur-light: 8px;
    --blur-medium: 20px;
    --blur-heavy: 40px;

    /* Blur responsivo */
    --blur-mobile: var(--blur-light);
    --blur-desktop: var(--blur-medium);
}
```

**Aplicar nos componentes:**
```css
/* Mobile */
@media (max-width: 768px) {
    nav,
    .event-card,
    .feature-card {
        backdrop-filter: blur(var(--blur-mobile));
        -webkit-backdrop-filter: blur(var(--blur-mobile));
    }
}

/* Desktop */
@media (min-width: 1201px) {
    nav {
        backdrop-filter: blur(var(--blur-medium));
    }

    .event-card,
    .feature-card {
        backdrop-filter: blur(var(--blur-heavy));
    }
}
```

**Benefício:** Controle centralizado de performance

---

### 11. [ ] Adicionar Feedback Visual de Touch (:active)
**Tempo:** 15 min | **Impacto:** Médio | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Adicionar na seção `@media (max-width: 768px)`:**
```css
@media (max-width: 768px) {
    /* ... código existente ... */

    /* ADICIONAR */
    /* Feedback tátil para botões */
    .btn-primary:active,
    .btn-secondary:active,
    .btn-white:active,
    .btn-outline:active,
    .event-btn:active {
        transform: scale(0.97);
        transition: transform 0.1s ease;
    }

    /* Feedback para cards clicáveis */
    .event-card:active {
        transform: scale(0.98);
    }

    /* Feedback para links de navegação */
    .nav-links.active a:active {
        background: rgba(255, 255, 255, 0.15);
    }

    body.light-mode .nav-links.active a:active {
        background: rgba(0, 71, 187, 0.1);
    }

    /* Feedback para theme toggle */
    .theme-toggle-floating:active {
        transform: translateY(-2px) scale(0.95);
    }

    /* Desabilitar hover em mobile (não funciona bem em touch) */
    .event-card:hover,
    .feature-card:hover {
        transform: none;
        border-color: inherit;
        box-shadow: none;
    }
}
```

**Benefício:** Melhor UX, feedback imediato ao toque

---

### 12. [ ] Acelerar Transições em Mobile
**Tempo:** 10 min | **Impacto:** Baixo | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Adicionar na seção `@media (max-width: 768px)`:**
```css
@media (max-width: 768px) {
    /* ... código existente ... */

    /* ADICIONAR */
    /* Transições mais rápidas em mobile */
    .event-card,
    .feature-card,
    .btn-primary,
    .btn-secondary,
    .event-btn {
        transition: all 0.2s ease;
    }

    /* Menu mobile - transição suave mas rápida */
    .nav-links.active {
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Overlay - fade rápido */
    .mobile-menu-overlay {
        transition: opacity 0.2s ease;
    }
}
```

**Benefício:** Interfaces mais responsivas ao toque

---

### 13. [ ] Aplicar Variáveis de Padding no Navbar
**Tempo:** 10 min | **Impacto:** Baixo | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Mudança:**
```css
/* Mobile (linha ~162) */
@media (max-width: 768px) {
    nav {
        padding: var(--nav-padding-mobile);
    }
}

/* Desktop (linha ~745) */
@media (min-width: 1201px) {
    nav {
        padding: var(--nav-padding-desktop);
    }
}
```

**Benefício:** Consistência com sistema de variáveis

---

### 14. [ ] Aplicar Variáveis de Padding nas Sections
**Tempo:** 10 min | **Impacto:** Baixo | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Mudança:**
```css
/* Mobile (linha ~357-363) */
@media (max-width: 768px) {
    .events,
    .features,
    .tour,
    .cta {
        padding: var(--section-padding-mobile);
    }
}

/* Desktop */
@media (min-width: 1201px) {
    .events,
    .features,
    .tour,
    .cta {
        padding: var(--section-padding-desktop);
    }
}
```

**Benefício:** Fácil ajuste global de espaçamentos

---

## 🟢 PRIORIDADE BAIXA - Melhorias Incrementais

### 15. [ ] Adicionar Loading State para Imagens - CSS
**Tempo:** 15 min | **Impacto:** Baixo | **Dificuldade:** Média

**Arquivo:** `assets/css/styles.css`

**Adicionar no final do arquivo:**
```css
/* Loading state para imagens */
.event-img,
.stadium-img {
    background: linear-gradient(
        135deg,
        var(--dark-surface) 0%,
        var(--brb-dark) 50%,
        var(--dark-surface) 100%
    );
    background-size: 200% 200%;
    animation: shimmer 1.5s ease infinite;
}

.event-img img,
.stadium-img img {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.event-img img.loaded,
.stadium-img img.loaded {
    opacity: 1;
}

@keyframes shimmer {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Parar animação quando imagem carrega */
.event-img:has(img.loaded),
.stadium-img:has(img.loaded) {
    animation: none;
}
```

**Benefício:** Melhor percepção de carregamento

---

### 16. [ ] Adicionar Loading State para Imagens - JavaScript
**Tempo:** 10 min | **Impacto:** Baixo | **Dificuldade:** Baixa

**Arquivo:** `assets/js/main.js`

**Adicionar no final do arquivo:**
```javascript
// Loading state para imagens
document.addEventListener('DOMContentLoaded', () => {
    const images = document.querySelectorAll('.event-img img, .stadium-img img');

    images.forEach(img => {
        if (img.complete) {
            img.classList.add('loaded');
        } else {
            img.addEventListener('load', () => {
                img.classList.add('loaded');
            });
        }
    });
});
```

**Benefício:** Feedback visual de carregamento

---

### 17. [ ] Documentar Decisões de Design no CSS
**Tempo:** 15 min | **Impacto:** Baixo | **Dificuldade:** Baixa

**Arquivo:** `assets/css/styles.css`

**Adicionar antes da seção `@media (max-width: 768px)` (linha ~150):**
```css
/* ===================================
   MOBILE DESIGN DECISIONS
   =================================== */

/*
 * DECISÕES INTENCIONAIS DE DESIGN MOBILE:
 *
 * 1. EVENTOS - Informações simplificadas
 *    - Preço e localização ocultos (.event-venue, .event-price)
 *    - Razão: Interface mais limpa, foco no título e CTA
 *    - Usuário clica no evento para ver detalhes completos
 *
 * 2. FEATURES - Descrições ocultas
 *    - Descrições completas ocultas (.feature-desc)
 *    - Razão: Cards mais limpos, foco em ícone e título
 *    - Mantém grid consistente e legível
 *
 * 3. HERO VISUAL - Oculto em mobile
 *    - Stadium card e float cards removidos
 *    - Razão: Priorizar conteúdo textual e CTAs
 *    - Economiza espaço vertical valioso em mobile
 *
 * 4. LAYOUT - Seções com 90% largura
 *    - Margem lateral de 5% cada lado
 *    - Razão: Evitar overflow horizontal
 *    - Melhor controle de responsividade
 *
 * 5. POSICIONAMENTOS - Valores negativos para ajuste fino
 *    - left: -5.25%, right: 15%, etc
 *    - Razão: Correções precisas para prevenir overflow
 *    - Testado em múltiplos dispositivos
 */

/* ===================================
   MOBILE RESPONSIVE STYLES
   =================================== */
```

**Benefício:** Documentação clara para futuros devs

---

### 18. [ ] Otimizar Resize Handler no JavaScript
**Tempo:** 10 min | **Impacto:** Baixo | **Dificuldade:** Baixa

**Arquivo:** `assets/js/main.js`

**Mudança (linha ~272-290):**
```javascript
// ANTES - Recalcula navbar em todo resize

// DEPOIS - Só recalcular se mudar de breakpoint
let currentBreakpoint = window.innerWidth <= 768 ? 'mobile' : 'desktop';

window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        const newBreakpoint = window.innerWidth <= 768 ? 'mobile' : 'desktop';

        // Só atualizar se mudou de breakpoint
        if (newBreakpoint !== currentBreakpoint) {
            currentBreakpoint = newBreakpoint;

            const navbar = document.querySelector('nav');
            if (newBreakpoint === 'mobile') {
                navbar.style.padding = '16px 20px';
            } else {
                const currentScroll = window.pageYOffset;
                if (currentScroll > window.innerHeight * 0.1) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.style.padding = '20px 60px';
                }
            }
        }
    }, 250);
});
```

**Benefício:** Menos recálculos desnecessários

---

### 19. [ ] Adicionar Prefetch para Fontes
**Tempo:** 5 min | **Impacto:** Baixo | **Dificuldade:** Baixa

**Arquivo:** `index.php`

**Adicionar no `<head>` antes da linha 40:**
```html
<!-- Fonts -->
<!-- ADICIONAR antes do link da fonte -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- Linha existente -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
```

**Benefício:** Carregamento mais rápido de fontes

---

### 20. [ ] Adicionar Meta Theme Color
**Tempo:** 5 min | **Impacto:** Baixo | **Dificuldade:** Baixa

**Arquivo:** `index.php`

**Adicionar no `<head>` após linha 32:**
```html
<!-- ADICIONAR -->
<meta name="theme-color" content="#04080F" media="(prefers-color-scheme: dark)">
<meta name="theme-color" content="#F8FAFC" media="(prefers-color-scheme: light)">
```

**Benefício:** Melhor integração com browser mobile

---

## 📊 PROGRESSO

**Total de Tarefas:** 20

### Por Prioridade
- 🔴 **Alta:** 6 tarefas (30%)
- 🟡 **Média:** 8 tarefas (40%)
- 🟢 **Baixa:** 6 tarefas (30%)

### Por Status
- ✅ **Concluídas:** 0/20 (0%)
- 🔄 **Em Andamento:** 0/20 (0%)
- ⏳ **Pendentes:** 20/20 (100%)

### Tempo Total Estimado
- 🔴 **Alta:** ~70 min (1h 10min)
- 🟡 **Média:** ~120 min (2h)
- 🟢 **Baixa:** ~75 min (1h 15min)
- **TOTAL:** ~265 min (~4h 30min)

---

## 🎯 ESTRATÉGIA DE IMPLEMENTAÇÃO

### Sessão 1 - Quick Wins (30-45 min)
- [ ] #1 - Ampliar CTA Card
- [ ] #2 - Padronizar Botões
- [ ] #6 - Touch Targets
- [ ] #19 - Prefetch Fontes
- [ ] #20 - Meta Theme Color

### Sessão 2 - Performance (45-60 min)
- [ ] #3 - Reduzir Backdrop Filter
- [ ] #4 - Desabilitar Parallax
- [ ] #5 - Navbar Scroll CSS

### Sessão 3 - Sistema de Variáveis (60-75 min)
- [ ] #7 - Variáveis Spacing
- [ ] #8 - Variáveis Z-index
- [ ] #9 - Aplicar Z-index
- [ ] #10 - Variáveis Blur
- [ ] #13 - Aplicar Padding Navbar
- [ ] #14 - Aplicar Padding Sections

### Sessão 4 - UX Enhancements (30-45 min)
- [ ] #11 - Feedback Touch
- [ ] #12 - Acelerar Transições
- [ ] #18 - Otimizar Resize Handler

### Sessão 5 - Loading & Docs (30-45 min)
- [ ] #15 - Loading State CSS
- [ ] #16 - Loading State JS
- [ ] #17 - Documentar Decisões

---

## 📝 NOTAS

### Ao Completar Cada Tarefa:
1. Marcar [x] no checkbox
2. Testar em mobile (Chrome DevTools)
3. Verificar se não quebrou desktop
4. Commit individual com mensagem clara
5. Atualizar contador de progresso

### Commits Sugeridos:
```bash
# Exemplo
git add assets/css/styles.css
git commit -m "feat(mobile): ampliar CTA card de 70% para 90%

Melhora aproveitamento de espaço em mobile
Facilita interação com botões
"
```

---

**Próximo Passo:** Escolher uma sessão e começar! 🚀
