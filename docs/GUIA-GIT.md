# Guía de Git para el equipo

Cómo trabajamos el repositorio del tema **mandoca-studio** con **GitHub Desktop**, **VS Code** y **LocalWP**.

---

## 1. Dónde está el repositorio

El repositorio es la carpeta del tema, dentro del sitio de LocalWP:

```
Local Sites/mandoca-studio/app/public/wp-content/themes/mandoca-studio
```

Así, cada commit es exactamente lo que WordPress usa. No hay copias en otra carpeta.

### Publicarlo en GitHub (solo una persona: Devinzon)

1. GitHub Desktop → **File → Add local repository** → elige la carpeta de arriba.
2. Arriba debe decir **Current Branch: main**. Pulsa **Publish repository**, escribe el nombre `mandoca-studio` y decide si va público o privado.
3. Publica las demás ramas: **Current Branch** → elige `develop` → **Publish branch**. Repite con cada rama `feature/*` de la tabla de abajo.
4. En GitHub.com: **Settings → Collaborators → Add people** e invita a `@momoyeus`, `@verladoth` y `@AleGpu`.

### Clonarlo (resto del equipo)

1. Crea el sitio en LocalWP (o usa uno que ya tengas).
2. GitHub Desktop → **File → Clone repository** → pestaña **GitHub.com** → `mandoca-studio`.
3. En **Local path** elige la carpeta `wp-content/themes` de tu sitio de LocalWP.
4. En el panel de WordPress: **Appearance → Themes → Mandoca Studio → Activate**.

## 2. Ramas

```
main     ●───────────────────────────────────────────●   (entrega, por Pull Request)
          \                                         /
develop    ●────●────●────●────●────●────●────●────●      (integración)
            \  /  \  /  \  /  \  /  \  /  \  /
feature/*    ●●    ●●    ●●    ●●    ●●    ●●             (una por tarea)
```

| Tipo | Para qué |
|------|----------|
| `main` | Versión estable, la que se entrega. Solo recibe `develop` con un Pull Request. |
| `develop` | Donde se juntan las tareas terminadas y se prueban juntas. |
| `feature/<tarea>` | Una rama por tarea. Sale de `develop` y vuelve a `develop` con un merge. |

En total hay **24 ramas**: `main`, `develop` y 22 ramas `feature/*`. Para qué sirve cada una está en el README; sus commits, en la sección 5.

### Crear una rama de tarea en GitHub Desktop

1. **Current Branch → New Branch**, nombre `feature/<tarea>`, basada en **develop**.
2. Trabaja y haz tus commits (sección 3).
3. **Push origin** → **Create Pull Request** hacia `develop`.
4. Cuando el Pull Request esté aprobado, **Merge pull request** en GitHub.com.

## 3. Hacer un commit en GitHub Desktop

1. Antes del primer commit: **File → Options → Git** y pon tu nombre y el correo de tu cuenta de GitHub. Si el correo no es el de tu cuenta, GitHub no te cuenta como contribuyente.
2. Guarda los archivos en VS Code y revisa el cambio en el sitio de LocalWP (**Open site**).
3. En GitHub Desktop, marca solo los archivos que van juntos.
4. En **Summary** escribe el mensaje con el formato de la sección 4.
5. En **Description** (opcional) explica el porqué, si hace falta.
6. **Commit to `<rama>`** → **Push origin**.

## 4. Formato de los mensajes (Conventional Commits)

```
tipo(alcance): descripción en minúsculas, en presente y sin punto final
```

| Tipo | Uso | Ejemplo real de este repo |
|------|-----|---------------------------|
| `feat` | Funcionalidad nueva | `feat(anim): reordenar equipo con flip al filtrar` |
| `fix` | Arreglo de un error | `fix(css): evitar el scroll horizontal por la entrada del carrusel` |
| `docs` | Documentación (README, guías, licencia) | `docs(readme): describir el tema, sus funcionalidades, el stack y la colorimetría` |
| `style` | Formato o espacios, sin cambiar lógica | `style: aplicar prettier` |
| `refactor` | Reorganizar código sin cambiar lo que hace | `refactor(js): reemplazar intersection observer por scrolltrigger` |
| `perf` | Rendimiento | `perf(img): convertir fotos a webp` |
| `build` | Dependencias, `package.json`, carga de librerías | `build: encolar gsap y sus plugins desde jsdelivr` |
| `chore` | Mantenimiento y configuración | `chore: importar sitio estático de mandoca studio` |
| `revert` | Deshacer un commit anterior | `revert: feat(anim): ...` |

