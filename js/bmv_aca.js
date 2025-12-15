////////////////////////
/// (bmv_aca) js
/// ////////////////////

console.log("js start");

// Sticky nav
const navMain = document.querySelector('.nav-main');
if (navMain) {
    const toggleSticky = () => {
        const isStuck = window.scrollY > 0;
        navMain.classList.toggle('is-sticky', isStuck);
    };

    window.addEventListener('scroll', toggleSticky, { passive: true });
    toggleSticky(); // Check on load
}

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.querySelector('.nav-main .toggle');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    const mobileMenuClose = document.querySelector('.mobile-menu-close');
    const openIcon = document.querySelector('.toggle-icon--open');
    const closeIcon = document.querySelector('.toggle-icon--close');

    if (!toggleButton || !mobileMenuOverlay) return;

    const openMenu = () => {
        toggleButton.setAttribute('aria-expanded', 'true');
        mobileMenuOverlay.setAttribute('aria-hidden', 'false');
        mobileMenuOverlay.classList.add('is-open');
        // CSS zorgt voor het tonen/verbergen via aria-expanded
    };

    const closeMenu = () => {
        toggleButton.setAttribute('aria-expanded', 'false');
        mobileMenuOverlay.setAttribute('aria-hidden', 'true');
        mobileMenuOverlay.classList.remove('is-open');
        // CSS zorgt voor het tonen/verbergen via aria-expanded
    };

    // Toggle button click
    toggleButton.addEventListener('click', () => {
        const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
        if (isExpanded) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // Close button click
    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMenu);
    }

    // Sluit menu bij klik buiten overlay
    mobileMenuOverlay.addEventListener('click', (e) => {
        if (e.target === mobileMenuOverlay) {
            closeMenu();
        }
    });

    // Initial state wordt bepaald door CSS (aria-expanded="false" is default)
});

// FAQ accordion
document.addEventListener('DOMContentLoaded', () => {
  const faqButtons = document.querySelectorAll('.accordion-list__question');
  if (faqButtons.length) {
    faqButtons.forEach((btn) => {
      btn.addEventListener('click', () => {
        const isExpanded = btn.getAttribute('aria-expanded') === 'true';
        const targetId = btn.getAttribute('aria-controls');
        const answer = targetId ? document.getElementById(targetId) : null;

        // Optioneel: één tegelijk openhouden
        faqButtons.forEach((otherBtn) => {
          const otherId = otherBtn.getAttribute('aria-controls');
          const otherAnswer = otherId ? document.getElementById(otherId) : null;
          const shouldOpen = otherBtn === btn && !isExpanded;

          otherBtn.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
          if (otherAnswer) {
            if (shouldOpen) {
              otherAnswer.removeAttribute('hidden');
            } else {
              otherAnswer.setAttribute('hidden', '');
            }
          }
        });
      });
    });
  }
});

