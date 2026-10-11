import { reviews } from "/reviews.js";

// ─── Elements ───────────────────────────────────────────────────────────────
const siteNav        = document.getElementById('site-nav');
const productBtn     = document.getElementById('productBtn');
const dropDownLinks  = document.getElementById('dropDownLinks');
const megaOverlay    = document.getElementById('megaOverlay');
const hamburgerBtn   = document.getElementById('hamburgerBtn');
const mobileDrawer   = document.getElementById('mobileDrawer');
const drawerOverlay  = document.getElementById('drawerOverlay');
const closeDrawerBtn = document.getElementById('closeDrawerBtn');
const mobileAccBtn   = document.getElementById('mobileAccBtn');
const mobileAccContent = document.getElementById('mobileAccContent');
const testiTrack = document.getElementById('testiTrack');
const testiDots  = document.getElementById('testiDots');

// ─── Scroll: header transparency ────────────────────────────────────────────
function onScroll() {
  if (!siteNav) return;
  if (window.scrollY > 24) {
    siteNav.classList.add('scrolled');
  } else {
    siteNav.classList.remove('scrolled');
  }
}
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

// ─── Desktop mega menu ───────────────────────────────────────────────────────
function openMenu() {
  if (!dropDownLinks) return;
  dropDownLinks.classList.add('open');
  if (productBtn) productBtn.classList.add('active');
}
function closeMenu() {
  if (!dropDownLinks) return;
  dropDownLinks.classList.remove('open');
  if (productBtn) productBtn.classList.remove('active');
}

if (productBtn) {
  productBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    dropDownLinks.classList.contains('open') ? closeMenu() : openMenu();
  });
}
if (megaOverlay) {
  megaOverlay.addEventListener('click', closeMenu);
}
document.addEventListener('click', (e) => {
  if (dropDownLinks && !dropDownLinks.contains(e.target) && e.target !== productBtn) {
    closeMenu();
  }
});

// ─── Mobile drawer ───────────────────────────────────────────────────────────
function openDrawer() {
  if (mobileDrawer) mobileDrawer.classList.add('open');
}
function closeDrawer() {
  if (mobileDrawer) {
    mobileDrawer.classList.remove('open');
    // Also close accordion
    if (mobileAccContent) mobileAccContent.classList.remove('open');
    if (mobileAccBtn) mobileAccBtn.classList.remove('open');
  }
}

if (hamburgerBtn)   hamburgerBtn.addEventListener('click', openDrawer);
if (closeDrawerBtn) closeDrawerBtn.addEventListener('click', closeDrawer);
if (drawerOverlay)  drawerOverlay.addEventListener('click', closeDrawer);

// ─── Mobile flooring accordion ───────────────────────────────────────────────
if (mobileAccBtn) {
  mobileAccBtn.addEventListener('click', () => {
    const isOpen = mobileAccContent.classList.toggle('open');
    mobileAccBtn.classList.toggle('open', isOpen);
  });
}

// ─── Phone number auto-format ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  const phoneInputs = document.querySelectorAll('input[type="tel"]');
  phoneInputs.forEach((input) => {
    input.addEventListener('input', () => {
      const value = input.value.replace(/\D/g, '');
      if (value.length > 0) {
        const match = value.match(/^(\d{0,3})(\d{0,3})(\d{0,4})$/);
        input.value = match ? [match[1], match[2], match[3]].filter(Boolean).join('-') : value;
      }
    });
  });
});

// ─── Copyright year ──────────────────────────────────────────────────────────
document.querySelectorAll('.copyright-year').forEach(el => { el.textContent = new Date().getFullYear(); });

// ─── Scroll-reveal: col-img elements (.hidden → .show) ───────────────────────
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add('show');
    } else {
      entry.target.classList.remove('show');
    }
  });
});
document.querySelectorAll('.hidden').forEach((el) => observer.observe(el));

// ─── Scroll-reveal: sitewide fade-up animation ───────────────────────────────
(function initScrollReveal() {
  const selectors = [
    '.section-eyebrow',
    '.about-story-eyebrow',
    '.section-heading',
    '.section-body',
    '.benefit-item',
    '.about-value-card',
    '.brand-logo-card',
    '.brands-eyebrow',
    '.brands-heading',
    '.brands-sub',
    '.style-sample-img',
    '.about-main-photo',
    '.about-commitment-eyebrow',
    '.about-commitment-heading',
    '.about-founder',
    '.about-founders-divider',
    '.cta-banner-sub',
    '.contact-info-icon',
    '.contact-feature-icon',
    '.contact-feature-title',
    '.contact-feature-body',
    '.testi-card',
    '.nav-mega-card',
    '.product-card',
  ].join(',');

  // Stagger siblings inside grid containers
  ['.benefits-grid', '.brand-logos', '.about-values-cards', '.styles-grid', '.nav-mega-cards'].forEach(sel => {
    document.querySelectorAll(sel).forEach(grid => {
      Array.from(grid.children).forEach((child, i) => {
        child.dataset.srDelay = i * 80;
      });
    });
  });

  const srObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const delay = Number(entry.target.dataset.srDelay || 0);
      setTimeout(() => entry.target.classList.add('sr-visible'), delay);
      srObserver.unobserve(entry.target);
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll(selectors).forEach(el => {
    el.classList.add('sr');
    srObserver.observe(el);
  });
})();