**Mal:** `cambios`, `Update index.html`, `ya quedó`.

Un commit = un cambio lógico. Si el mensaje necesita un "y", probablemente son dos commits.

## 5. Ramas y commits del proyecto

Todos los commits, en el orden en que entraron a `develop`. Los merges (`Merge branch 'feature/...' into develop`) no se cuentan.

| # | Rama | Autor | Mensaje |
|---|------|-------|---------|
| 1 | `main` | Devinzon | `chore: importar sitio estático de mandoca studio` |
| 2 | `feature/tema-base` | Devinzon | `refactor(tema): mover estilos y scripts a la carpeta assets` |
| 3 | `feature/tema-base` | Devinzon | `feat(tema): crear estructura base del tema` |
| 4 | `feature/tema-base` | Devinzon | `feat(tema): agregar template parts de cada sección` |
| 5 | `feature/tema-base` | Devinzon | `refactor(css): adaptar estilos al tema de wordpress` |
| 6 | `feature/tema-base` | Devinzon | `refactor(js): iniciar interacciones por sección y leer textos de data-*` |
| 7 | `feature/tema-base` | Devinzon | `feat(img): agregar logo y arte de los juegos de mandocastudio.com` |
| 8 | `feature/custom-post-types` | Carlos | `feat(cpt): agregar tipo de contenido miembro con área y rol` |
| 9 | `feature/custom-post-types` | Carlos | `feat(cpt): agregar tipo de contenido juego con meta box` |
| 10 | `feature/custom-post-types` | Carlos | `feat(seed): crear miembros y juegos al activar el tema` |
| 11 | `feature/elementor` | Devinzon | `feat(elementor): agregar categoría y widgets mandoca` |
| 12 | `feature/elementor` | Devinzon | `feat(elementor): conectar colores y fuentes globales con el tema` |
| 13 | `feature/elementor` | Devinzon | `feat(elementor): agregar cabecera y pie editables con plantillas` |
| 14 | `feature/elementor` | Devinzon | `feat(seed): crear portada, cabecera y pie con elementor al activar el tema` |
| 15 | `feature/elementor` | Devinzon | `feat(seed): nombrar las secciones de la portada en el panel de elementor` |
| 16 | `feature/animaciones` | José | `build: encolar gsap y sus plugins desde jsdelivr` |
| 17 | `feature/animaciones` | José | `refactor(js): reemplazar intersection observer por scrolltrigger` |
| 18 | `feature/animaciones` | José | `feat(anim): revelar encabezados con línea naranja` |
| 19 | `feature/animaciones` | José | `feat(anim): agregar intro del hero con gsap y orbes con parallax` |
| 20 | `feature/animaciones` | José | `feat(redes): agregar redes sociales editables con íconos` |
| 21 | `feature/animaciones` | José | `feat(nav): agregar barra lateral y menú a pantalla completa` |
| 22 | `feature/animaciones` | José | `feat(anim): ocultar la cabecera al bajar y marcar la sección activa` |
| 23 | `feature/animaciones` | José | `feat(anim): agregar marquee que reacciona al scroll` |
| 24 | `feature/animaciones` | José | `feat(juegos): agregar vitrina de juegos como el hero de thunderful` |
| 25 | `feature/animaciones` | José | `feat(anim): agregar carrusel infinito de juegos destacados` |
| 26 | `feature/animaciones` | José | `feat(anim): contar las cifras del estudio desde cero` |
| 27 | `feature/animaciones` | José | `feat(anim): reordenar equipo con flip al filtrar` |
| 28 | `feature/animaciones` | José | `feat(anim): hacer magnéticos los botones principales` |
| 29 | `feature/animaciones` | José | `feat(anim): agregar círculo con física usando matter.js` |
| 30 | `feature/animaciones` | José | `feat(seed): crear la portada con las nuevas secciones` |
| 31 | `feature/animaciones` | José | `fix(anim): compatibilidad de las animaciones con el editor de elementor` |
| 32 | `feature/quitar-circulo` | Alejandro | `refactor(portada): quitar la sección del círculo con física` |
| 33 | `feature/preview-live-server` | Devinzon | `refactor(preview): mover index.html a la carpeta preview` |
| 34 | `feature/preview-live-server` | Devinzon | `feat(preview): agregar vista previa estática para live server` |
| 35 | `feature/preview-live-server` | Devinzon | `chore(vscode): agregar configuración de live server` |
| 36 | `feature/preview-live-server` | Devinzon | `build: agregar script preview para abrir la vista previa con live-server` |
| 37 | `feature/cabecera-arriba` | Devinzon | `feat(cabecera): usar la barra superior en lugar de la lateral` |
| 38 | `feature/pruebas` | Alejandro | `fix(css): evitar el scroll horizontal por la entrada del carrusel` |
| 39 | `feature/pruebas` | Alejandro | `fix(anim): recalcular las posiciones de scroll al armar la vitrina` |
| 40 | `feature/pruebas` | Alejandro | `fix(anim): mostrar las tarjetas del equipo que quedan a la vista al filtrar` |
| 41 | `feature/pruebas` | Alejandro | `fix(css): dar nombre propio a la variable de la línea del eyebrow` |
| 42 | `feature/pruebas` | Alejandro | `feat(tema): agregar captura de la portada para el panel de temas` |
| 43 | `feature/equipo` | Carlos | `feat(equipo): actualizar el equipo a los cinco integrantes actuales` |
| 44 | `feature/equipo` | Carlos | `feat(seed): poner la foto de cada integrante desde assets/img/equipo` |
| 45 | `feature/readme` | Devinzon | `docs(readme): describir el tema, sus funcionalidades, el stack y la colorimetría` |
| 46 | `feature/readme` | Devinzon | `docs(readme): actualizar la estructura de carpetas con preview/` |
| 47 | `feature/readme` | Devinzon | `docs(readme): explicar cómo verlo con live server y localwp` |
| 48 | `feature/readme` | Devinzon | `docs(readme): actualizar dependencias, ramas, contribuyentes y conceptos` |
| 49 | `feature/readme` | Devinzon | `docs(readme): actualizar los juegos, los datos del equipo y las ramas` |
| 50 | `feature/textos-equipo` | Carlos | `feat(equipo): mostrar la cita y los juegos favoritos de cada integrante` |
| 51 | `feature/textos-equipo` | Carlos | `feat(redes): usar las cuentas reales de mandoca studio` |
| 52 | `feature/juegos-nuevos` | Carlos | `feat(juegos): agregar un enlace externo a cada juego` |
| 53 | `feature/juegos-nuevos` | Carlos | `feat(juegos): reemplazar los juegos por los cuatro proyectos del estudio` |
| 54 | `feature/juegos-nuevos` | Carlos | `fix(juegos): leer bien el texto de la vitrina y no partir títulos largos` |
| 55 | `feature/juegos-nuevos` | Carlos | `feat(juegos): usar la portada de meteor strike` |
| 56 | `feature/juegos-nuevos` | Carlos | `feat(juegos): agregar la portada de echoes` |
| 57 | `feature/juegos-nuevos` | Carlos | `feat(juegos): usar la nueva portada de echoes` |
| 58 | `feature/juegos-nuevos` | Carlos | `feat(juegos): agregar la portada de tadventure y corregir su nombre` |
| 59 | `feature/contacto-en-pie` | Devinzon | `feat(pie): pasar el contacto al pie y quitar el formulario de suscripción` |
| 60 | `feature/contacto-en-pie` | Devinzon | `docs(readme): actualizar widgets, contacto en el pie y lista de ramas` |
| 61 | `feature/portadas-hd` | Alejandro | `feat(juegos): usar la portada de echoes en mejor calidad` |
| 62 | `feature/portadas-hd` | Alejandro | `feat(juegos): portada de tadventure en alta calidad con su logo original` |
| 63 | `feature/portadas-hd` | Alejandro | `feat(juegos): agregar las descripciones de echoes y tadventure` |
| 64 | `feature/hero-sin-manchas` | Alejandro | `feat(hero): quitar las manchas del fondo` |
| 65 | `feature/hero-sin-manchas` | Alejandro | `docs(readme): quitar las manchas del hero de la lista de animaciones` |
| 66 | `feature/enlaces-juegos` | Devinzon | `feat(juegos): enlazar meteor strike a itch.io y tadventure a la global game jam` |
| 67 | `feature/fotos-equipo` | José | `feat(img): agregar las fotos de los cinco integrantes` |
| 68 | `feature/fotos-equipo` | José | `docs(img): indicar de dónde salen las fotos del equipo` |
| 69 | `feature/licencia` | Alejandro | `docs(licencia): poner los nombres del equipo en la licencia mit` |
| 70 | `feature/licencia` | Alejandro | `build: renombrar el paquete a mandoca-studio` |
| 71 | `feature/licencia` | Alejandro | `build: agregar gsap 3.13.0 como dependencia` |
| 72 | `feature/licencia` | Alejandro | `docs(readme): actualizar el aporte de cada integrante` |
| 73 | `feature/quitar-live-server` | Devinzon | `refactor(preview): quitar la vista previa estática` |
| 74 | `feature/quitar-live-server` | Devinzon | `chore(vscode): quitar la configuración de live server` |
| 75 | `feature/quitar-live-server` | Devinzon | `build: quitar live-server y el script preview` |
| 76 | `feature/quitar-live-server` | Devinzon | `docs(readme): quitar live server del stack y de cómo verlo` |
| 77 | `feature/guia-git` | Carlos | `docs(git): actualizar la guía con las ramas y commits del tema` |
| 78 | `feature/guia-git` | Carlos | `docs(readme): sumar las ramas nuevas a la lista` |
| 79 | `feature/guia-git` | Carlos | `docs(readme): usar ejemplos de commits actuales` |
| 80 | `feature/portada-meteor` | Devinzon | `feat(juegos): extender el fondo de meteor strike para que llene la vitrina` |
| 81 | `feature/portada-meteor` | Devinzon | `docs: sumar feature/portada-meteor al readme y a la guía de git` |
| 82 | `feature/quitar-boton-destacados` | Devinzon | `feat(destacados): quitar el botón ver todos los juegos` |
| 83 | `feature/quitar-boton-destacados` | Devinzon | `docs: sumar feature/quitar-boton-destacados al readme y a la guía de git` |

