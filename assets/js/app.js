// SaloneHub Main JavaScript
document.addEventListener('DOMContentLoaded', () => {
  // Initialize all components
  initMobileMenu();
  initDarkMode();
  initServiceModal();
  initSearchFilters();
  initAnimations();
  initPWA();
  
  // Legacy theme handling
  const html = document.body;
  const themeBtn = document.getElementById('theme-toggle');
  const themeIcon = document.getElementById('theme-icon');
  const savedTheme = localStorage.getItem('salonehub-theme');
  if (savedTheme === 'dark') {
    html.dataset.theme = 'dark';
    html.classList.add('dark');
    if (themeIcon) themeIcon.textContent = '☀️';
  }
  themeBtn?.addEventListener('click', () => {
    const isDark = html.dataset.theme === 'dark';
    html.dataset.theme = isDark ? 'light' : 'dark';
    html.classList.toggle('dark');
    localStorage.setItem('salonehub-theme', isDark ? 'light' : 'dark');
    if (themeIcon) themeIcon.textContent = isDark ? '🌙' : '☀️';
  });

  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  menuToggle?.addEventListener('click', () => {
    mobileMenu?.classList.toggle('open');
  });

  const searchToggle = document.getElementById('search-toggle');
  const heroSearchInput = document.getElementById('hero-search');
  searchToggle?.addEventListener('click', () => {
    heroSearchInput?.focus();
    heroSearchInput?.scrollIntoView({ behavior: 'smooth', block: 'center' });
  });

  // Hero search redirects to services page with query
  heroSearchInput?.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
      const query = heroSearchInput.value.trim();
      if (query) {
        window.location.href = `services.php?search=${encodeURIComponent(query)}`;
      } else {
        window.location.href = 'services.php';
      }
    }
  });

  // Auto-focus search on services page if query param exists
  const urlParams = new URLSearchParams(window.location.search);
  const searchParam = urlParams.get('search');
  if (searchParam) {
    const serviceSearchInput = document.getElementById('service-search');
    if (serviceSearchInput) {
      serviceSearchInput.value = searchParam;
      filterCards();
      serviceSearchInput.focus();
      // Scroll to search bar smoothly
      serviceSearchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  }

  // Enhanced Modal System with smooth animations
  const modal = document.getElementById('service-modal');
  const modalContent = document.getElementById('modal-content');
  const closeModalBtn = document.getElementById('close-modal');
  
  const openModal = (content) => {
    if (!modal || !modalContent) return;
    modalContent.innerHTML = content;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scroll
    // Focus trap for accessibility
    closeModalBtn?.focus();
  };
  
  const closeModal = () => {
    if (!modal) return;
    modal.classList.add('hidden');
    document.body.style.overflow = ''; // Restore scroll
  };
  
  closeModalBtn?.addEventListener('click', closeModal);
  
  // Close on overlay click
  modal?.addEventListener('click', (e) => {
    if (e.target === modal || e.target.classList.contains('modal-overlay')) {
      closeModal();
    }
  });
  
  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modal?.classList.contains('hidden')) {
      closeModal();
    }
  });
  
  // Service detail buttons
  document.querySelectorAll('[data-service]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const details = btn.dataset.service;
      if (details) {
        openModal(details);
      }
    });
  });

  const searchInput = document.getElementById('service-search');
  const agencyFilter = document.getElementById('filter-agency');
  const regionFilter = document.getElementById('filter-region');
  const cards = document.querySelectorAll('[data-service-card]');
  const filterCards = () => {
    const term = (searchInput?.value || '').toLowerCase();
    const agency = agencyFilter?.value || '';
    const region = regionFilter?.value || '';
    cards.forEach(card => {
      const text = card.dataset.search || '';
      const agencyMatch = !agency || card.dataset.agency === agency;
      const regionMatch = !region || card.dataset.region === region;
      const termMatch = text.includes(term);
      card.classList.toggle('hidden', !(agencyMatch && regionMatch && termMatch));
    });
  };
  [searchInput, agencyFilter, regionFilter].forEach(el => {
    el?.addEventListener('input', filterCards);
    el?.addEventListener('change', filterCards);
  });

  const districtSelect = document.getElementById('district-filter');
  const repCards = document.querySelectorAll('[data-rep-card]');
  districtSelect?.addEventListener('change', () => {
    const district = districtSelect.value;
    repCards.forEach(card => {
      const matches = !district || card.dataset.district === district;
      card.classList.toggle('hidden', !matches);
    });
  });

  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('service-worker.js').catch(console.error);
  }
});

