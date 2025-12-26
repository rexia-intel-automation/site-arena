/**
 * Arena BRB Mané Garrincha - Main JavaScript
 * Funcionalidades interativas do site
 */

// Theme Toggle Function
function toggleTheme() {
    const body = document.body;
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    body.classList.toggle('light-mode');

    if (body.classList.contains('light-mode')) {
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'block';
        localStorage.setItem('theme', 'light');
    } else {
        sunIcon.style.display = 'block';
        moonIcon.style.display = 'none';
        localStorage.setItem('theme', 'dark');
    }
}

// Mobile Menu Toggle Function
function toggleMobileMenu() {
    const navLinks = document.querySelectorAll('.nav-links');
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const body = document.body;

    // Get or create overlay
    let overlay = document.querySelector('.mobile-menu-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'mobile-menu-overlay';
        document.body.appendChild(overlay);

        // Close menu when clicking overlay
        overlay.addEventListener('click', toggleMobileMenu);
    }

    // Toggle menu state
    const isOpen = mobileToggle.classList.contains('active');

    if (isOpen) {
        // Close menu
        navLinks.forEach(link => link.classList.remove('active'));
        mobileToggle.classList.remove('active');
        overlay.classList.remove('active');
        body.classList.remove('menu-open');
    } else {
        // Open menu
        navLinks.forEach(link => link.classList.add('active'));
        mobileToggle.classList.add('active');
        overlay.classList.add('active');
        body.classList.add('menu-open');
    }
}

// Close mobile menu when clicking on a link
function closeMobileMenuOnClick() {
    const navLinks = document.querySelectorAll('.nav-links a');

    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            if (mobileToggle && mobileToggle.classList.contains('active')) {
                toggleMobileMenu();
            }
        });
    });
}

// Initialize mobile menu close on link click
document.addEventListener('DOMContentLoaded', closeMobileMenuOnClick);

// Load saved theme on page load
window.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');

    if (savedTheme === 'light') {
        document.body.classList.add('light-mode');
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'block';
    } else {
        sunIcon.style.display = 'block';
        moonIcon.style.display = 'none';
    }
});

// Smooth scroll for anchor links
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));

            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                // Close mobile menu if open
                const navLinks = document.querySelector('.nav-links');
                if (navLinks.classList.contains('active')) {
                    toggleMobileMenu();
                }
            }
        });
    });
});

// Navbar scroll effect
let lastScroll = 0;
const navbar = document.querySelector('nav');

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

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all cards on page load
window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.event-card, .feature-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease-out';
        observer.observe(card);
    });
});

// Parallax effect for stadium card
window.addEventListener('DOMContentLoaded', () => {
    const stadiumCards = document.querySelectorAll('.stadium-card');

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
});

// Lazy loading for images (optional enhancement)
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Add loading animation on page load
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
});

// Form validation (if forms are added later)
function validateContactForm(form) {
    const name = form.querySelector('input[name="name"]');
    const email = form.querySelector('input[name="email"]');
    const message = form.querySelector('textarea[name="message"]');

    let isValid = true;

    if (name && name.value.trim() === '') {
        showError(name, 'Por favor, insira seu nome');
        isValid = false;
    }

    if (email && !isValidEmail(email.value)) {
        showError(email, 'Por favor, insira um e-mail válido');
        isValid = false;
    }

    if (message && message.value.trim() === '') {
        showError(message, 'Por favor, insira sua mensagem');
        isValid = false;
    }

    return isValid;
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showError(input, message) {
    const formGroup = input.parentElement;
    const errorElement = formGroup.querySelector('.error-message') || document.createElement('span');

    errorElement.className = 'error-message';
    errorElement.textContent = message;

    if (!formGroup.querySelector('.error-message')) {
        formGroup.appendChild(errorElement);
    }

    input.classList.add('error');

    setTimeout(() => {
        input.classList.remove('error');
        errorElement.remove();
    }, 3000);
}

// Handle window resize for responsive adjustments
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        // Adjust navbar padding on resize
        const navbar = document.querySelector('nav');
        if (window.innerWidth <= 768) {
            navbar.style.padding = '16px 24px';
        } else {
            const currentScroll = window.pageYOffset;
            if (currentScroll > 100) {
                navbar.style.padding = '14px 60px';
            } else {
                navbar.style.padding = '20px 60px';
            }
        }
    }, 250);
});

// Performance: Debounce function for scroll events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Add active class to current section in navbar
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-links a');

const highlightNav = debounce(() => {
    const scrollY = window.pageYOffset;

    sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 100;
        const sectionId = section.getAttribute('id');

        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${sectionId}`) {
                    link.classList.add('active');
                }
            });
        }
    });
}, 100);

window.addEventListener('scroll', highlightNav);

// Console message
console.log('%c Arena BRB Mané Garrincha ', 'background: #0047BB; color: white; font-size: 20px; padding: 10px;');
console.log('%c Desenvolvido com ❤️ para Brasília ', 'font-size: 14px; color: #00D4FF;');

// Service Worker registration (optional for PWA)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        // Uncomment when service worker is implemented
        // navigator.serviceWorker.register('/sw.js')
        //     .then(registration => console.log('SW registered:', registration))
        //     .catch(error => console.log('SW registration failed:', error));
    });
}

// Export functions for use in HTML inline handlers
window.toggleTheme = toggleTheme;
window.toggleMobileMenu = toggleMobileMenu;
