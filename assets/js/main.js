/* =========================================================
   Mandoca Studio — interacciones del sitio
   JavaScript puro (sin librerías). Funciona igual en:
   - WordPress (con o sin Elementor), y
   - la vista previa estática (preview/index.html con Live Server).
   Todos los datos se leen del HTML (atributos data-*), nunca de PHP.
   ========================================================= */

(() => {
  'use strict';

  document.documentElement.classList.remove('no-js');

  // ¿Estamos dentro del editor de Elementor? (su vista previa lleva ?elementor-preview en la URL)
  const inEditor = () =>
    new URLSearchParams(window.location.search).has('elementor-preview') ||
    document.body.classList.contains('elementor-editor-active');

  // Busca elementos dentro de "root", incluido "root" si coincide.
  const $$ = (root, selector) => {
    const found = Array.from(root.querySelectorAll(selector));
    if (root instanceof Element && root.matches(selector)) found.unshift(root);
    return found;
  };

  // Marca un elemento como iniciado para no repetir eventos
  // (Elementor vuelve a pintar los widgets cada vez que se edita un campo).
  const firstTime = (el, name) => {
    const key = `mandoca${name}`;
    if (el.dataset[key]) return false;
    el.dataset[key] = 'on';
    return true;
  };

  /* 1. Menú a pantalla completa ----------------------------- */
  function initMenu(header) {
    const toggle = header.querySelector('.nav-toggle');
    const next = header.nextElementSibling;
    const panel = next && next.matches('.menu-panel') ? next : document.getElementById('menu-panel');
    if (!toggle || !panel) return;

    const labelOpen = toggle.dataset.labelOpen || 'Abrir menú';
    const labelClose = toggle.dataset.labelClose || 'Cerrar menú';
    const isOpen = () => toggle.getAttribute('aria-expanded') === 'true';

    const setOpen = (open) => {
      toggle.setAttribute('aria-expanded', String(open));
      toggle.setAttribute('aria-label', open ? labelClose : labelOpen);
      panel.classList.toggle('is-open', open);
      document.body.classList.toggle('menu-open', open); // la página no se mueve detrás del menú
      // animations.js escucha este aviso para animar los enlaces
      document.dispatchEvent(new CustomEvent('mandoca:menu', { detail: { open, panel } }));
      if (open) {
        const first = panel.querySelector('a');
        if (first) first.focus({ preventScroll: true });
      }
    };

    toggle.addEventListener('click', () => setOpen(!isOpen()));
    // Cierra el menú al elegir una opción o al pulsar Escape
    panel.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setOpen(false)));
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && isOpen()) {
        setOpen(false);
        toggle.focus();
      }
    });
  }

  /* 2. Borde de la cabecera al hacer scroll ---------------- */
  function initHeaderScroll(header) {
    const onScroll = () => header.classList.toggle('is-scrolled', window.scrollY > 10);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* 3. Fotos del equipo: iniciales si falta la imagen ------- */
  /*    (Las animaciones de entrada ahora viven en animations.js con ScrollTrigger.) */
  const initialsFrom = (name) => name.replace(/[^A-Za-z]/g, '').slice(0, 2).toUpperCase();

  function initPhoto(img) {
    const swap = () => {
      const member = img.closest('.member');
      const title = member && member.querySelector('h3');
      const box = document.createElement('div');
      box.className = 'member-initials';
      box.setAttribute('role', 'img');
      box.setAttribute('aria-label', img.alt);
      box.textContent = initialsFrom(title ? title.textContent : img.alt);
      img.replaceWith(box);
    };
    img.addEventListener('error', swap);
    if (img.complete && img.naturalWidth === 0) swap();
  }

  // Logo: si la imagen no existe, se oculta y queda el nombre en texto
  function initLogo(img) {
    const hide = () => img.classList.add('is-missing');
    img.addEventListener('error', hide);
    if (img.complete && img.naturalWidth === 0) hide();
  }

  /* 4. Filtro del equipo por área -------------------------- */
  function initTeam(section) {
    const buttons = section.querySelectorAll('.filter');
    const members = section.querySelectorAll('.member');

    buttons.forEach((btn) => {
      btn.addEventListener('click', () => {
        const area = btn.dataset.filter;

        buttons.forEach((b) => {
          const active = b === btn;
          b.classList.toggle('is-active', active);
          b.setAttribute('aria-pressed', String(active));
        });

        const apply = () => members.forEach((m) => {
          const show = area === 'todos' || m.dataset.area === area;
          m.classList.toggle('is-hidden', !show);
        });

        // Si animations.js está cargado, reacomoda las tarjetas con GSAP Flip.
        const motion = window.MandocaMotion;
        if (motion && motion.filterTeam) motion.filterTeam(section, apply);
        else apply();
      });
    });
  }

  /* 5. Validación del formulario de newsletter ------------- */
  function initNewsletter(form) {
    const input = form.querySelector('input[type="email"]');
    const msg = form.querySelector('.form-msg');
    if (!input || !msg) return;

    // Los textos se escriben en el panel (Elementor) y llegan como data-*
    const text = {
      empty: form.dataset.msgEmpty || 'Escribe tu correo para suscribirte.',
      invalid: form.dataset.msgInvalid || 'Ese correo no parece válido. Revisa que tenga @ y un dominio.',
      ok: form.dataset.msgOk || '¡Listo! Te avisaremos en {email}.',
    };

    const showMsg = (value, type) => {
      msg.textContent = value;
      msg.className = `form-msg is-${type}`;
    };

    const fail = (value) => {
      input.setAttribute('aria-invalid', 'true');
      showMsg(value, 'error');
      input.focus();
    };

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const value = input.value.trim();

      if (!value) return fail(text.empty);
      if (!input.checkValidity()) return fail(text.invalid);

      // Aquí iría el envío real (por ejemplo, a un servicio de newsletter).
      input.removeAttribute('aria-invalid');
      showMsg(text.ok.replace('{email}', value), 'ok');
      form.reset();
    });

    // Quita el error en cuanto la persona corrige el campo
    input.addEventListener('input', () => {
      if (input.getAttribute('aria-invalid') === 'true' && input.checkValidity()) {
        input.removeAttribute('aria-invalid');
        msg.textContent = '';
      }
    });
  }

  /* 6. Arranque -------------------------------------------- */
  function boot(root = document) {
    $$(root, '.site-header').forEach((header) => {
      if (!firstTime(header, 'Header')) return;
      initMenu(header);
      initHeaderScroll(header);
    });
    $$(root, '.brand-logo').forEach((img) => firstTime(img, 'Logo') && initLogo(img));
    $$(root, '.member-photo').forEach((img) => firstTime(img, 'Photo') && initPhoto(img));
    $$(root, '[data-team]').forEach((section) => firstTime(section, 'Team') && initTeam(section));
    $$(root, '.newsletter').forEach((form) => firstTime(form, 'Form') && initNewsletter(form));
    // Año automático en el pie de página
    $$(root, '[data-year]').forEach((el) => { el.textContent = new Date().getFullYear(); });
  }

  // Tarjetas del carrusel: al hacer clic, la vitrina abre ese juego.
  // (Se escucha en el documento para que también funcione en las copias del carrusel.)
  document.addEventListener('click', (e) => {
    const card = e.target.closest('.card[data-game]');
    if (card) document.dispatchEvent(new CustomEvent('mandoca:open-game', { detail: { game: card.dataset.game } }));
  });

  // En el editor de Elementor, cada widget editado se vuelve a pintar: lo iniciamos otra vez.
  // Estas variables solo existen dentro de WordPress; en la vista previa estática no pasa nada.
  if (window.jQuery) {
    window.jQuery(window).on('elementor/frontend/init', () => {
      const ef = window.elementorFrontend;
      if (!ef || !ef.hooks || !ef.isEditMode()) return;
      ef.hooks.addAction('frontend/element_ready/widget', ($scope) => boot($scope[0]));
    });
  }

  window.Mandoca = { boot, inEditor };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => boot());
  } else {
    boot();
  }
})();
