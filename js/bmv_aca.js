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

// Swipe/scroll voor filter-tabs op mobiel & tablet (wanneer nodig)
document.addEventListener('DOMContentLoaded', () => {
  const filterTabsScroll = document.querySelector('.filter-tabs-scroll');
  const filterTabs = filterTabsScroll ? filterTabsScroll.querySelector('.filter-tabs') : null;

  if (filterTabsScroll && filterTabs) {
    let isDown = false;
    let startX;
    let scrollLeft;
    let isSwiperActive = false;

    const checkAndEnableSwipe = () => {
      // Reset eerst stijlen om de natuurlijke breedte te kunnen meten
      filterTabsScroll.style.overflowX = '';
      filterTabs.style.display = 'inline-flex'; 
      filterTabs.style.width = 'max-content';

      // Controleer of de inhoud breder is dan de container
      const needsSwipe = filterTabs.scrollWidth > filterTabsScroll.offsetWidth;

      if (needsSwipe) {
        isSwiperActive = true;
        filterTabsScroll.style.overflowX = 'auto';
        filterTabsScroll.style.webkitOverflowScrolling = 'touch';
        filterTabsScroll.style.scrollbarWidth = 'none'; 
        filterTabsScroll.style.cursor = 'grab';
        
        filterTabs.style.display = 'flex';
        filterTabs.style.gap = '0.5rem';
        filterTabs.style.flexWrap = 'nowrap';
        // Behoud de margin/padding zoals in je SCSS (margin: 0 15px)

        if (!document.getElementById('hide-scrollbar-style')) {
          const style = document.createElement('style');
          style.id = 'hide-scrollbar-style';
          style.innerHTML = '.filter-tabs-scroll::-webkit-scrollbar { display: none; }';
          document.head.appendChild(style);
        }
      } else {
        isSwiperActive = false;
        filterTabsScroll.style.overflowX = '';
        filterTabsScroll.style.cursor = '';
        filterTabs.style.display = ''; // Terug naar default (grid/flex uit CSS)
        filterTabs.style.width = '';
        filterTabs.style.gap = '';
        filterTabs.style.flexWrap = '';
      }
    };

    // Muis-sleep functionaliteit (alleen als swiper actief is)
    filterTabsScroll.addEventListener('mousedown', (e) => {
      if (!isSwiperActive) return;
      isDown = true;
      startX = e.pageX - filterTabsScroll.offsetLeft;
      scrollLeft = filterTabsScroll.scrollLeft;
      filterTabsScroll.style.cursor = 'grabbing';
    });

    filterTabsScroll.addEventListener('mouseleave', () => {
      if (isSwiperActive) filterTabsScroll.style.cursor = 'grab';
      isDown = false;
    });

    filterTabsScroll.addEventListener('mouseup', () => {
      if (isSwiperActive) filterTabsScroll.style.cursor = 'grab';
      isDown = false;
    });

    filterTabsScroll.addEventListener('mousemove', (e) => {
      if (!isDown || !isSwiperActive) return;
      e.preventDefault();
      const x = e.pageX - filterTabsScroll.offsetLeft;
      const walk = (x - startX) * 2;
      filterTabsScroll.scrollLeft = scrollLeft - walk;
    });

    // Initial check + resize
    checkAndEnableSwipe();
    window.addEventListener('resize', checkAndEnableSwipe);

    // Centreer actieve tab bij laden (alleen als swiper nodig is)
    const activeTab = filterTabs.querySelector('.filter-tab.is-active');
    if (activeTab) {
      setTimeout(() => {
        if (isSwiperActive) {
          const containerWidth = filterTabsScroll.offsetWidth;
          const tabWidth = activeTab.offsetWidth;
          const tabLeft = activeTab.offsetLeft;
          const scrollPos = tabLeft - (containerWidth / 2) + (tabWidth / 2);
          
          filterTabsScroll.scrollTo({
            left: scrollPos,
            behavior: 'smooth'
          });
        }
      }, 300);
    }
  }
});

