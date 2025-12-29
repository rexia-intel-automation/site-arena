/**
 * CORREÇÕES DE COMPATIBILIDADE JAVASCRIPT
 * Chrome vs Edge - Arena BRB
 * Data: 2025-12-29
 */

/* ===================================
   1. FEATURE DETECTION
   Detectar suporte a features modernas
   =================================== */

// Função para detectar features CSS
function supportsCSS(property, value) {
    if (window.CSS && window.CSS.supports) {
        return CSS.supports(property, value);
    }

    // Fallback para navegadores antigos
    const element = document.createElement('div');
    element.style[property] = value;
    return element.style[property] === value;
}

// Adicionar classes no body baseado em suporte
document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;

    // Detectar suporte a backdrop-filter
    if (supportsCSS('backdrop-filter', 'blur(10px)')) {
        body.classList.add('supports-backdrop-filter');
    } else {
        body.classList.add('no-backdrop-filter');
        console.warn('⚠️ Navegador não suporta backdrop-filter. Usando fallback.');
    }

    // Detectar suporte a gap no flexbox
    if (supportsCSS('gap', '10px')) {
        body.classList.add('supports-gap');
    } else {
        body.classList.add('no-gap');
        console.warn('⚠️ Navegador não suporta flexbox gap. Usando fallback.');
    }

    // Detectar suporte a object-fit
    if (supportsCSS('object-fit', 'cover')) {
        body.classList.add('supports-object-fit');
    } else {
        body.classList.add('no-object-fit');
        console.warn('⚠️ Navegador não suporta object-fit. Usando fallback.');
        applyObjectFitFallback();
    }

    // Detectar IntersectionObserver
    if ('IntersectionObserver' in window) {
        body.classList.add('supports-intersection-observer');
    } else {
        body.classList.add('no-intersection-observer');
        console.warn('⚠️ Navegador não suporta IntersectionObserver. Desabilitando animações.');
    }
});

/* ===================================
   2. OBJECT-FIT FALLBACK
   Para Edge Legacy e IE
   =================================== */

function applyObjectFitFallback() {
    // Aplicar fallback para imagens que usam object-fit
    const images = document.querySelectorAll('img[style*="object-fit"]');

    images.forEach(img => {
        const objectFit = window.getComputedStyle(img).objectFit;

        if (!objectFit || objectFit === 'none') {
            // Usar background-image como fallback
            const parent = img.parentElement;
            const src = img.src;

            parent.style.backgroundImage = `url(${src})`;
            parent.style.backgroundSize = 'cover';
            parent.style.backgroundPosition = 'center';
            img.style.opacity = '0';

            console.log('✅ Aplicado fallback object-fit para:', img);
        }
    });
}

/* ===================================
   3. INTERSECTION OBSERVER COM FALLBACK
   Para animações de scroll
   =================================== */

// Substituir o código original (linhas 142-164 do main.js) por:

const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

function initializeScrollAnimations() {
    const cards = document.querySelectorAll('.event-card, .feature-card');

    if ('IntersectionObserver' in window) {
        // Usar IntersectionObserver (navegadores modernos)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease-out';
            observer.observe(card);
        });

        console.log('✅ IntersectionObserver inicializado');
    } else {
        // Fallback para navegadores antigos
        console.warn('⚠️ IntersectionObserver não disponível. Aplicando estilos diretamente.');

        cards.forEach(card => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        });
    }
}

window.addEventListener('DOMContentLoaded', initializeScrollAnimations);

/* ===================================
   4. VIEWPORT WIDTH FIX
   Corrigir diferenças no cálculo de 100vw
   =================================== */

function fixViewportWidth() {
    // Calcular a largura real do viewport (sem scrollbar)
    const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);

    // Definir uma variável CSS customizada
    document.documentElement.style.setProperty('--vw', `${vw}px`);

    // Atualizar em resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            const newVw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
            document.documentElement.style.setProperty('--vw', `${newVw}px`);
        }, 250);
    });
}

// Inicializar fix do viewport
fixViewportWidth();

/* ===================================
   5. SMOOTH SCROLL POLYFILL
   Para navegadores sem suporte a scroll-behavior
   =================================== */

