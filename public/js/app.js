console.log('🎨 FIANKA - Simple CSS/JS Setup Loaded!');

// ========== NAVBAR SCROLL EFFECT ==========
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (navbar) {
        navbar.classList.toggle('scrolled', window.scrollY > 50);
    }
});

// ========== LANGUAGE SELECTOR ==========
document.addEventListener('DOMContentLoaded', () => {
    const selector = document.getElementById('language-selector');
    if (!selector) return;
    
    const currentFlag = document.querySelector('.current-flag');
    const savedLocale = localStorage.getItem('locale') || selector.value;
    selector.value = savedLocale;
    
    if (currentFlag && selector.options[selector.selectedIndex]) {
        const opt = selector.options[selector.selectedIndex];
        currentFlag.src = opt.getAttribute('data-flag');
        currentFlag.alt = opt.text + ' flag';
    }
    
    selector.addEventListener('change', e => {
        const locale = e.target.value;
        localStorage.setItem('locale', locale);
        // Update this URL to match your language switch route
        window.location.href = '/language/switch?locale=' + locale;
    });
});

// ========== COUNTDOWN TIMER ==========
function startCountdown() {
    const countdownDate = new Date("June 30, 2025 00:00:00").getTime();
    
    const countdown = setInterval(() => {
        const now = Date.now();
        const distance = countdownDate - now;
        
        // Calculate time units
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Update DOM elements
        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');
        
        if (daysEl) daysEl.textContent = days.toString().padStart(2, '0');
        if (hoursEl) hoursEl.textContent = hours.toString().padStart(2, '0');
        if (minutesEl) minutesEl.textContent = minutes.toString().padStart(2, '0');
        if (secondsEl) secondsEl.textContent = seconds.toString().padStart(2, '0');
        
        // If countdown is finished
        if (distance < 0) {
            clearInterval(countdown);
            if (daysEl) daysEl.textContent = "00";
            if (hoursEl) hoursEl.textContent = "00";
            if (minutesEl) minutesEl.textContent = "00";
            if (secondsEl) secondsEl.textContent = "00";
        }
    }, 1000);
}

// ========== AUTO-HIDE FLASH MESSAGES ==========
document.addEventListener('DOMContentLoaded', () => {
    const flashMessages = document.querySelectorAll('.flash-success, .flash-error, .alert-error');
    
    flashMessages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            message.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                if (message.parentNode) {
                    message.parentNode.removeChild(message);
                }
            }, 500);
        }, 4000);
    });
});

// ========== SMOOTH SCROLL FOR ANCHOR LINKS ==========
document.addEventListener('DOMContentLoaded', () => {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// ========== FORM ENHANCEMENTS ==========
document.addEventListener('DOMContentLoaded', () => {
    // Enhanced form validation and feedback
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input[required]');
        
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                if (input.value.trim() === '') {
                    input.style.borderColor = '#ff6b6b';
                } else {
                    input.style.borderColor = '';
                }
            });
            
            input.addEventListener('input', () => {
                if (input.style.borderColor === 'rgb(255, 107, 107)') {
                    input.style.borderColor = '';
                }
            });
        });
    });
});

// ========== LOADING STATES ==========
function showLoading(element) {
    if (element) {
        element.classList.add('loading');
        element.style.pointerEvents = 'none';
    }
}

function hideLoading(element) {
    if (element) {
        element.classList.remove('loading');
        element.style.pointerEvents = '';
    }
}

// ========== ENHANCED MODAL FUNCTIONALITY ==========
document.addEventListener('DOMContentLoaded', () => {
    const modals = document.querySelectorAll('.modal');
    const modalTriggers = document.querySelectorAll('[data-modal-target]');
    const modalCloses = document.querySelectorAll('.modal-close');
    
    // Open modals
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const targetModal = document.querySelector(trigger.getAttribute('data-modal-target'));
            if (targetModal) {
                targetModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        });
    });
    
    // Close modals
    modalCloses.forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            const modal = closeBtn.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    });
    
    // Close modal on outside click
    modals.forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    });
    
    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            modals.forEach(modal => {
                if (modal.style.display === 'block') {
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });
        }
    });
});

// ========== INITIALIZE EVERYTHING ==========
document.addEventListener('DOMContentLoaded', () => {
    // Start countdown if countdown section exists
    if (document.getElementById('countdown')) {
        startCountdown();
    }
    
    console.log('✅ All FIANKA app features initialized!');
}); 