## 6. Qué hizo cada integrante

| Integrante | Ramas | Commits | Qué hizo |
|------------|-------|---------|----------|
| Devinzon Acosta (`@Devz99AC`) | `main`, `feature/tema-base`, `feature/elementor`, `feature/preview-live-server`, `feature/readme`, `feature/cabecera-arriba`, `feature/contacto-en-pie`, `feature/enlaces-juegos`, `feature/quitar-live-server`, `feature/portada-meteor`, `feature/quitar-boton-destacados` | 33 | Coordinación, base del tema de WordPress, widgets y plantillas de Elementor, barra superior, contacto en el pie, enlaces y portada de Meteor Strike, ajustes del carrusel y README |
| José Figueredo (`@momoyeus`) | `feature/animaciones`, `feature/fotos-equipo` | 18 | Front-end y diseño: animaciones con GSAP (ScrollTrigger y Flip), vitrina y carrusel de juegos, y fotos del equipo |
| Carlos Mogollon (`@verladoth`) | `feature/custom-post-types`, `feature/equipo`, `feature/textos-equipo`, `feature/juegos-nuevos`, `feature/guia-git` | 17 | Contenido: tipos de contenido Team y Games, datos del equipo y de los juegos, y esta guía |
| Alejandro Mendez (`@AleGpu`) | `feature/quitar-circulo`, `feature/pruebas`, `feature/portadas-hd`, `feature/hero-sin-manchas`, `feature/licencia` | 15 | Pruebas y arreglos, portadas de los juegos, hero sin manchas, licencia y dependencias |