// block-filter (Filtering logica)
document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.filter-tab');
  const wrap = document.querySelector('[data-cards-wrap]');
  const cards = wrap ? Array.from(wrap.querySelectorAll('[data-course-card]')) : [];
  if (!tabs.length || !wrap || !cards.length) return;

  const STAGGER = true;
  const STAGGER_STEP = 40; 
  const FLIP_DURATION = 650; 
  const FLIP_EASING = 'cubic-bezier(.22,1,.36,1)'; 
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

  const collapseHidden = () => {
    cards.forEach(card => {
      if (!card.classList.contains('is-hidden')) {
        card.style.height = '';
        card.style.marginTop = '';
        card.style.marginBottom = '';
        return;
      }
      card.style.height = '0px';
      card.style.marginTop = '0px';
      card.style.marginBottom = '0px';
    });
  };

  const uncollapseAll = () => {
    cards.forEach(card => {
      card.style.height = '';
      card.style.marginTop = '';
      card.style.marginBottom = '';
    });
  };

  const reorderCards = (filter) => {
    const matching = [];
    const nonMatching = [];
    cards.forEach(card => (matches(card, filter) ? matching : nonMatching).push(card));
    [...matching, ...nonMatching].forEach(card => wrap.appendChild(card));
  };

  const applyFilter = (filter, { updateURL = false } = {}) => {
    uncollapseAll();
    const first = measure();
    reorderCards(filter);

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

    if (!prefersReduced) {
      setTimeout(() => {
        collapseHidden();
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
              composite: 'add'
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
const btn = document.querySelector('.toggle');
const menu = document.querySelector('.nav-mobile');
let scrollY = 0;

btn.addEventListener('click', () => {
  const open = document.body.classList.toggle('mobile-menu-open');
  if (open) {
    scrollY = window.scrollY;
    document.body.style.top = `-${scrollY}px`;
    menu.classList.add('is-open');
    btn.setAttribute('aria-expanded', 'true');
  } else {
    document.body.classList.remove('mobile-menu-open');
    document.body.style.top = '';
    window.scrollTo(0, scrollY);
    menu.classList.remove('is-open');
    btn.setAttribute('aria-expanded', 'false');
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
      question.setAttribute('aria-expanded', !isExpanded);
      if (isExpanded) {
        answer.setAttribute('hidden', '');
      } else {
        answer.removeAttribute('hidden');
      }
    });
  });
});

// SCROLL REVEAL
(function() {
  'use strict';
  var processed = {};
  var observer = null;
  var isRunning = false;
  
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
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    return observer;
  }
  
  function doReveal() {
    if (isRunning) return;
    isRunning = true;
    var blocks = document.querySelectorAll('.block');
    if (!blocks.length) { isRunning = false; return; }
    var obs = getObserver();
    var count = 0;
    for (var i = 0; i < blocks.length; i++) {
      var block = blocks[i];
      if (block.closest('nav, .nav-main, header')) continue;
      var container = block.querySelector('.block-content') || block.querySelector('.block-inner');
      if (!container) continue;
      var all = container.querySelectorAll('h1, h2, h3, h4, h5, h6, p, ul, ol, li, a, button, img, .row, [class*="title"], [class*="text"], [class*="description"]');
      for (var j = 0; j < all.length; j++) {
        var el = all[j];
        var elId = el.getAttribute('data-reveal-id');
        if (!elId) {
          elId = 'reveal-' + count++;
          el.setAttribute('data-reveal-id', elId);
        }
        if (processed[elId]) continue;
        var rect = el.getBoundingClientRect();
        var isAlreadyVisible = rect.top < window.innerHeight + 100 && rect.top > -100;
        if (isAlreadyVisible && !processed[elId]) {
          processed[elId] = true;
          continue;
        }
        processed[elId] = true;
        el.style.opacity = '0';
        el.style.transform = 'translateY(40px)';
        el.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
        el.style.willChange = 'opacity, transform';
        obs.observe(el);
      }
    }
    isRunning = false;
  }
  
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', doReveal);
  } else {
    doReveal();
  }
  setTimeout(doReveal, 1000);
  window.addEventListener('load', doReveal);
})();

console.log("js end");