function smoothScrollTo(target) {
    if (!target) return;

    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
    const startPosition = window.pageYOffset;
    const distance = targetPosition - startPosition;
    const duration = 800; // ms
    let start = null;

    function animation(currentTime) {
        if (start === null) start = currentTime;
        const timeElapsed = currentTime - start;
        const run = ease(timeElapsed, startPosition, distance, duration);
        window.scrollTo(0, run);

        if (timeElapsed < duration) {
            requestAnimationFrame(animation);
        }
    }

    function ease(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return c / 2 * t * t + b;
        t--;
        return -c / 2 * (t * (t - 2) - 1) + b;
    }

    requestAnimationFrame(animation);
}

// Substituir o código original (linhas 102-122 do main.js) por:
document.addEventListener('DOMContentLoaded', () => {
    const supportsNativeSmoothScroll = 'scrollBehavior' in document.documentElement.style;

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));

            if (target) {
                if (supportsNativeSmoothScroll) {
                    // Usar scroll nativo
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                } else {
                    // Usar polyfill
                    smoothScrollTo(target);
                }

                // Close mobile menu if open
                const navLinks = document.querySelector('.nav-links');
                if (navLinks && navLinks.classList.contains('active')) {
                    toggleMobileMenu();
                }
            }
        });
    });

    if (!supportsNativeSmoothScroll) {
        console.warn('⚠️ scroll-behavior não suportado. Usando polyfill.');
    }
});

/* ===================================
   6. LOCALSTORAGE COM FALLBACK
   Para modo privado e navegadores antigos
   =================================== */

// Wrapper seguro para localStorage
const storage = {
    isAvailable: false,

    init() {
        try {
            const test = '__storage_test__';
            localStorage.setItem(test, test);
            localStorage.removeItem(test);
            this.isAvailable = true;
            return true;
        } catch (e) {
            console.warn('⚠️ localStorage não disponível. Usando fallback em memória.');
            this.isAvailable = false;
            return false;
        }
    },

    cache: {},

    setItem(key, value) {
        if (this.isAvailable) {
            try {
                localStorage.setItem(key, value);
            } catch (e) {
                console.error('Erro ao salvar no localStorage:', e);
                this.cache[key] = value;
            }
        } else {
            this.cache[key] = value;
        }
    },

    getItem(key) {
        if (this.isAvailable) {
            try {
                return localStorage.getItem(key);
            } catch (e) {
                console.error('Erro ao ler do localStorage:', e);
                return this.cache[key] || null;
            }
        } else {
            return this.cache[key] || null;
        }
    }
};

// Inicializar storage
storage.init();

// Atualizar a função toggleTheme para usar o wrapper seguro
function toggleTheme() {
    const body = document.body;
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    body.classList.toggle('light-mode');

    if (body.classList.contains('light-mode')) {
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'block';
        storage.setItem('theme', 'light'); // Usar wrapper seguro
    } else {
        sunIcon.style.display = 'block';
        moonIcon.style.display = 'none';
        storage.setItem('theme', 'dark'); // Usar wrapper seguro
    }
}

// Carregar tema salvo
window.addEventListener('DOMContentLoaded', () => {
    const savedTheme = storage.getItem('theme'); // Usar wrapper seguro
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    if (savedTheme === 'light') {
        document.body.classList.add('light-mode');
        if (sunIcon) sunIcon.style.display = 'none';
        if (moonIcon) moonIcon.style.display = 'block';
    } else {
        if (sunIcon) sunIcon.style.display = 'block';
        if (moonIcon) moonIcon.style.display = 'none';
    }
});

/* ===================================
   7. BROWSER DETECTION & DEBUG
   Para identificar qual navegador está causando problemas
   =================================== */