// ─── Customer Reviews carousel ───────────────────────────────────────────────
if (testiTrack && reviews) {
  const shuffled = [...reviews].sort(() => Math.random() - 0.5);
  let idx = 0;

  testiTrack.innerHTML = shuffled.map(r => `
    <div class="testi-card">
      <div class="testi-quote-mark">“</div>
      <p class="testi-text">${r.review.replace(/\s+/g, ' ').trim()}</p>
      <hr class="testi-divider">
      <div class="testi-name">${r.name}</div>
      <div class="testi-stars">★★★★★</div>
    </div>`).join('');

  if (testiDots) {
    testiDots.innerHTML = shuffled.map((_, i) =>
      `<button class="testi-dot${i === 0 ? ' active' : ''}" data-i="${i}" aria-label="Review ${i + 1}"></button>`
    ).join('');
    testiDots.querySelectorAll('.testi-dot').forEach(dot =>
      dot.addEventListener('click', () => goTo(parseInt(dot.dataset.i)))
    );
  }

  function updatePosition() {
    const outer = testiTrack.parentElement;
    const card  = testiTrack.querySelector('.testi-card');
    if (!card) return;
    const outerW = outer.offsetWidth;
    const cardW  = card.offsetWidth;
    const margin = 12;
    const step   = cardW + margin * 2;
    const offset = (outerW - cardW) / 2 - margin - idx * step;
    testiTrack.style.transform = `translateX(${offset}px)`;
    if (testiDots) {
      testiDots.querySelectorAll('.testi-dot').forEach((d, i) =>
        d.classList.toggle('active', i === idx)
      );
    }
  }

  function goTo(i) { idx = i; updatePosition(); }
  function slideForward()  { goTo(idx < shuffled.length - 1 ? idx + 1 : 0); }
  function slideBackward() { goTo(idx > 0 ? idx - 1 : shuffled.length - 1); }

  const forwardBtn  = document.getElementById('forward');
  const backwardBtn = document.getElementById('backward');
  if (forwardBtn)  forwardBtn.addEventListener('click', slideForward);
  if (backwardBtn) backwardBtn.addEventListener('click', slideBackward);

  window.addEventListener('resize', updatePosition);
  requestAnimationFrame(updatePosition);
  setInterval(slideForward, 25000);
}

// ─── Contact page: two-form logic ───────────────────────────────────────────
(function initContactForms() {
  const tabs = document.querySelectorAll('.form-tab');
  if (!tabs.length) return;

  // Tab switching
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.form-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.form-panel').forEach(p => p.classList.remove('active'));
      tab.classList.add('active');
      const panel = document.getElementById(tab.dataset.panel);
      if (panel) panel.classList.add('active');
    });
  });

  // Option pill groups (radio-style selection)
  document.querySelectorAll('.form-option-group').forEach(group => {
    const btns  = group.querySelectorAll('.form-option-btn');
    const input = group.querySelector('input[type="hidden"]');
    const err   = group.querySelector('.form-option-required');
    btns.forEach(btn => {
      btn.addEventListener('click', () => {
        btns.forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        if (input) input.value = btn.dataset.value;
        if (err)   err.classList.remove('show');
      });
    });
  });

  // Estimate: step navigation
  const step1      = document.getElementById('estStep1');
  const step2      = document.getElementById('estStep2');
  const continueBtn = document.getElementById('estContinue');
  const backBtn    = document.getElementById('estBack');

  function showStep(n) {
    if (!step1 || !step2) return;
    step1.hidden = (n !== 1);
    step2.hidden = (n !== 2);
  }

  if (continueBtn) {
    continueBtn.addEventListener('click', () => {
      let valid = true;
      document.querySelectorAll('#estStep1 .form-option-group').forEach(group => {
        const input = group.querySelector('input[type="hidden"]');
        const err   = group.querySelector('.form-option-required');
        if (input && input.required && !input.value) {
          if (err) err.classList.add('show');
          valid = false;
        }
      });
      if (valid) showStep(2);
    });
  }
  if (backBtn) backBtn.addEventListener('click', () => showStep(1));

  // AJAX submission helper
  function bindSubmit(formId, successId, errorId) {
    const form    = document.getElementById(formId);
    const success = document.getElementById(successId);
    const error   = document.getElementById(errorId);
    if (!form) return;

    form.addEventListener('submit', async e => {
      e.preventDefault();
      if (!form.checkValidity()) { form.reportValidity(); return; }

      const btn  = form.querySelector('button[type="submit"]');
      const orig = btn ? btn.textContent : '';
      if (btn) { btn.disabled = true; btn.textContent = 'Sending…'; }
      if (success) success.hidden = true;
      if (error)   error.hidden   = true;

      try {
        const payload = Object.fromEntries(new FormData(form).entries());
        const res = await fetch('/send-email.php', {
          method:  'POST',
          headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
          body:    JSON.stringify(payload)
        });
        if (!res.ok) throw new Error();

        form.reset();
        form.querySelectorAll('.form-option-btn').forEach(b => b.classList.remove('selected'));
        form.querySelectorAll('.form-option-group input[type="hidden"]').forEach(i => i.value = '');
        if (formId === 'estimateForm') showStep(1);
        form.style.display = 'none';
        if (success) success.hidden = false;
      } catch {
        if (error) error.hidden = false;
        if (btn)   { btn.disabled = false; btn.textContent = orig; }
      }
    });
  }

  bindSubmit('contactForm',  'contactSuccess',  'contactError');
  bindSubmit('estimateForm', 'estimateSuccess', 'estimateError');
})();
