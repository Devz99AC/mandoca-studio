/* =========================================================
   Mandoca Studio — animaciones
   GSAP + ScrollTrigger + Flip + SplitText.

   Reglas:
   - Solo se anima transform y opacity, para ir a 60 fps.
   - Todo va dentro de gsap.matchMedia(): con "reducir movimiento" no hay
     movimiento y el contenido se ve directo.
   - Los efectos de mouse solo corren en escritorio.
   - Funciona igual en WordPress/Elementor y en la vista previa estática:
     los datos se leen de atributos data-* del HTML, nunca de PHP.
   ========================================================= */

(() => {
  "use strict";

  const { gsap, ScrollTrigger, Flip, SplitText } = window;
  if (!gsap) return; // Sin GSAP el sitio se ve completo, solo que sin movimiento.

  gsap.registerPlugin(...[ScrollTrigger, Flip, SplitText].filter(Boolean));
  gsap.defaults({ ease: "power3.out", duration: 0.8 });

  const html = document.documentElement;

  // ¿Estamos dentro del editor de Elementor? (main.js lo calcula)
  const inEditor = () =>
    Boolean(
      window.Mandoca && window.Mandoca.inEditor && window.Mandoca.inEditor(),
    );

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

  // Ejecuta "callback" cuando el elemento ya tenga ancho. En el editor de
  // Elementor los widgets a veces se crean antes de estar en pantalla.
  const whenSized = (el, callback) => {
    if (el.clientWidth > 0) {
      callback();
      return () => {};
    }
    const observer = new ResizeObserver(() => {
      if (el.clientWidth > 0) {
        observer.disconnect();
        callback();
      }
    });
    observer.observe(el);
    return () => observer.disconnect();
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
  const add = (selector, init, opts = {}) =>
    modules.push({ selector, init, ...opts });

  /* ---------- 1. Intro del hero ----------
     El título entra palabra por palabra desde abajo con máscara, luego la
     cita y los botones. Duración total: 1.4 s. */
  add(
    ".hero",
    (el, env) => {
      const hidden = el.querySelectorAll(
        ".hero-inner > *, .scroll-hint, .hero-socials",
      );
      if (!env.motion || env.editor) {
        gsap.set(hidden, { opacity: 1 }); // sin movimiento (o en el editor): todo visible al instante
        return undefined;
      }

      const title = el.querySelector(".hero-title");
      const eyebrow = el.querySelector(".hero-inner > .eyebrow");
      const quote = el.querySelector(".hero-quote");
      const buttons = el.querySelectorAll(".hero-actions .btn");
      const socials = el.querySelectorAll(".hero-socials a");
      const hint = el.querySelector(".scroll-hint");
      const split =
        title && SplitText
          ? SplitText.create(title, { type: "words", mask: "words" })
          : null;

      gsap.set(
        [
          title,
          el.querySelector(".hero-actions"),
          el.querySelector(".hero-socials"),
        ].filter(Boolean),
        { opacity: 1 },
      );

      const tl = gsap.timeline({
        defaults: { ease: "power4.out" },
        onComplete: () => split && split.revert(),
      });
      if (eyebrow)
        tl.fromTo(
          eyebrow,
          { opacity: 0, y: 12 },
          { opacity: 1, y: 0, duration: 0.5 },
          0,
        );
      if (split)
        tl.from(
          split.words,
          { yPercent: 110, duration: 0.75, stagger: 0.06 },
          0.1,
        );
      else if (title)
        tl.fromTo(
          title,
          { opacity: 0, y: 30 },
          { opacity: 1, y: 0, duration: 0.75 },
          0.1,
        );
      if (quote)
        tl.fromTo(
          quote,
          { opacity: 0, y: 18 },
          { opacity: 1, y: 0, duration: 0.55 },
          0.6,
        );
      if (buttons.length)
        tl.fromTo(
          buttons,
          { opacity: 0, y: 18 },
          { opacity: 1, y: 0, duration: 0.5, stagger: 0.08 },
          0.75,
        );
      if (socials.length)
        tl.fromTo(
          socials,
          { opacity: 0, y: -10 },
          { opacity: 1, y: 0, duration: 0.4, stagger: 0.05 },
          0.8,
        );
      if (hint)
        tl.fromTo(hint, { opacity: 0 }, { opacity: 1, duration: 0.4 }, 1.0);

      return () => split && split.revert();
    },
    { editor: true },
  );

  /* ---------- 7. Cabecera ----------
     - Al pasar la primera pantalla se pone fondo sólido.
     - Cuando es barra superior (celular, o el diseño "Top bar"), se oculta al
       bajar y aparece al subir. La barra lateral de escritorio siempre se ve. */
  add(".site-header", (header, env) => {
    const hero = document.querySelector(".hero");
    const isBar = () =>
      header.classList.contains("site-header--top") || window.innerWidth < 1024;

    const solid = ScrollTrigger.create({
      start: () =>
        Math.max(
          1,
          (hero ? hero.offsetHeight : window.innerHeight) - header.offsetHeight,
        ),
      end: "max",
      onToggle: (self) => header.classList.toggle("is-solid", self.isActive),
    });
    if (!env.motion) return () => solid.kill();

    let hidden = false;
    const setHidden = (value) => {
      if (value === hidden) return;
      hidden = value;
      gsap.to(header, {
        yPercent: value ? -100 : 0,
        duration: 0.4,
        ease: "power2.out",
        overwrite: true,
      });
    };
    const watch = ScrollTrigger.create({
      start: 0,
      end: "max",
      onUpdate: (self) => {
        const menuOpen = document.body.classList.contains("menu-open");
        setHidden(
          isBar() &&
            !menuOpen &&
            self.direction === 1 &&
            self.scroll() > header.offsetHeight * 2,
        );
      },
    });
    const onResize = () => {
      if (!isBar()) setHidden(false);
    };
    window.addEventListener("resize", onResize);
    return () => {
      solid.kill();
      watch.kill();
      window.removeEventListener("resize", onResize);
    };
  });

  /* ---------- 10. Menú: sección activa ----------
     El scroll suave lo hace el CSS (scroll-behavior: smooth). Aquí se marca
     en naranja el enlace de la sección que se está viendo. */
  add(".nav", (nav) => {
    const triggers = Array.from(nav.querySelectorAll('a[href*="#"]'))
      .map((link) => ({
        link,
        section: link.hash ? document.getElementById(link.hash.slice(1)) : null,
      }))
      .filter(({ section }) => section)
      .map(({ link, section }) =>
        ScrollTrigger.create({
          trigger: section,
          start: "top 45%",
          end: "bottom 45%",
          onToggle: (self) => {
            link.classList.toggle("is-current", self.isActive);
            if (self.isActive) link.setAttribute("aria-current", "true");
            else link.removeAttribute("aria-current");
          },
        }),
      );
    return () => triggers.forEach((t) => t.kill());
  });

  /* ---------- Menú a pantalla completa ----------
     Al abrirlo, los enlaces grandes suben con máscara uno tras otro y
     después aparecen las redes. */
  add(
    ".menu-panel",
    (panel, env) => {
      const texts = panel.querySelectorAll(".menu-panel-text");
      const nums = panel.querySelectorAll(".menu-panel-num");
      const foot = panel.querySelector(".menu-panel-foot");
      const onMenu = (e) => {
        if (e.detail.panel !== panel || !e.detail.open || !env.motion) return;
        gsap
          .timeline()
          .fromTo(
            texts,
            { yPercent: 110 },
            { yPercent: 0, duration: 0.75, stagger: 0.06, ease: "power4.out" },
            0.05,
          )
          .fromTo(
            nums,
            { opacity: 0 },
            { opacity: 1, duration: 0.4, stagger: 0.06 },
            0.2,
          )
          .fromTo(
            foot,
            { opacity: 0, y: 16 },
            { opacity: 1, y: 0, duration: 0.5 },
            0.35,
          );
      };
      document.addEventListener("mandoca:menu", onMenu);
      return () => document.removeEventListener("mandoca:menu", onMenu);
    },
    { editor: true },
  );

  /* ---------- Motor de bucle infinito (cinta y carrusel) ----------
     Clona el grupo de elementos (.loop-set) las veces necesarias para llenar
     la pantalla y lo desplaza sin fin con transform. Se configura con data-*:
       data-speed="90"        píxeles por segundo
       data-direction="left"  o "right"
       data-scroll-boost      se acelera (e inclina) con la velocidad del scroll
       data-pause-hover       se detiene suavemente con el mouse encima
       data-draggable         se puede arrastrar y lanzar con el mouse o el dedo */
  function createLoop(el) {
    const track = el.querySelector(".loop-track");
    const set = track && track.querySelector(".loop-set");
    if (!track || !set) return () => {};

    const speed = num(el, "speed", 80);
    const baseDir = el.dataset.direction === "right" ? 1 : -1;
    let dir = baseDir;
    let setWidth = 0;

    // 1. Clonar el grupo hasta cubrir dos pantallas de ancho.
    const build = () => {
      track.querySelectorAll(".loop-set.is-clone").forEach((c) => c.remove());
      setWidth = set.getBoundingClientRect().width;
      if (!setWidth) return;
      const copies = Math.ceil((el.offsetWidth * 2) / setWidth) + 1;
      for (let i = 0; i < copies; i += 1) {
        const clone = set.cloneNode(true);
        clone.classList.add("is-clone");
        clone.setAttribute("aria-hidden", "true");
        clone
          .querySelectorAll("a, button")
          .forEach((n) => n.setAttribute("tabindex", "-1"));
        track.appendChild(clone);
      }
    };
    const cancelSize = whenSized(el, build);
    el.classList.add("is-looping");

    // 2. Mover la fila en cada cuadro (60 fps) con el reloj de GSAP.
    const setX = gsap.quickSetter(track, "x", "px");
    const setSkew = el.hasAttribute("data-scroll-boost")
      ? gsap.quickSetter(track, "skewX", "deg")
      : null;
    let x = 0;
    let boost = 0;
    let boostTarget = 0;
    let pause = 1;
    let pauseTarget = 1;
    let throwSpeed = 0;
    let dragging = false;
    let lastX = 0;
    let lastTime = 0;
    let moved = 0;

    const tick = (time, deltaTime) => {
      if (!el.isConnected) {
        // Elementor volvió a pintar el widget
        gsap.ticker.remove(tick);
        return;
      }
      const dt = Math.min(deltaTime, 50) / 1000;
      boostTarget *= 0.92;
      boost += (boostTarget - boost) * 0.1;
      pause += (pauseTarget - pause) * 0.08;
      if (!dragging) {
        x += (dir * speed * (1 + boost) * pause + throwSpeed) * dt;
        throwSpeed *= 0.94; // inercia después de soltar
      }
      if (setWidth) setX(gsap.utils.wrap(-setWidth, 0, x));
      if (setSkew) setSkew(gsap.utils.clamp(-10, 10, -dir * boost * 2.5));
    };
    gsap.ticker.add(tick);

    // 3. Acelerar con la velocidad del scroll (y cambiar de sentido al subir).
    const triggers = [];
    if (el.hasAttribute("data-scroll-boost") && ScrollTrigger) {
      triggers.push(
        ScrollTrigger.create({
          trigger: el,
          start: "top bottom",
          end: "bottom top",
          onUpdate: (self) => {
            const velocity = self.getVelocity();
            boostTarget = Math.min(Math.abs(velocity) / 300, 6);
            dir = velocity < 0 ? -baseDir : baseDir;
          },
        }),
      );
    }

    // 4. Pausa con el mouse encima.
    const listeners = [];
    const on = (target, type, fn, opts) => {
      target.addEventListener(type, fn, opts);
      listeners.push(() => target.removeEventListener(type, fn, opts));
    };
    if (el.hasAttribute("data-pause-hover")) {
      on(el, "pointerenter", (e) => {
        if (e.pointerType === "mouse") pauseTarget = 0;
      });
      on(el, "pointerleave", () => {
        pauseTarget = 1;
      });
    }

    // 5. Arrastrar y lanzar.
    if (el.hasAttribute("data-draggable")) {
      on(el, "pointerdown", (e) => {
        if (e.button !== 0) return;
        dragging = true;
        moved = 0;
        throwSpeed = 0;
        lastX = e.clientX;
        lastTime = performance.now();
        el.classList.add("is-dragging");
      });
      on(window, "pointermove", (e) => {
        if (!dragging) return;
        const now = performance.now();
        const dx = e.clientX - lastX;
        x += dx;
        moved += Math.abs(dx);
        throwSpeed = (dx / Math.max(1, now - lastTime)) * 1000;
        lastX = e.clientX;
        lastTime = now;
      });
      const release = () => {
        if (!dragging) return;
        dragging = false;
        el.classList.remove("is-dragging");
        setTimeout(() => {
          moved = 0;
        }, 0); // después del clic que sigue al soltar
      };
      on(window, "pointerup", release);
      on(window, "pointercancel", release);
      // Si se arrastró, el clic no abre la tarjeta.
      on(
        el,
        "click",
        (e) => {
          if (moved > 6) {
            e.preventDefault();
            e.stopPropagation();
          }
        },
        true,
      );
      on(el, "dragstart", (e) => e.preventDefault());
    }

    // 6. Recalcular al cambiar el tamaño de la ventana.
    let timer;
    on(window, "resize", () => {
      clearTimeout(timer);
      timer = setTimeout(build, 200);
    });

    return () => {
      cancelSize();
      gsap.ticker.remove(tick);
      triggers.forEach((t) => t.kill());
      listeners.forEach((off) => off());
      track.querySelectorAll(".loop-set.is-clone").forEach((c) => c.remove());
      el.classList.remove("is-looping", "is-dragging");
      gsap.set(track, { clearProps: "transform" });
    };
  }

  /* ---------- 3. Cinta y carrusel infinitos ----------
     Sin movimiento: la cinta queda quieta y el carrusel se desliza a mano. */
  add("[data-loop]", (el, env) => (env.motion ? createLoop(el) : undefined), {
    editor: true,
  });

  /* ---------- Vitrina de juegos (como el hero de Thunderful) ----------
     En escritorio los paneles se superponen: cada uno deja ver una franja y
     el activo se abre empujando a los demás hacia la derecha. Solo se mueve
     transform (x), así va a 60 fps. Se activa con el mouse, el teclado o un toque. */
  add(
    "[data-showcase]",
    (el, env) => {
      const items = Array.from(el.querySelectorAll(".showcase-item"));
      if (items.length < 2) return undefined;

      const desktop = window.matchMedia("(min-width: 1100px)");
      let active = Math.max(
        0,
        items.findIndex((item) => item.classList.contains("is-active")),
      );

      const layout = (animate) => {
        if (!desktop.matches) {
          // celular y tablet: tarjetas apiladas
          el.classList.remove("is-ready");
          gsap.set(items, { clearProps: "x,zIndex" });
          return;
        }
        el.classList.add("is-ready");
        const width = el.clientWidth;
        const slice = gsap.utils.clamp(180, 320, width * 0.19); // franja visible de cada panel cerrado
        const expanded = width - slice * (items.length - 1); // ancho del panel abierto
        el.style.setProperty("--slice", `${slice}px`);
        el.style.setProperty("--expanded", `${expanded}px`);
        items.forEach((item, i) => {
          item.classList.toggle("is-active", i === active);
          gsap.set(item, { zIndex: i + 1 });
          gsap.to(item, {
            x: i * slice + (i > active ? expanded - slice : 0),
            duration: animate && env.motion ? 0.85 : 0,
            ease: "power3.inOut",
            overwrite: "auto",
          });
        });
      };

      const activate = (i) => {
        if (i === active) return;
        active = i;
        layout(true);
      };

      const offs = [];
      items.forEach((item, i) => {
        const onEnter = (e) => {
          if (e.pointerType === "mouse") activate(i);
        };
        const onFocus = () => activate(i);
        item.addEventListener("pointerenter", onEnter);
        item.addEventListener("focusin", onFocus);
        item.addEventListener("click", onFocus);
        offs.push(() => {
          item.removeEventListener("pointerenter", onEnter);
          item.removeEventListener("focusin", onFocus);
          item.removeEventListener("click", onFocus);
        });
      });

      // El carrusel de destacados puede pedir abrir un juego (ver más abajo).
      const onOpen = (e) => {
        const i = items.findIndex(
          (item) => item.dataset.game === e.detail.game,
        );
        if (i >= 0) activate(i);
      };
      document.addEventListener("mandoca:open-game", onOpen);

      // Cada vez que ScrollTrigger va a medir la página (al cargar y al cambiar
      // el tamaño de la ventana), primero se acomodan los paneles. Así las
      // posiciones de scroll de las secciones de abajo salen bien.
      const onRefreshInit = () => layout(false);
      ScrollTrigger.addEventListener("refreshInit", onRefreshInit);
      const cancelSize = whenSized(el, () => layout(false));

      return () => {
        cancelSize();
        offs.forEach((off) => off());
        document.removeEventListener("mandoca:open-game", onOpen);
        ScrollTrigger.removeEventListener("refreshInit", onRefreshInit);
        el.classList.remove("is-ready");
        gsap.set(items, { clearProps: "x,zIndex" });
      };
    },
    { editor: true },
  );

  /* ---------- 4a. Vitrina: entrada y parallax ----------
     Los paneles suben en cascada, el arte se mueve dentro de su marco con el
     scroll y los títulos crecen un poco al aparecer. */
  add("[data-showcase]", (el, env) => {
    if (!env.motion) return;
    const enter = { trigger: el, start: "top 80%", once: true };
    gsap.from(el.querySelectorAll(".showcase-item"), {
      yPercent: 14,
      opacity: 0,
      duration: 1,
      stagger: 0.12,
      scrollTrigger: enter,
    });
    gsap.from(el.querySelectorAll(".showcase-title"), {
      scale: 0.8,
      transformOrigin: "0% 100%",
      duration: 1.1,
      stagger: 0.12,
      scrollTrigger: enter,
    });
    el.querySelectorAll(".showcase-img").forEach((img) => {
      gsap.fromTo(
        img,
        { yPercent: -5 },
        {
          yPercent: 5,
          ease: "none",
          scrollTrigger: {
            trigger: el,
            start: "top bottom",
            end: "bottom top",
            scrub: true,
          },
        },
      );
    });
  });

  /* ---------- 4b. Juegos en bloques ----------
     El arte hace parallax dentro de su marco, el título del arte escala un
     poco y el texto entra desde el lado contrario al arte. */
  add(".game", (game, env) => {
    if (!env.motion) return;
    const art = game.querySelector(".game-art");
    const img = game.querySelector(".game-img");
    const title = game.querySelector(".art-title");
    const info = game.querySelector(".game-info");
    const textFromRight = !game.classList.contains("game-reverse");
    const enter = { trigger: game, start: "top 80%", once: true };
    const scrub = {
      trigger: art,
      start: "top bottom",
      end: "bottom top",
      scrub: true,
    };

    gsap.from(art, { opacity: 0, y: 50, duration: 1, scrollTrigger: enter });
    gsap.from(info, {
      opacity: 0,
      x: textFromRight ? 90 : -90,
      duration: 1.1,
      scrollTrigger: enter,
    });
    if (img)
      gsap.fromTo(
        img,
        { yPercent: -6 },
        { yPercent: 6, ease: "none", scrollTrigger: scrub },
      );
    if (title)
      gsap.fromTo(
        title,
        { scale: 0.88 },
        {
          scale: 1.06,
          transformOrigin: "0% 100%",
          ease: "none",
          scrollTrigger: scrub,
        },
      );
  });

  /* ---------- Etiquetas de estado ----------
     Se balancean solas (como el sticker "NEW" de Thunderful) y dan un
     saltito al pasar el mouse por su juego. */
  add(
    "[data-badge]",
    (badge, env) => {
      if (!env.motion) return undefined;
      const wobble = gsap.fromTo(
        badge,
        { rotation: -5 },
        {
          rotation: 3,
          duration: 1.1,
          ease: "sine.inOut",
          yoyo: true,
          repeat: -1,
        },
      );
      const host = badge.closest(".showcase-item, .card") || badge;
      const pop = () =>
        gsap.fromTo(
          badge,
          { scale: 1 },
          {
            scale: 1.2,
            duration: 0.18,
            ease: "power2.out",
            yoyo: true,
            repeat: 1,
          },
        );
      host.addEventListener("pointerenter", pop);
      return () => {
        wobble.kill();
        host.removeEventListener("pointerenter", pop);
      };
    },
    { editor: true },
  );

  /* ---------- Carrusel de destacados: entrada e ícono ----------
     El carrusel entra deslizándose desde la derecha y el control de juego
     del título se mueve como el joystick animado de Thunderful. */
  add(".featured", (el, env) => {
    if (!env.motion) return;
    const carousel = el.querySelector(".carousel");
    const icon = el.querySelector(".featured-icon");
    if (carousel) {
      gsap.from(carousel, {
        x: 160,
        opacity: 0,
        duration: 1.2,
        scrollTrigger: { trigger: el, start: "top 80%", once: true },
      });
    }
    if (icon) {
      gsap
        .timeline({ repeat: -1, repeatDelay: 1.6 })
        .to(icon, { rotation: -14, duration: 0.12, ease: "power1.inOut" })
        .to(icon, {
          rotation: 12,
          duration: 0.18,
          ease: "power1.inOut",
          yoyo: true,
          repeat: 3,
        })
        .to(icon, { rotation: 0, duration: 0.2, ease: "back.out(3)" });
    }
  });

  /* ---------- 5. Cifras del estudio ----------
     Cada número cuenta desde 0 hasta su valor cuando aparece en pantalla. */
  add(".stats dt[data-count]", (dt, env) => {
    const target = parseFloat(dt.dataset.count);
    if (!env.motion || !Number.isFinite(target)) return;
    const counter = { value: 0 };
    dt.setAttribute("aria-label", dt.textContent.trim()); // los lectores de pantalla leen el valor final
    dt.textContent = "0";
    gsap.to(counter, {
      value: target,
      duration: target > 100 ? 2 : 1.4,
      ease: "power2.out",
      onUpdate: () => {
        dt.textContent = String(Math.round(counter.value));
      },
      scrollTrigger: { trigger: dt, start: "top 90%", once: true },
    });
  });

  /* ---------- 6a. Equipo: tarjetas en cascada ---------- */
  add("[data-team]", (section, env) => {
    if (!env.motion) return undefined;
    const members = section.querySelectorAll(".member");
    gsap.set(members, { opacity: 0, y: 60 });
    const batch = ScrollTrigger.batch(members, {
      start: "top 90%",
      once: true,
      onEnter: (els) =>
        gsap.to(els, {
          opacity: 1,
          y: 0,
          duration: 0.8,
          stagger: 0.12,
          overwrite: true,
        }),
    });
    return () => batch.forEach((t) => t.kill());
  });

  /* ---------- 6b. Equipo: filtro con GSAP Flip ----------
     Flip guarda dónde está cada tarjeta, el filtro cambia cuáles se ven y
     Flip anima la diferencia: las que salen se desvanecen y se achican, las
     que quedan se deslizan a su nuevo lugar y las que entran aparecen.
     main.js llama a esta función cuando se pulsa un botón del filtro. */
  api.filterTeam = (section, apply) => {
    const main = scopes.main;
    if (!Flip || !main || !main.motion || main.editor) {
      apply(); // sin movimiento: el cambio es instantáneo
      return;
    }
    const members = section.querySelectorAll(".member");
    const team = section.querySelector(".team");
    const state = Flip.getState(members);
    const before = team.offsetHeight;
    apply();
    const after = team.offsetHeight;
    Flip.from(state, {
      duration: 0.6,
      ease: "power2.inOut",
      absolute: true,
      scale: true,
      onComplete: () => {
        team.style.minHeight = "";
        // La sección cambió de altura y las tarjetas de lugar: se recalculan
        // las posiciones de scroll. Así aparecen las tarjetas que todavía
        // esperaban su entrada en cascada y que ahora quedaron a la vista.
        ScrollTrigger.refresh();
      },
      onEnter: (els) =>
        gsap.fromTo(
          els,
          { opacity: 0, scale: 0.8 },
          { opacity: 1, scale: 1, duration: 0.5, delay: 0.1 },
        ),
      onLeave: (els) => gsap.to(els, { opacity: 0, scale: 0.8, duration: 0.4 }),
    });
    // Durante la animación las tarjetas flotan (absolute): la cuadrícula guarda
    // su altura para que la sección de abajo no se suba encima. (Se fija
    // después de que Flip mide, para no estirar las tarjetas.)
    team.style.minHeight = `${Math.max(before, after)}px`;
  };

  /* ---------- 8. Botones magnéticos (solo escritorio) ----------
     El botón sigue un poco al cursor mientras está encima y vuelve a su
     lugar con un pequeño rebote al salir. */
  add(
    ".btn",
    (btn) => {
      btn.classList.add("is-magnetic");
      const xTo = gsap.quickTo(btn, "x", { duration: 0.5, ease: "power3" });
      const yTo = gsap.quickTo(btn, "y", { duration: 0.5, ease: "power3" });
      const strength = 0.35;
      const move = (e) => {
        const r = btn.getBoundingClientRect();
        xTo((e.clientX - (r.left + r.width / 2)) * strength);
        yTo((e.clientY - (r.top + r.height / 2)) * strength);
      };
      const leave = () =>
        gsap.to(btn, {
          x: 0,
          y: 0,
          duration: 0.7,
          ease: "elastic.out(1, 0.4)",
          overwrite: true,
        });
      btn.addEventListener("pointermove", move);
      btn.addEventListener("pointerleave", leave);
      return () => {
        btn.removeEventListener("pointermove", move);
        btn.removeEventListener("pointerleave", leave);
        btn.classList.remove("is-magnetic");
        gsap.set(btn, { clearProps: "x,y" });
      };
    },
    { desktop: true },
  );

  /* ---------- Entradas al hacer scroll ----------
     Reemplaza al IntersectionObserver de antes: cada bloque sube y aparece
     cuando entra en pantalla (una sola vez). */
  add(".studio-text, .filters", (el, env) => {
    if (!env.motion) return;
    gsap.from(el, {
      y: 48,
      opacity: 0,
      duration: 0.9,
      scrollTrigger: { trigger: el, start: "top 88%", once: true },
    });
  });

  /* ---------- 9. Encabezados de sección ----------
     Primero crece la línea naranja del eyebrow, luego aparece su texto
     palabra por palabra y el título sube línea por línea con máscara. */
  add(".section-head", (el, env) => {
    if (!env.motion) return;
    const eyebrow = el.querySelector(".eyebrow");
    const title = el.querySelector("h2");
    const rest = el.querySelectorAll(":scope > :not(.eyebrow):not(h2)");
    const splits = [];
    // Divide un texto en palabras o líneas (y guarda la división para deshacerla al final).
    const split = (target, vars, key) => {
      if (!SplitText) return [target];
      const result = SplitText.create(target, vars);
      splits.push(result);
      return result[key];
    };
    const tl = gsap.timeline({
      scrollTrigger: { trigger: el, start: "top 85%", once: true },
      onComplete: () => splits.forEach((s) => s.revert()), // devuelve el HTML original
    });

    if (eyebrow) {
      const words = split(eyebrow, { type: "words" }, "words");
      tl.fromTo(
        eyebrow,
        { "--line-scale": 0 },
        { "--line-scale": 1, duration: 0.55, ease: "power2.inOut" },
      );
      tl.from(
        words,
        { opacity: 0, x: -12, stagger: 0.05, duration: 0.45 },
        "-=0.1",
      );
    }
    if (title) {
      const lines = split(title, { type: "lines", mask: "lines" }, "lines");
      tl.from(
        lines,
        { yPercent: 110, duration: 0.85, stagger: 0.08, ease: "power4.out" },
        eyebrow ? "-=0.3" : 0,
      );
    }
    if (rest.length)
      tl.from(rest, { y: 20, opacity: 0, duration: 0.6 }, "-=0.5");
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
          if (typeof cleanup === "function") scope.cleanups.push(cleanup);
        });
      });
    });
  }

  function createScope(name, conditions, accepts) {
    gsap.matchMedia().add(conditions, (ctx) => {
      const flags = ctx.conditions || {};
      const scope = {
        motion: name === "desktop" ? true : Boolean(flags.motion),
        desktop: name === "desktop",
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

  // En el editor de Elementor cada widget editado se vuelve a pintar: lo animamos otra vez.
  // (Se registra apenas carga el script, para no perder el aviso de Elementor.)
  const hookElementor = () => {
    const ef = window.elementorFrontend;
    if (!ef || !ef.hooks || !ef.isEditMode()) return;
    ef.hooks.addAction("frontend/element_ready/widget", ($scope) => {
      Object.values(scopes).forEach((scope) => run(scope, $scope[0]));
    });
  };
  if (window.elementorFrontend && window.elementorFrontend.hooks)
    hookElementor();
  else if (window.jQuery)
    window.jQuery(window).on("elementor/frontend/init", hookElementor);

  function start() {
    html.classList.add("motion-ready");
    // Todo lo general (con o sin movimiento).
    createScope(
      "main",
      {
        motion: "(prefers-reduced-motion: no-preference)",
        reduce: "(prefers-reduced-motion: reduce)",
      },
      (m) => !m.desktop,
    );
    // Efectos de mouse: solo escritorio con puntero fino y con movimiento permitido.
    createScope(
      "desktop",
      "(prefers-reduced-motion: no-preference) and (min-width: 1024px) and (hover: hover) and (pointer: fine)",
      (m) => Boolean(m.desktop),
    );
    // Algunos módulos cambian la altura de la página al iniciar (la vitrina de
    // juegos pasa de tarjetas apiladas a paneles). Se recalculan las posiciones
    // de todos los ScrollTrigger para que, por ejemplo, el menú marque la
    // sección correcta.
    if (ScrollTrigger) ScrollTrigger.refresh();
  }

  // Espera a que carguen las fuentes para que SplitText mida bien las palabras.
  const fontsReady =
    document.fonts && document.fonts.ready
      ? document.fonts.ready
      : Promise.resolve();
  Promise.race([fontsReady, new Promise((r) => setTimeout(r, 1200))]).then(
    start,
  );
})();
