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

document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.filter-tab');
  const cards = document.querySelectorAll('[data-course-card]');

  if (!tabs.length || !cards.length) return;

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const filter = tab.dataset.filter;

      tabs.forEach(t => t.classList.remove('is-active'));
      tab.classList.add('is-active');

      cards.forEach(card => {
        const term = card.dataset.term;

        if (filter === 'all' || term === filter) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
});



console.log("js end");