## 7. Entregar: Pull Request de `develop` a `main`

Cuando todas las ramas `feature/*` estén en `develop` y el sitio funcione en LocalWP:

1. GitHub Desktop → **Current Branch: develop** → **Push origin** (para que GitHub tenga lo último).
2. **Branch → Create Pull Request**. Se abre GitHub.com.
3. Arriba: **base: `main`** ← **compare: `develop`**.
4. Título: `Entrega: tema de WordPress de Mandoca Studio`. En la descripción, resume las funcionalidades (puedes copiar la lista del README).
5. **Create pull request** → que otro integrante lo revise → **Merge pull request** → **Confirm merge**.
6. En GitHub Desktop: **Current Branch: main** → **Fetch origin** → **Pull origin**.

## 8. Si algo sale mal

- **Conflicto al hacer merge:** GitHub Desktop muestra los archivos en conflicto → **Open in Visual Studio Code** → elige *Accept Current*, *Accept Incoming* o *Accept Both* → guarda → **Continue merge**.
- **Commit con mensaje equivocado (sin hacer push):** clic derecho en el commit → **Amend commit**.
- **Deshacer un commit ya subido:** clic derecho → **Revert changes in commit** (crea un commit `revert` sin borrar historia).
- **El tema no aparece en WordPress:** revisa que la carpeta se llame `mandoca-studio` y esté dentro de `wp-content/themes`.
