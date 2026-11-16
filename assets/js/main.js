/* =========================================================
   Mandoca Studio — interacciones del sitio
   JavaScript puro (sin librerías). Cada bloque es independiente.
   ========================================================= */

document.documentElement.classList.remove('no-js');

/* 1. Menú móvil ------------------------------------------- */
const toggle = document.querySelector('.nav-toggle');
const menu = document.getElementById('menu');

function closeMenu() {
  toggle.setAttribute('aria-expanded', 'false');
  toggle.setAttribute('aria-label', 'Abrir menú');
  menu.classList.remove('is-open');
}

toggle.addEventListener('click', () => {
  const open = toggle.getAttribute('aria-expanded') === 'true';
  toggle.setAttribute('aria-expanded', String(!open));
  toggle.setAttribute('aria-label', open ? 'Abrir menú' : 'Cerrar menú');
  menu.classList.toggle('is-open', !open);
});

// Cierra el menú al elegir una opción o al pulsar Escape
menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu));
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeMenu(); });

/* 2. Borde de la cabecera al hacer scroll ------------------ */
const header = document.querySelector('.site-header');
const onScroll = () => header.classList.toggle('is-scrolled', window.scrollY > 10);
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

/* 3. Animación de entrada de los bloques ------------------ */
const revealItems = document.querySelectorAll('.reveal');

if ('IntersectionObserver' in window) {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });
  revealItems.forEach((el) => observer.observe(el));
} else {
  revealItems.forEach((el) => el.classList.add('is-visible'));
}

/* 4. Fotos del equipo: iniciales si falta la imagen --------- */
function initialsFrom(name) {
  return name.replace(/[^A-Za-z]/g, '').slice(0, 2).toUpperCase();
}

document.querySelectorAll('.member-photo').forEach((img) => {
  const swap = () => {
    const name = img.closest('.member').querySelector('h3').textContent;
    const box = document.createElement('div');
    box.className = 'member-initials';
    box.setAttribute('role', 'img');
    box.setAttribute('aria-label', img.alt);
    box.textContent = initialsFrom(name);
    img.replaceWith(box);
  };
  img.addEventListener('error', swap);
  if (img.complete && img.naturalWidth === 0) swap();
});

// Logo: si no existe assets/img/logo.png, se oculta y queda el nombre en texto
const logo = document.querySelector('.brand-logo');
const hideLogo = () => logo.classList.add('is-missing');
logo.addEventListener('error', hideLogo);
if (logo.complete && logo.naturalWidth === 0) hideLogo();

/* 5. Filtro del equipo por área --------------------------- */
const filters = document.querySelectorAll('.filter');
const members = document.querySelectorAll('.member');

filters.forEach((btn) => {
  btn.addEventListener('click', () => {
    const area = btn.dataset.filter;

    filters.forEach((b) => {
      const active = b === btn;
      b.classList.toggle('is-active', active);
      b.setAttribute('aria-pressed', String(active));
    });

    members.forEach((m) => {
      const show = area === 'todos' || m.dataset.area === area;
      m.classList.toggle('is-hidden', !show);
      if (show) m.classList.add('is-visible');
    });
  });
});

/* 6. Validación del formulario de newsletter --------------- */
const form = document.querySelector('.newsletter');
const emailInput = form.querySelector('#email');
const msg = form.querySelector('.form-msg');

function showMsg(text, type) {
  msg.textContent = text;
  msg.className = `form-msg is-${type}`;
}

form.addEventListener('submit', (e) => {
  e.preventDefault();
  const value = emailInput.value.trim();

  if (!value) {
    emailInput.setAttribute('aria-invalid', 'true');
    showMsg('Escribe tu correo para suscribirte.', 'error');
    emailInput.focus();
    return;
  }
  if (!emailInput.checkValidity()) {
    emailInput.setAttribute('aria-invalid', 'true');
    showMsg('Ese correo no parece válido. Revisa que tenga @ y un dominio.', 'error');
    emailInput.focus();
    return;
  }

  // Aquí iría el envío real (por ejemplo, a un servicio de newsletter).
  emailInput.removeAttribute('aria-invalid');
  showMsg(`¡Listo! Te avisaremos en ${value}.`, 'ok');
  form.reset();
});

// Quita el error en cuanto la persona corrige el campo
emailInput.addEventListener('input', () => {
  if (emailInput.getAttribute('aria-invalid') === 'true' && emailInput.checkValidity()) {
    emailInput.removeAttribute('aria-invalid');
    msg.textContent = '';
  }
});

/* 7. Año automático en el pie de página -------------------- */
document.getElementById('year').textContent = new Date().getFullYear();