// block-filter
document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.filter-tab');
  const wrap = document.querySelector('[data-cards-wrap]');
  const cards = wrap ? Array.from(wrap.querySelectorAll('[data-course-card]')) : [];
  if (!tabs.length || !wrap || !cards.length) return;

  const STAGGER = true;
  const STAGGER_STEP = 40; // iets trager/relaxter

  const FLIP_DURATION = 650; // langzamer
  const FLIP_EASING = 'cubic-bezier(.22,1,.36,1)'; // “easeOutQuint”-achtig

  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const getFilterFromURL = () => {
    const url = new URL(window.location.href);
    return (url.searchParams.get('filter') || 'all').trim();
  };

  const setFilterInURL = (filter) => {
    const url = new URL(window.location.href);
    if (!filter || filter === 'all') url.searchParams.delete('filter');
    else url.searchParams.set('filter', filter);
    window.history.pushState({ filter }, '', url);
  };

  const setActiveTab = (filter) => {
    tabs.forEach(t => t.classList.toggle('is-active', t.dataset.filter === filter));
  };

  const matches = (card, filter) => {
    if (filter === 'all') return true;
    const terms = (card.dataset.terms || '')
      .split(',')
      .map(s => s.trim())
      .filter(Boolean);
    return terms.includes(filter);
  };

  const measure = () => {
    const map = new Map();
    cards.forEach(el => map.set(el, el.getBoundingClientRect()));
    return map;
  };

  // helper: “collapse” hidden items zonder display:none
  const collapseHidden = () => {
    cards.forEach(card => {
      if (!card.classList.contains('is-hidden')) {
        card.style.height = '';
        card.style.marginTop = '';
        card.style.marginBottom = '';
        return;
      }
      // netjes inklappen zodat er geen gaten blijven
      const cs = getComputedStyle(card);
      card.style.height = '0px';
      card.style.marginTop = '0px';
      card.style.marginBottom = '0px';
      // padding via inner wrappers? dan laten we die met opacity wegvallen, layout blijft clean
    });
  };

  const uncollapseAll = () => {
    cards.forEach(card => {
      card.style.height = '';
      card.style.marginTop = '';
      card.style.marginBottom = '';
    });
  };

  // zet alle cards die matchen vooraan in de DOM zodat ze visueel opschuiven
  const reorderCards = (filter) => {
    const matching = [];
    const nonMatching = [];
    cards.forEach(card => (matches(card, filter) ? matching : nonMatching).push(card));
    [...matching, ...nonMatching].forEach(card => wrap.appendChild(card));
  };

  const applyFilter = (filter, { updateURL = false } = {}) => {
    // 1) uncollapse eerst zodat we goede metingen hebben
    uncollapseAll();

    const first = measure();

    // 2) zorg dat de matchende kaarten fysiek vooraan staan
    reorderCards(filter);

    // 2) toggle hidden class (zachte fade/scale/blur)
    cards.forEach((card, i) => {
      const show = matches(card, filter);

      card.classList.toggle('is-hidden', !show);

      if (STAGGER) {
        card.classList.remove('is-stagger');
        card.style.removeProperty('--stagger-delay');
        if (show) {
          card.style.setProperty('--stagger-delay', `${i * STAGGER_STEP}ms`);
          card.classList.add('is-stagger');
        }
      }
    });

    // 3) na een korte tick: collapse hidden zodat layout echt sluit
    // (zonder harde cut in zichtbaarheid)
    if (!prefersReduced) {
      setTimeout(() => {
        collapseHidden();

        // 4) FLIP reflow animatie (relaxed)
        const last = measure();

        cards.forEach(card => {
          if (card.classList.contains('is-hidden')) return;

          const a = first.get(card);
          const b = last.get(card);
          if (!a || !b) return;

          const dx = a.left - b.left;
          const dy = a.top - b.top;
          if (!dx && !dy) return;

          card.animate(
  [
    { transform: `translate(${dx}px, ${dy}px)` },
    { transform: 'translate(0, 0)' }
  ],
  {
    duration: FLIP_DURATION,
    easing: FLIP_EASING,
    composite: 'add' // <-- voorkomt dat dit de CSS transform "overschrijft"
  }
);

        });
      }, 60);
    } else {
      collapseHidden();
    }

    setActiveTab(filter);
    if (updateURL) setFilterInURL(filter);
  };

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const filter = tab.dataset.filter || 'all';
      applyFilter(filter, { updateURL: true });
    });
  });

  const initial = getFilterFromURL();
  const tabSlugs = new Set(Array.from(tabs).map(t => t.dataset.filter));
  const safeInitial = tabSlugs.has(initial) ? initial : 'all';
  applyFilter(safeInitial, { updateURL: safeInitial !== initial });

  window.addEventListener('popstate', () => {
    const f = getFilterFromURL();
    const safe = tabSlugs.has(f) ? f : 'all';
    applyFilter(safe, { updateURL: false });
  });
});





console.log("js end");