function detectBrowser() {
    const ua = navigator.userAgent;
    let browser = 'Unknown';
    let version = 'Unknown';
    let engine = 'Unknown';

    // Detectar navegador
    if (ua.indexOf('Edg/') > -1) {
        browser = 'Edge (Chromium)';
        version = ua.match(/Edg\/(\d+)/)[1];
        engine = 'Blink';
    } else if (ua.indexOf('Edge/') > -1) {
        browser = 'Edge (Legacy)';
        version = ua.match(/Edge\/(\d+)/)[1];
        engine = 'EdgeHTML';
    } else if (ua.indexOf('Chrome/') > -1) {
        browser = 'Chrome';
        version = ua.match(/Chrome\/(\d+)/)[1];
        engine = 'Blink';
    } else if (ua.indexOf('Safari/') > -1) {
        browser = 'Safari';
        version = ua.match(/Version\/(\d+)/)?.[1] || 'Unknown';
        engine = 'WebKit';
    } else if (ua.indexOf('Firefox/') > -1) {
        browser = 'Firefox';
        version = ua.match(/Firefox\/(\d+)/)[1];
        engine = 'Gecko';
    }

    return { browser, version, engine };
}

function logBrowserInfo() {
    const info = detectBrowser();
    const viewport = {
        width: window.innerWidth,
        height: window.innerHeight,
        devicePixelRatio: window.devicePixelRatio
    };

    console.group('🌐 Informações do Navegador');
    console.log('Navegador:', info.browser);
    console.log('Versão:', info.version);
    console.log('Motor:', info.engine);
    console.log('User Agent:', navigator.userAgent);
    console.groupEnd();

    console.group('📱 Viewport');
    console.log('Largura:', viewport.width + 'px');
    console.log('Altura:', viewport.height + 'px');
    console.log('Device Pixel Ratio:', viewport.devicePixelRatio);
    console.groupEnd();

    console.group('✅ Suporte a Features CSS');
    console.log('backdrop-filter:', supportsCSS('backdrop-filter', 'blur(10px)'));
    console.log('gap:', supportsCSS('gap', '10px'));
    console.log('object-fit:', supportsCSS('object-fit', 'cover'));
    console.log('scroll-behavior:', supportsCSS('scroll-behavior', 'smooth'));
    console.log('position: sticky:', supportsCSS('position', 'sticky'));
    console.groupEnd();

    console.group('✅ Suporte a Features JavaScript');
    console.log('IntersectionObserver:', 'IntersectionObserver' in window);
    console.log('localStorage:', storage.isAvailable);
    console.log('requestAnimationFrame:', 'requestAnimationFrame' in window);
    console.log('CSS.supports:', 'CSS' in window && 'supports' in window.CSS);
    console.groupEnd();

    // Adicionar warning para Edge Legacy
    if (info.engine === 'EdgeHTML') {
        console.warn('⚠️ ATENÇÃO: Você está usando Edge Legacy (EdgeHTML).');
        console.warn('⚠️ Este navegador tem suporte limitado a features modernas.');
        console.warn('⚠️ Recomendamos atualizar para Edge Chromium (versão 79+).');
    }
}

// Executar log de debug
logBrowserInfo();

/* ===================================
   8. PERFORMANCE MONITORING
   =================================== */

function monitorPerformance() {
    if ('performance' in window && 'PerformanceObserver' in window) {
        // Monitorar Long Tasks
        try {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    console.warn('⚠️ Long Task detectada:', entry.duration.toFixed(2) + 'ms');
                }
            });
            observer.observe({ entryTypes: ['longtask'] });
        } catch (e) {
            console.log('PerformanceObserver não disponível para longtask');
        }

        // Log de métricas de carregamento
        window.addEventListener('load', () => {
            setTimeout(() => {
                const perfData = performance.getEntriesByType('navigation')[0];
                if (perfData) {
                    console.group('⚡ Performance Metrics');
                    console.log('DOM Content Loaded:', perfData.domContentLoadedEventEnd.toFixed(2) + 'ms');
                    console.log('Load Complete:', perfData.loadEventEnd.toFixed(2) + 'ms');
                    console.log('DOM Interactive:', perfData.domInteractive.toFixed(2) + 'ms');
                    console.groupEnd();
                }
            }, 0);
        });
    }
}

// Inicializar monitoring
monitorPerformance();

/* ===================================
   9. EXPORT FUNCTIONS
   Manter compatibilidade com HTML inline
   =================================== */

window.toggleTheme = toggleTheme;
window.toggleMobileMenu = toggleMobileMenu;
window.supportsCSS = supportsCSS;
window.detectBrowser = detectBrowser;
