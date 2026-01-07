////////////////////////
/// (bmv_aca) js
/// ////////////////////

console.log("js start");

// Sticky nav
(function() {
const navMain = document.querySelector('.nav-main');
    if (!navMain) return;
    
    // Zorg dat de class niet aanwezig is bij het laden
    navMain.classList.remove('is-sticky');
    
    const toggleSticky = () => {
        // Gebruik de daadwerkelijke hoogte van de navbar
        const navHeight = navMain.offsetHeight;
        const scrollY = window.scrollY || window.pageYOffset || document.documentElement.scrollTop;
        
        // Alleen sticky class toevoegen als er echt meer dan de nav height is gescrolld
        if (scrollY > navHeight) {
            navMain.classList.add('is-sticky');
        } else {
            navMain.classList.remove('is-sticky');
        }
    };

    // Initialiseer na volledige pagina load
    const initSticky = () => {
        toggleSticky();
    window.addEventListener('scroll', toggleSticky, { passive: true });
        window.addEventListener('resize', toggleSticky, { passive: true });
    };

    // Wacht tot alles geladen is
    if (document.readyState === 'complete') {
        setTimeout(initSticky, 100);
    } else {
        window.addEventListener('load', () => {
            setTimeout(initSticky, 100);
        });
}
})();

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

const closeMenu = () => {
  if (menu) {
    menu.classList.remove('is-open');
    setTimeout(() => {
      document.body.classList.remove('mobile-menu-open');
      document.body.style.top = '';
      window.scrollTo(0, scrollY);
    }, 400); // Match transition duration
    if (btn) {
      btn.setAttribute('aria-expanded', 'false');
    }
  }
};

if (btn && menu) {
  btn.addEventListener('click', () => {
    const isOpen = menu.classList.contains('is-open');
    
    if (!isOpen) {
      // Open menu - slide down from top
      scrollY = window.scrollY;
      document.body.classList.add('mobile-menu-open');
      document.body.style.top = `-${scrollY}px`;
      // Force reflow
      void menu.offsetHeight;
      // Trigger animation
      requestAnimationFrame(() => {
        menu.classList.add('is-open');
      });
      btn.setAttribute('aria-expanded', 'true');
    } else {
      closeMenu();
    }
  });
}

// Close button in mobile menu
const closeBtn = document.querySelector('.mobile-close');
if (closeBtn && menu) {
  closeBtn.addEventListener('click', () => {
    closeMenu();
  });
}

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
        // Sluiten - smooth slide up met transition
        // Fade out text eerst (sneller dan container)
        const textElements = answer.querySelectorAll('p, ul, ol');
        textElements.forEach(el => {
          el.style.transition = 'opacity 0.2s ease-out, transform 0.2s ease-out';
          el.style.opacity = '0';
          el.style.transform = 'translateY(-5px)';
        });
        // Korte delay voor text fade
        setTimeout(() => {
          // Meet eerst de huidige hoogte
          const currentHeight = answer.scrollHeight;
          // Zet max-height naar huidige hoogte
          answer.style.maxHeight = currentHeight + 'px';
          // Force reflow zodat browser de state ziet
          void answer.offsetHeight;
          // Nu animeren naar 0
          requestAnimationFrame(() => {
            answer.style.maxHeight = '0px';
          });
          setTimeout(() => {
            answer.setAttribute('hidden', '');
            // Reset text state
            textElements.forEach(el => {
              el.style.opacity = '';
              el.style.transform = '';
              el.style.transition = '';
            });
          }, 500);
        }, 50);
      } else {
        // Openen - smooth slide down met transition
        answer.removeAttribute('hidden');
        // Reset text reveal state
        const textElements = answer.querySelectorAll('p, ul, ol');
        textElements.forEach(el => {
          el.style.opacity = '0';
          el.style.transform = 'translateY(10px)';
        });
        // Zet eerst op 0px (start state)
        answer.style.maxHeight = '0px';
        // Force reflow
        void answer.offsetHeight;
        // Meet de volledige hoogte
        const targetHeight = answer.scrollHeight;
        // Animeer naar volledige hoogte
        answer.style.maxHeight = targetHeight + 'px';
        // Reveal text na korte delay
        setTimeout(() => {
          textElements.forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
          });
        }, 150);
        // Na animatie, reset zodat het natuurlijk kan groeien
        setTimeout(() => {
          answer.style.maxHeight = '';
        }, 350);
      }
    });
  });
});


// SCROLL REVEAL
(function() {
  'use strict';
  var processed = {};
  var observer = null;

  function revealElement(el) {
    el.style.opacity = '1';
    el.style.transform = 'translateY(0)';
    el.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
    el.style.willChange = 'opacity, transform';
  }

  function hideElement(el) {
    el.style.opacity = '0';
    el.style.transform = 'translateY(40px)';
    el.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
    el.style.willChange = 'opacity, transform';
  }

  function getObserver() {
    if (observer) return observer;
    observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          revealElement(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });
    return observer;
  }

  function doReveal() {
    var blocks = document.querySelectorAll('.block');
    if (!blocks.length) return;
    var obs = getObserver();
    var count = 0;

    blocks.forEach(function(block) {
      var container = block.querySelector('.block-content') || block.querySelector('.block-inner');
      if (!container) return;

      var all = container.querySelectorAll('h1,h2,h3,h4,h5,h6,p,ul,ol,li,a,button,img,.row,[class*="title"],[class*="text"],[class*="description"]');
      
      all.forEach(function(el) {
        var elId = el.getAttribute('data-reveal-id');
        if (!elId) {
          elId = 'reveal-' + count++;
          el.setAttribute('data-reveal-id', elId);
        }
        if (processed[elId]) return;
        processed[elId] = true;

        var rect = el.getBoundingClientRect();
        var isInView = rect.top < window.innerHeight && rect.bottom > 0;

        if (isInView) {
          // direct zichtbaar maken voor content bovenaan (geen animatie delay)
          revealElement(el);
        } else {
          // eerst verborgen, observer voor scroll
          hideElement(el);
          obs.observe(el);
        }
      });
    });
  }

  // Run on DOMContentLoaded
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', doReveal);
  } else {
    doReveal();
  }
  
  // Also run on window.onload to ensure content bovenaan direct zichtbaar is
  window.addEventListener('load', function() {
    doReveal();
  });
})();