// Mobile Menu Toggle
function initMobileMenu() {
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('open');
            
            // Animate hamburger menu
            const spans = menuToggle.querySelectorAll('span');
            spans.forEach((span, index) => {
                if (mobileMenu.classList.contains('open')) {
                    if (index === 0) span.style.transform = 'rotate(45deg) translate(5px, 5px)';
                    if (index === 1) span.style.opacity = '0';
                    if (index === 2) span.style.transform = 'rotate(-45deg) translate(7px, -6px)';
                } else {
                    span.style.transform = 'none';
                    span.style.opacity = '1';
                }
            });
        });
    }
}

// Dark Mode Toggle
function initDarkMode() {
    const darkToggle = document.querySelector('.dark-toggle');
    const body = document.body;
    
    // Check for saved theme preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        body.classList.add('dark-mode');
        if (darkToggle) darkToggle.textContent = '☀️ Light';
    }
    
    if (darkToggle) {
        darkToggle.addEventListener('click', function() {
            body.classList.toggle('dark-mode');
            
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                darkToggle.textContent = '☀️ Light';
            } else {
                localStorage.setItem('theme', 'light');
                darkToggle.textContent = '🌙 Dark';
            }
        });
    }
}

// Service Modal Functionality
function initServiceModal() {
    const modal = document.getElementById('service-modal');
    const modalContent = document.getElementById('modal-content');
    const closeModal = document.getElementById('close-modal');
    
    // Open modal function
    window.openServiceModal = function(serviceId) {
        showLoadingSkeleton();
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Fetch service details
        fetch(`backend/api/services.php?id=${serviceId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayServiceDetails(data.service);
                } else {
                    showError('Failed to load service details');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Network error occurred');
            });
    };
    
    // Close modal
    if (closeModal) {
        closeModal.addEventListener('click', closeServiceModal);
    }
    
    // Close on overlay click
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeServiceModal();
            }
        });
    }
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeServiceModal();
        }
    });
    
    function closeServiceModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    function showLoadingSkeleton() {
        modalContent.innerHTML = `
            <div class="animate-pulse">
                <div class="h-8 bg-gray-300 rounded mb-4"></div>
                <div class="h-4 bg-gray-300 rounded mb-2"></div>
                <div class="h-4 bg-gray-300 rounded mb-2"></div>
                <div class="h-4 bg-gray-300 rounded w-3/4"></div>
            </div>
        `;
    }
    
    function displayServiceDetails(service) {
        modalContent.innerHTML = `
            <h3 class="text-2xl font-bold mb-4" style="color: var(--accent-gold);">${service.name}</h3>
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-glass p-4 rounded-lg border border-glass-border">
                        <h4 class="font-semibold mb-2">💰 Fee</h4>
                        <p class="text-accent-gold font-bold">${service.fee}</p>
                    </div>
                    <div class="bg-glass p-4 rounded-lg border border-glass-border">
                        <h4 class="font-semibold mb-2">⏱️ Processing Time</h4>
                        <p>${service.processing_time}</p>
                    </div>
                </div>
                
                <div class="bg-glass p-4 rounded-lg border border-glass-border">
                    <h4 class="font-semibold mb-2">🏢 Agency</h4>
                    <p>${service.agency}</p>
                </div>
                
                <div class="bg-glass p-4 rounded-lg border border-glass-border">
                    <h4 class="font-semibold mb-2">📋 Required Documents</h4>
                    <p>${service.documents}</p>
                </div>
                
                <div class="bg-glass p-4 rounded-lg border border-glass-border">
                    <h4 class="font-semibold mb-2">✅ Eligibility</h4>
                    <p>${service.eligibility}</p>
                </div>
                
                <div class="bg-glass p-4 rounded-lg border border-glass-border">
                    <h4 class="font-semibold mb-2">📍 Locations</h4>
                    <p>${service.locations}</p>
                </div>
                
                <div class="bg-glass p-4 rounded-lg border border-glass-border">
                    <h4 class="font-semibold mb-2">📞 Contacts</h4>
                    <p>${service.contacts}</p>
                </div>
                
                ${service.notes ? `
                <div class="bg-red-900 bg-opacity-20 p-4 rounded-lg border border-red-500 border-opacity-30">
                    <h4 class="font-semibold mb-2 text-red-400">⚠️ Important Notes</h4>
                    <p class="text-red-300">${service.notes}</p>
                </div>
                ` : ''}
                
                <div class="text-sm text-muted">
                    <p>Last verified: ${new Date(service.last_verified).toLocaleDateString()}</p>
                </div>
            </div>
        `;
    }
    
    function showError(message) {
        modalContent.innerHTML = `
            <div class="text-center py-8">
                <div class="text-red-400 text-6xl mb-4">⚠️</div>
                <h3 class="text-xl font-bold mb-2">Error</h3>
                <p class="text-muted">${message}</p>
                <button onclick="closeServiceModal()" class="btn btn-primary mt-4">Close</button>
            </div>
        `;
    }
}

// Search and Filter Functionality
function initSearchFilters() {
    const searchInput = document.getElementById('search-services');
    const agencyFilter = document.getElementById('agency-filter');
    const regionFilter = document.getElementById('region-filter');
    
    if (searchInput) {
        searchInput.addEventListener('input', debounce(filterServices, 300));
    }
    
    if (agencyFilter) {
        agencyFilter.addEventListener('change', filterServices);
    }
    
    if (regionFilter) {
        regionFilter.addEventListener('change', filterServices);
    }
    
    function filterServices() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const selectedAgency = agencyFilter ? agencyFilter.value : '';
        const selectedRegion = regionFilter ? regionFilter.value : '';
        
        const serviceCards = document.querySelectorAll('.service-card');
        
        serviceCards.forEach(card => {
            const serviceName = card.querySelector('h3').textContent.toLowerCase();
            const agency = card.dataset.agency || '';
            const region = card.dataset.region || '';
            
            const matchesSearch = serviceName.includes(searchTerm);
            const matchesAgency = !selectedAgency || agency === selectedAgency;
            const matchesRegion = !selectedRegion || region === selectedRegion;
            
            if (matchesSearch && matchesAgency && matchesRegion) {
                card.style.display = 'block';
                card.style.animation = 'fadeIn 0.3s ease';
            } else {
                card.style.display = 'none';
            }
        });
    }
}

// Smooth Animations
function initAnimations() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all cards and sections
    document.querySelectorAll('.service-card, .rep-card, .stat-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}

// PWA Functionality
function initPWA() {
    // Register service worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js')
                .then(registration => {
                    console.log('SW registered: ', registration);
                })
                .catch(registrationError => {
                    console.log('SW registration failed: ', registrationError);
                });
        });
    }
    
    // Install prompt
    let deferredPrompt;
    
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        
        // Show install button
        const installBtn = document.getElementById('install-btn');
        if (installBtn) {
            installBtn.style.display = 'block';
            installBtn.addEventListener('click', () => {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    }
                    deferredPrompt = null;
                });
            });
        }
    });
}

// Utility Functions
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

// Contact Representative
function contactRepresentative(email, name) {
    const subject = encodeURIComponent(`Inquiry from SaloneHub - ${name}`);
    const body = encodeURIComponent(`Dear ${name},\n\nI am writing to you through SaloneHub regarding...\n\nBest regards,`);
    window.open(`mailto:${email}?subject=${subject}&body=${body}`);
}

// Toast notifications
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--accent-gold);
        color: var(--dark-bg);
        padding: 1rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        z-index: 9999;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

