// Estado da aplicação
let isLoading = false;
let showPreview = false;

// Elementos DOM
const revealButton = document.getElementById('revealButton');
const loadingSection = document.getElementById('loadingSection');
const valuesGrid = document.getElementById('valuesGrid');

// Função principal para revelar valores
function handleRevealValues() {
    if (isLoading) return;
    
    isLoading = true;
    
    // Atualizar botão para estado de loading
    const buttonText = revealButton.querySelector('.button-text');
    const loadingSpinner = revealButton.querySelector('.loading-spinner');
    
    buttonText.style.display = 'none';
    loadingSpinner.style.display = 'flex';
    revealButton.disabled = true;
    
    // Mostrar seção de loading
    loadingSection.style.display = 'block';
    loadingSection.style.animation = 'fadeIn 0.3s ease';
    
    // Simular carregamento e redirecionar para slug /localizar
    setTimeout(() => {
        window.location.href = '/gv';
    }, 2000);
}

// Valores permanecem sempre censurados - sem efeitos hover
function initializeValueHoverEffects() {
    // Função vazia - valores permanecem sempre censurados
    console.log('Valores censurados - sem preview disponível');
}

// Animações de entrada
function initializeAnimations() {
    // Animar elementos quando a página carrega
    const animatedElements = [
        '.main-card',
        '.title-section',
        '.additional-info'
    ];
    
    animatedElements.forEach((selector, index) => {
        const element = document.querySelector(selector);
        if (element) {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                element.style.transition = 'all 0.6s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 200);
        }
    });
}

// Efeitos de scroll suave
function initializeSmoothScrolling() {
    // Adicionar comportamento suave para links internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Efeitos visuais adicionais
function initializeVisualEffects() {
    // Efeito parallax sutil no background
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallax = document.body;
        const speed = scrolled * 0.5;
        
        parallax.style.backgroundPosition = `center ${speed}px`;
    });
    
    // Efeito de hover nos links do footer
    const footerLinks = document.querySelectorAll('.footer-link');
    footerLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

// Responsividade avançada
function initializeResponsiveFeatures() {
    // Detectar dispositivo móvel
    const isMobile = window.innerWidth <= 768;
    
    if (isMobile) {
        // Ajustar comportamento para mobile
        const valueCards = document.querySelectorAll('.value-card');
        valueCards.forEach(card => {
            card.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });
            
            card.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });
    }
    
    // Redimensionamento da janela
    window.addEventListener('resize', () => {
        const newIsMobile = window.innerWidth <= 768;
        if (newIsMobile !== isMobile) {
            location.reload(); // Recarregar para aplicar mudanças responsivas
        }
    });
}

// Validação e feedback visual
function initializeFormValidation() {
    // Adicionar feedback visual ao botão
    revealButton.addEventListener('mouseenter', function() {
        if (!isLoading) {
            this.style.transform = 'scale(1.05) translateY(-2px)';
            this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.2)';
        }
    });
    
    revealButton.addEventListener('mouseleave', function() {
        if (!isLoading) {
            this.style.transform = 'scale(1) translateY(0)';
            this.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
        }
    });
}

// Acessibilidade
function initializeAccessibility() {
    // Adicionar suporte a teclado
    revealButton.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            handleRevealValues();
        }
    });
    
    // Melhorar navegação por teclado
    const focusableElements = document.querySelectorAll(
        'a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    
    focusableElements.forEach(element => {
        element.addEventListener('focus', function() {
            this.style.outline = '2px solid #6366f1';
            this.style.outlineOffset = '2px';
        });
        
        element.addEventListener('blur', function() {
            this.style.outline = 'none';
        });
    });
}

// Performance e otimizações
function initializePerformanceOptimizations() {
    // Lazy loading para imagens (se houver)
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Debounce para eventos de scroll
    let scrollTimeout;
    window.addEventListener('scroll', () => {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            // Código de scroll otimizado aqui
        }, 16); // ~60fps
    });
}

// Inicialização quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar todas as funcionalidades
    initializeValueHoverEffects();
    initializeAnimations();
    initializeSmoothScrolling();
    initializeVisualEffects();
    initializeResponsiveFeatures();
    initializeFormValidation();
    initializeAccessibility();
    initializePerformanceOptimizations();
    
    // Log para debug (remover em produção)
    console.log('Portal de Consulta inicializado com sucesso!');
});

// Tratamento de erros global
window.addEventListener('error', function(e) {
    console.error('Erro na aplicação:', e.error);
    // Em produção, enviar erro para serviço de monitoramento
});

// Prevenção de comportamentos indesejados
document.addEventListener('contextmenu', function(e) {
    // Desabilitar menu de contexto em elementos sensíveis
    if (e.target.classList.contains('censored-value')) {
        e.preventDefault();
    }
});

// Exportar funções para uso global (se necessário)
window.PortalConsulta = {
    handleRevealValues,
    isLoading: () => isLoading,
    showPreview: () => showPreview
};
