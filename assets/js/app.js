document.addEventListener('DOMContentLoaded', () => {
  const html = document.body;
  const themeBtn = document.getElementById('theme-toggle');
  const themeIcon = document.getElementById('theme-icon');
  const savedTheme = localStorage.getItem('salonehub-theme');
  if (savedTheme === 'dark') {
    html.dataset.theme = 'dark';
    html.classList.add('dark');
    themeIcon.textContent = '☀️';
  }
  themeBtn?.addEventListener('click', () => {
    const isDark = html.dataset.theme === 'dark';
    html.dataset.theme = isDark ? 'light' : 'dark';
    html.classList.toggle('dark');
    localStorage.setItem('salonehub-theme', isDark ? 'light' : 'dark');
    themeIcon.textContent = isDark ? '🌙' : '☀️';
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

