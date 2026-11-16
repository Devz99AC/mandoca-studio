/* =========================================================
   Mandoca Studio — animaciones
   GSAP + ScrollTrigger + Flip + SplitText (y Matter.js para la física).

   Reglas:
   - Solo se anima transform y opacity, para ir a 60 fps.
   - Todo va dentro de gsap.matchMedia(): con "reducir movimiento" no hay
     movimiento y el contenido se ve directo.
   - Los efectos de mouse solo corren en escritorio.
   - Funciona igual en WordPress/Elementor y en la vista previa estática:
     los datos se leen de atributos data-* del HTML, nunca de PHP.
   ========================================================= */

(() => {
  'use strict';

  const { gsap, ScrollTrigger, Flip, SplitText } = window;
  if (!gsap) return; // Sin GSAP el sitio se ve completo, solo que sin movimiento.

  gsap.registerPlugin(...[ScrollTrigger, Flip, SplitText].filter(Boolean));
  gsap.defaults({ ease: 'power3.out', duration: 0.8 });

  const html = document.documentElement;

  // ¿Estamos dentro del editor de Elementor? (main.js lo calcula)
  const inEditor = () => Boolean(window.Mandoca && window.Mandoca.inEditor && window.Mandoca.inEditor());

  // Busca elementos dentro de "root", incluido "root" si coincide.
  const $$ = (root, selector) => {
    const found = Array.from(root.querySelectorAll(selector));
    if (root instanceof Element && root.matches(selector)) found.unshift(root);
    return found;
  };

  // Lee un número de un atributo data-* con un valor por defecto.
  const num = (el, name, fallback) => {
    const value = parseFloat(el.dataset[name]);
    return Number.isFinite(value) ? value : fallback;
  };

  // API que usan main.js y physics: se completa en cada módulo.
  const api = (window.MandocaMotion = window.MandocaMotion || {});

  /* =========================================================
     Módulos
     Cada módulo anima un tipo de elemento:
       add(selector, init, { editor, desktop })
       - init(el, env) recibe el elemento y el entorno
         (env.motion = se permite movimiento, env.editor = editor de Elementor).
       - Puede devolver una función de limpieza.
       - editor: true  → también corre dentro del editor de Elementor.
       - desktop: true → solo en escritorio con mouse (y con movimiento).
     ========================================================= */
  const modules = [];
  const add = (selector, init, opts = {}) => modules.push({ selector, init, ...opts });

  /* ---------- 1. Intro del hero ----------
     El título entra palabra por palabra desde abajo con máscara, luego la
     cita y los botones. Duración total: 1.4 s. */
  add('.hero', (el, env) => {
    const hidden = el.querySelectorAll('.hero-inner > *, .scroll-hint, .hero-socials');
    if (!env.motion || env.editor) {
      gsap.set(hidden, { opacity: 1 }); // sin movimiento (o en el editor): todo visible al instante
      return undefined;
    }

    const title = el.querySelector('.hero-title');
    const eyebrow = el.querySelector('.hero-inner > .eyebrow');
    const quote = el.querySelector('.hero-quote');
    const buttons = el.querySelectorAll('.hero-actions .btn');
    const socials = el.querySelectorAll('.hero-socials a');
    const hint = el.querySelector('.scroll-hint');
    const split = title && SplitText ? SplitText.create(title, { type: 'words', mask: 'words' }) : null;

    gsap.set([title, el.querySelector('.hero-actions'), el.querySelector('.hero-socials')].filter(Boolean), { opacity: 1 });

    const tl = gsap.timeline({ defaults: { ease: 'power4.out' }, onComplete: () => split && split.revert() });
    if (eyebrow) tl.fromTo(eyebrow, { opacity: 0, y: 12 }, { opacity: 1, y: 0, duration: 0.5 }, 0);
    if (split) tl.from(split.words, { yPercent: 110, duration: 0.75, stagger: 0.06 }, 0.1);
    else if (title) tl.fromTo(title, { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.75 }, 0.1);
    if (quote) tl.fromTo(quote, { opacity: 0, y: 18 }, { opacity: 1, y: 0, duration: 0.55 }, 0.6);
    if (buttons.length) tl.fromTo(buttons, { opacity: 0, y: 18 }, { opacity: 1, y: 0, duration: 0.5, stagger: 0.08 }, 0.75);
    if (socials.length) tl.fromTo(socials, { opacity: 0, y: -10 }, { opacity: 1, y: 0, duration: 0.4, stagger: 0.05 }, 0.8);
    if (hint) tl.fromTo(hint, { opacity: 0 }, { opacity: 1, duration: 0.4 }, 1.0);

    return () => split && split.revert();
  }, { editor: true });

  /* ---------- 2a. Orbes del hero con el scroll ----------
     Cada orbe se desplaza a una velocidad distinta al bajar. */
  add('.hero', (el, env) => {
    if (!env.motion) return;
    el.querySelectorAll('.orb-layer').forEach((layer, i) => {
      gsap.to(layer, {
        yPercent: i % 2 ? -18 : 32,
        ease: 'none',
        scrollTrigger: { trigger: el, start: 'top top', end: 'bottom top', scrub: true },
      });
    });
  });

  /* ---------- 2b. Orbes del hero siguen al mouse (solo escritorio) ---------- */
  add('.hero', (el) => {
    const movers = Array.from(el.querySelectorAll('.orb-layer')).map((layer) => ({
      x: gsap.quickTo(layer, 'x', { duration: 1.4, ease: 'power3' }),
      y: gsap.quickTo(layer, 'y', { duration: 1.4, ease: 'power3' }),
      depth: num(layer, 'depth', 40),
    }));
    const onMove = (e) => {
      const r = el.getBoundingClientRect();
      const nx = (e.clientX - r.left) / r.width - 0.5;
      const ny = (e.clientY - r.top) / r.height - 0.5;
      movers.forEach((m) => {
        m.x(nx * m.depth);
        m.y(ny * m.depth);
      });
    };
    el.addEventListener('pointermove', onMove);
    return () => el.removeEventListener('pointermove', onMove);
  }, { desktop: true });

  /* ---------- Menú a pantalla completa ----------
     Al abrirlo, los enlaces grandes suben con máscara uno tras otro y
     después aparecen las redes. */
  add('.menu-panel', (panel, env) => {
    const texts = panel.querySelectorAll('.menu-panel-text');
    const nums = panel.querySelectorAll('.menu-panel-num');
    const foot = panel.querySelector('.menu-panel-foot');
    const onMenu = (e) => {
      if (e.detail.panel !== panel || !e.detail.open || !env.motion) return;
      gsap.timeline()
        .fromTo(texts, { yPercent: 110 }, { yPercent: 0, duration: 0.75, stagger: 0.06, ease: 'power4.out' }, 0.05)
        .fromTo(nums, { opacity: 0 }, { opacity: 1, duration: 0.4, stagger: 0.06 }, 0.2)
        .fromTo(foot, { opacity: 0, y: 16 }, { opacity: 1, y: 0, duration: 0.5 }, 0.35);
    };
    document.addEventListener('mandoca:menu', onMenu);
    return () => document.removeEventListener('mandoca:menu', onMenu);
  }, { editor: true });

  /* ---------- Entradas al hacer scroll ----------
     Reemplaza al IntersectionObserver de antes: cada bloque sube y aparece
     cuando entra en pantalla (una sola vez). */
  add('.studio-text, .filters, .cta-card', (el, env) => {
    if (!env.motion) return;
    gsap.from(el, {
      y: 48,
      opacity: 0,
      duration: 0.9,
      scrollTrigger: { trigger: el, start: 'top 88%', once: true },
    });
  });

  /* ---------- 9. Encabezados de sección ----------
     Primero crece la línea naranja del eyebrow, luego aparece su texto
     palabra por palabra y el título sube línea por línea con máscara. */
  add('.section-head', (el, env) => {
    if (!env.motion) return;
    const eyebrow = el.querySelector('.eyebrow');
    const title = el.querySelector('h2');
    const rest = el.querySelectorAll(':scope > :not(.eyebrow):not(h2)');
    const splits = [];
    // Divide un texto en palabras o líneas (y guarda la división para deshacerla al final).
    const split = (target, vars, key) => {
      if (!SplitText) return [target];
      const result = SplitText.create(target, vars);
      splits.push(result);
      return result[key];
    };
    const tl = gsap.timeline({
      scrollTrigger: { trigger: el, start: 'top 85%', once: true },
      onComplete: () => splits.forEach((s) => s.revert()), // devuelve el HTML original
    });

    if (eyebrow) {
      const words = split(eyebrow, { type: 'words' }, 'words');
      tl.fromTo(eyebrow, { '--line': 0 }, { '--line': 1, duration: 0.55, ease: 'power2.inOut' });
      tl.from(words, { opacity: 0, x: -12, stagger: 0.05, duration: 0.45 }, '-=0.1');
    }
    if (title) {
      const lines = split(title, { type: 'lines', mask: 'lines' }, 'lines');
      tl.from(lines, { yPercent: 110, duration: 0.85, stagger: 0.08, ease: 'power4.out' }, eyebrow ? '-=0.3' : 0);
    }
    if (rest.length) tl.from(rest, { y: 20, opacity: 0, duration: 0.6 }, '-=0.5');
  });

  /* @modules */

  /* =========================================================
     Arranque
     ========================================================= */
  const scopes = {};

  function run(scope, root) {
    modules.forEach((m) => {
      if (!scope.accepts(m)) return;
      if (scope.editor && !m.editor) return;
      $$(root, m.selector).forEach((el) => {
        const done = scope.started.get(el) || new Set();
        if (done.has(m)) return;
        done.add(m);
        scope.started.set(el, done);
        scope.ctx.add(() => {
          const cleanup = m.init(el, scope);
          if (typeof cleanup === 'function') scope.cleanups.push(cleanup);
        });
      });
    });
  }

  function createScope(name, conditions, accepts) {
    gsap.matchMedia().add(conditions, (ctx) => {
      const flags = ctx.conditions || {};
      const scope = {
        motion: name === 'desktop' ? true : Boolean(flags.motion),
        desktop: name === 'desktop',
        editor: inEditor(),
        ctx,
        accepts,
        cleanups: [],
        started: new WeakMap(),
      };
      scopes[name] = scope;
      run(scope, document);
      return () => {
        scope.cleanups.forEach((fn) => fn());
        delete scopes[name];
      };
    });
  }

  function start() {
    html.classList.add('motion-ready');
    // Todo lo general (con o sin movimiento).
    createScope(
      'main',
      { motion: '(prefers-reduced-motion: no-preference)', reduce: '(prefers-reduced-motion: reduce)' },
      (m) => !m.desktop
    );
    // Efectos de mouse: solo escritorio con puntero fino y con movimiento permitido.
    createScope(
      'desktop',
      '(prefers-reduced-motion: no-preference) and (min-width: 1024px) and (hover: hover) and (pointer: fine)',
      (m) => Boolean(m.desktop)
    );

    // En el editor de Elementor cada widget editado se vuelve a pintar: lo animamos otra vez.
    if (window.jQuery) {
      window.jQuery(window).on('elementor/frontend/init', () => {
        const ef = window.elementorFrontend;
        if (!ef || !ef.hooks || !ef.isEditMode()) return;
        ef.hooks.addAction('frontend/element_ready/widget', ($scope) => {
          Object.values(scopes).forEach((scope) => run(scope, $scope[0]));
        });
      });
    }
  }

  // Espera a que carguen las fuentes para que SplitText mida bien las palabras.
  const fontsReady = document.fonts && document.fonts.ready ? document.fonts.ready : Promise.resolve();
  Promise.race([fontsReady, new Promise((r) => setTimeout(r, 1200))]).then(start);
})();
