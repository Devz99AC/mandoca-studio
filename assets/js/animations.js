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
