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

// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', () => {
  const toggleButton = document.querySelector('.nav-main .toggle');
  const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
  
  if (toggleButton && mobileMenuOverlay) {
    toggleButton.addEventListener('click', () => {
      const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';

      // Toggle aria-expanded
      toggleButton.setAttribute('aria-expanded', !isExpanded);

      // Toggle menu overlay
      const open = !isExpanded;
      mobileMenuOverlay.classList.toggle('is-open', open);

      // Lock page scroll while menu is open
      document.body.classList.toggle('mobile-menu-open', open);
    });
  }
});

// FAQ Accordion
document.addEventListener('DOMContentLoaded', () => {
  const questions = document.querySelectorAll('.accordion-list__question');
  
  questions.forEach(question => {
    question.addEventListener('click', () => {
      const isExpanded = question.getAttribute('aria-expanded') === 'true';
      const answerId = question.getAttribute('aria-controls');
      const answer = document.getElementById(answerId);
      
      if (!answer) return;
      
      // Toggle aria-expanded
      question.setAttribute('aria-expanded', !isExpanded);
      
      // Toggle hidden attribute
      if (isExpanded) {
        answer.setAttribute('hidden', '');
      } else {
        answer.removeAttribute('hidden');
      }
    });
  });
});

console.log("js end");




// SCROLL REVEAL - OPTIMIZED FOR PERFORMANCE - FIXED: Don't hide already visible elements
(function() {
  'use strict';
  
  var processed = {};
  var observer = null;
  var isRunning = false;
  
  // Create observer ONCE
  function getObserver() {
    if (observer) return observer;
    
    observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          var el = entry.target;
          el.style.opacity = '1';
          el.style.transform = 'translateY(0)';
          observer.unobserve(el);
        }
      });
    }, { 
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    });
    
    return observer;
  }
  
  function doReveal() {
    // Prevent multiple simultaneous runs
    if (isRunning) return;
    isRunning = true;
    
    var blocks = document.querySelectorAll('.block');
    if (!blocks.length) {
      isRunning = false;
      return;
    }
    
    var obs = getObserver();
    var count = 0;
    
    for (var i = 0; i < blocks.length; i++) {
      var block = blocks[i];
      if (block.closest('nav, .nav-main, header')) continue;
      
      var container = block.querySelector('.block-content') || block.querySelector('.block-inner');
      if (!container) continue;
      
      // Only get content elements, not all divs
      var all = container.querySelectorAll('h1, h2, h3, h4, h5, h6, p, ul, ol, li, a, button, img, .row, [class*="title"], [class*="text"], [class*="description"]');
      
      for (var j = 0; j < all.length; j++) {
        var el = all[j];
        var elId = el.getAttribute('data-reveal-id');
        
        // Create unique ID if not exists
        if (!elId) {
          elId = 'reveal-' + count++;
          el.setAttribute('data-reveal-id', elId);
        }
        
        // Skip if already processed
        if (processed[elId]) continue;
        if (el.closest('nav')) continue;
        
        // Check if already visible BEFORE applying styles
        var rect = el.getBoundingClientRect();
        var isAlreadyVisible = rect.top < window.innerHeight + 100 && rect.top > -100;
        
        // If element is already visible, skip it entirely (don't hide it!)
        if (isAlreadyVisible && !processed[elId]) {
          processed[elId] = true;
          continue; // Skip this element - it's already visible
        }
        
        processed[elId] = true;
        
        // Apply styles only to elements that are not yet visible
        el.style.opacity = '0';
        el.style.transform = 'translateY(40px)';
        el.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
        el.style.willChange = 'opacity, transform';
        
        // Observe for scroll
        obs.observe(el);
      }
    }
    
    isRunning = false;
  }
  
  // Run on load
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', doReveal);
  } else {
    doReveal();
  }
  
  // Run once more after delay for dynamic content
  setTimeout(doReveal, 1000);
  window.addEventListener('load', doReveal);
})();