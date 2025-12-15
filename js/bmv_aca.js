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

  const getFilterFromURL = () => {
    const url = new URL(window.location.href);
    return (url.searchParams.get('filter') || 'all').trim();
  };

  const setFilterInURL = (filter) => {
    const url = new URL(window.location.href);
    if (!filter || filter === 'all') url.searchParams.delete('filter');
    else url.searchParams.set('filter', filter);
    history.pushState({ filter }, '', url);
  };

  const setActiveTab = (filter) => {
    tabs.forEach(t => t.classList.toggle('is-active', t.dataset.filter === filter));
  };

  const matches = (card, filter) => {
    if (filter === 'all') return true;
    return (card.dataset.terms || '')
      .split(',')
      .map(s => s.trim())
      .filter(Boolean)
      .includes(filter);
  };

  const applyFilter = (filter, updateURL = false) => {
    cards.forEach(card => {
      card.style.display = matches(card, filter) ? '' : 'none';
    });

    setActiveTab(filter);
    if (updateURL) setFilterInURL(filter);
  };

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      applyFilter(tab.dataset.filter || 'all', true);
    });
  });

  // init
  const initial = getFilterFromURL();
  const tabSlugs = new Set(Array.from(tabs).map(t => t.dataset.filter));
  applyFilter(tabSlugs.has(initial) ? initial : 'all', false);

  // back/forward
  window.addEventListener('popstate', () => {
    const f = getFilterFromURL();
    applyFilter(tabSlugs.has(f) ? f : 'all', false);
  });
});


console.log("js end");
