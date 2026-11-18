# Mandoca Studio — Tema de WordPress

Tema de WordPress propio para **Mandoca Studio**, un estudio independiente de videojuegos formado por un grupo de amigos. Es un sitio de una sola página que presenta los juegos, la historia del estudio y a cada integrante con su foto y lo que hace. Se edita con **Elementor** (versión gratis) y tiene animaciones hechas con **GSAP**.

- **Marca:** [mandocastudio.com](https://www.mandocastudio.com/)
- **Referencia de diseño y animación:** [thunderfulgames.com](https://thunderfulgames.com/): vitrina de juegos tipo acordeón, carrusel de destacados, cinta animada, menú a pantalla completa y entradas al hacer scroll, con la paleta de Mandoca.

> Proyecto académico. Los datos del equipo salen de [mandocastudio.com/about-us](https://www.mandocastudio.com/about-us/): fotos, alias, roles, citas y juegos favoritos. Las redes son las cuentas reales del estudio. Los juegos son los del estudio: *Meteor Strike*, *Echoes*, *Tadventure: Road to Neverpond* y *Unknown Project*. Algunos de sus textos e imágenes todavía están pendientes.

---

## Funcionalidades

1. **Editable con Elementor, sin tocar código.** La portada es una página de Elementor armada con **8 widgets propios** (categoría *Mandoca*): Header, Hero, Marquee, Games, Featured Carousel, Studio Intro, Team y Footer. Se pueden combinar con los widgets nativos de Elementor. La cabecera y el pie son plantillas de Elementor, y los colores y las fuentes globales de Elementor están conectados con los del tema.
2. **Contenido administrable desde el panel de WordPress.** Hay dos tipos de contenido propios: **Team** (alias, rol, área, foto, cita favorita y juegos favoritos de cada integrante) y **Games** (estado, género, año, créditos, arte y un enlace, por ejemplo a itch.io, de cada juego). Las redes sociales y el logo se cambian en *Appearance → Customize*. Al activar el tema se cargan solos los datos iniciales, sin duplicar nada.
3. **Animaciones estilo Thunderful con GSAP:**
   - el título del hero entra palabra por palabra;
   - la cinta se acelera con el scroll;
   - la vitrina de juegos se abre como acordeón;
   - el carrusel de destacados es infinito y se puede arrastrar;
   - las cifras cuentan desde cero;
   - los encabezados se revelan con una línea naranja;
   - la cabecera se oculta al bajar;
   - los botones son magnéticos.

   Con *reducir movimiento* activado en el sistema, nada se mueve y todo se ve al instante.
4. **Equipo con filtro por área animado.** Los botones Todos / Programación / Arte / Audio reacomodan las tarjetas con **GSAP Flip**. Si un integrante no tiene foto, se muestran sus iniciales.
5. **Responsive, con menú a pantalla completa.** Se adapta a escritorio, tablet y celular. El menú se abre a pantalla completa y se cierra con la tecla Escape. El correo de contacto del estudio está en el pie, y el botón *Contacto* de la cabecera lleva hasta ahí.

**Extra:** una vista previa estática (`preview/index.html`) con el mismo HTML que genera WordPress, para ver los cambios de diseño y animación al instante con **Live Server**.

---

## Stack tecnológico

| Capa | Herramienta | Para qué la usamos |
|------|-------------|--------------------|
| CMS | **WordPress** | Panel para administrar el contenido (juegos, equipo, redes, logo) |
| Lenguaje del servidor | **PHP** | Tema de WordPress: plantillas, tipos de contenido, meta boxes y widgets |
| Constructor visual | **Elementor** (gratis) | Editar la portada, la cabecera y el pie arrastrando bloques |
| Animación | **GSAP** 3.13 (ScrollTrigger, Flip, SplitText) | Todas las animaciones del sitio. Se carga desde jsDelivr |
| Estructura y estilos | **HTML5** + **CSS3** (variables, Grid, Flexbox) | Secciones, colores de la marca y diseño responsive |
| Interacción | **JavaScript** (ES6) | Menú y filtro del equipo |
| Tipografías | **Google Fonts** | Montserrat (títulos) e Inter (texto), las mismas de mandocastudio.com, y JetBrains Mono para etiquetas |
| Entorno WordPress | **LocalWP** | Correr WordPress en la computadora, sin hosting |
| Vista previa | **Live Server** (extensión de VS Code) | Ver `preview/index.html` y recargar al guardar |
| Editor | **Visual Studio Code** | Escribir el código |
| Asistente | **Claude Code** (extensión de VS Code) | Apoyo para generar, probar y revisar código |
| Control de versiones | **Git** + **GitHub Desktop** | Commits, ramas y subir el código a GitHub |
| Repositorio | **GitHub** | Guardar el proyecto y trabajar en equipo |

---

## Colorimetría

La paleta sale del logo de Mandoca, que es monocromo (negro, blanco y gris), más el naranja de acento que usa su sitio web. Los colores están en dos lugares conectados entre sí:

- como **variables CSS** al inicio de `assets/css/main.css`;
- como **colores globales de Elementor** (*Site Settings → Global Colors*). Si el diseñador cambia un color en Elementor, cambia en todo el sitio.

| Color | Hex | Origen | En Elementor | Uso en el sitio |
|-------|-----|--------|--------------|-----------------|
| Negro | `#0A0A0A` | Logo | Primary · *Black (background)* | Fondo principal |
| Blanco | `#FFFFFF` | Logo | Secondary · *White (text)* | Títulos y texto |
| Gris claro | `#ADADAD` | Logo | Text · *Light gray (secondary text)* | Texto secundario |
| Gris oscuro | `#585858` | Sitio de la marca | *Dark gray (details)* | Arte provisional de los juegos e iniciales |
| Naranja | `#E55901` | Sitio de la marca | Accent · *Orange (accent)* | Botones y acentos (con moderación) |
| Crema | `#FEF1E4` | Sitio de la marca | *Cream (details)* | Línea de la cita, datos de los juegos y foco del teclado |

---

## Estructura de carpetas

Es la carpeta del tema. En WordPress vive en `wp-content/themes/mandoca-studio/`.

```
mandoca-studio/
├── style.css                  # Cabecera del tema (nombre, versión, licencia); los estilos están en assets/
├── functions.php              # Configura el tema y carga el CSS, el JS y GSAP (versión fija)
├── header.php                 # <head>, apertura de la página y cabecera
├── footer.php                 # Pie y cierre de la página
├── front-page.php             # Portada: la página de Elementor o, sin Elementor, las secciones del tema
├── index.php                  # Plantilla general (otras páginas y entradas)
├── screenshot.png             # Captura que se ve en Appearance → Themes (1200×900)
├── inc/
│   ├── helpers.php            # Funciones de ayuda (leer juegos e integrantes, iniciales…)
│   ├── defaults.php           # Textos por defecto de cada sección
│   ├── socials.php            # Redes sociales (Customize → Social networks)
│   ├── cpt.php                # Tipos de contenido Team y Games, y la taxonomía Areas
│   ├── meta-boxes.php         # Campos extra: rol, estado, género, año, créditos, ajuste de imagen
│   ├── seed.php               # Datos iniciales y el comando `wp mandoca seed`
│   ├── elementor.php          # Conexión con Elementor: categoría, widgets, cabecera y pie
│   └── widgets/               # Los 8 widgets Mandoca (más su clase base)
├── template-parts/            # El HTML de cada sección (lo usan los widgets y la portada)
│   ├── cabecera.php           # Cabecera y menú a pantalla completa
│   ├── hero.php
│   ├── marquee.php            # Cinta animada
│   ├── juegos.php             # Vitrina de juegos
│   ├── destacados.php         # Carrusel de destacados
│   ├── estudio.php
│   ├── equipo.php             # Equipo con filtro
│   └── pie.php                # Pie: contacto, marca, redes y derechos
├── assets/
│   ├── css/main.css           # Todos los estilos (los colores, como variables al inicio)
│   ├── js/main.js             # Menú y filtro del equipo (JavaScript puro)
│   ├── js/animations.js       # Todas las animaciones (GSAP)
│   └── img/
│       ├── favicon.svg        # Ícono de la pestaña
│       ├── logo.png, logo-mark.png
│       ├── juegos/            # Arte de los juegos (.webp)
│       └── equipo/            # Fotos de los integrantes (.webp)
├── preview/
│   └── index.html             # Vista previa estática para Live Server (mismo HTML que WordPress)
├── docs/
│   └── GUIA-GIT.md            # Ramas, commits y flujo con GitHub Desktop
├── .vscode/
│   ├── extensions.json        # Extensiones recomendadas (Live Server, Claude Code…)
│   └── settings.json          # Configuración de Live Server (puerto 5500)
├── .editorconfig              # Mismo formato de código para todos
├── .gitattributes             # Finales de línea y archivos binarios
├── .gitignore                 # Archivos que Git no debe subir
├── package.json               # Scripts y dependencias
├── LICENSE                    # Licencia MIT
└── README.md                  # Este archivo
```

---

## Cómo verlo

Hay dos formas, y las dos usan los mismos archivos de `assets/` (CSS, JavaScript e imágenes):

| Para qué | Herramienta | Qué se abre |
|----------|-------------|-------------|
| Ajustar colores, espacios y animaciones al instante | **Live Server** | `preview/index.html`, una copia estática de la portada |
| Ver el sitio real y editarlo desde el panel | **LocalWP** | WordPress completo, con Elementor |

### 1. Diseño y animaciones al instante: Live Server

1. Clona el repositorio con **GitHub Desktop** (`File → Clone repository`) y abre en **VS Code** la carpeta del tema, la que tiene `style.css`.
2. Clic derecho sobre `preview/index.html` → **Open with Live Server**. Se abre en `http://127.0.0.1:5500/preview/index.html`.
3. Cada vez que guardas `main.css`, `main.js` o `animations.js`, la página se recarga sola.

Por terminal también se puede: `npm install` y después `npm run preview`.

> Live Server no ejecuta PHP. Por eso existe `preview/index.html`, con el mismo HTML que genera WordPress. **Regla del equipo:** si cambias una plantilla PHP (`template-parts/`) o los datos de `inc/seed.php`, actualiza también `preview/index.html` en el mismo commit.

### 2. Sitio real con WordPress: LocalWP

1. **Crear el sitio.** En LocalWP: **+** → *Create a new site* → nombre `mandoca-studio` → *Preferred* → crea tu usuario y contraseña de administrador. Pulsa **Start site**.
2. **Poner el tema.** Clona (o copia) este repositorio dentro de la carpeta del sitio, en `app/public/wp-content/themes/mandoca-studio`. En Windows la carpeta del sitio suele ser `C:\Users\<tu usuario>\Local Sites\mandoca-studio\`; en Mac, `~/Local Sites/mandoca-studio/`. Con GitHub Desktop: `File → Clone repository` y en *Local path* eliges esa carpeta.
3. **Instalar Elementor.** Botón **WP Admin** → *Plugins → Add New Plugin* → busca **Elementor** (*Elementor Website Builder*) → *Install Now* → *Activate*. Conviene hacerlo antes de activar el tema; si lo instalas después, la portada se arma sola la próxima vez que entres al panel.
4. **Activar el tema.** *Appearance → Themes → Mandoca Studio → Activate*. Se crean solos:
   - las áreas, los 5 integrantes con su foto y los 4 juegos con su arte (el de cada juego cuya imagen ya está en `assets/img/juegos/`);
   - el logo;
   - con Elementor, además: la página *Inicio* como portada, las plantillas *Header* y *Footer*, y los colores y fuentes globales.

   Si el tema se activa otra vez, no se duplica nada.
5. **Título del sitio.** *Settings → General* → *Site Title*: `Mandoca Studio` y *Tagline*: `Juegos creativos e imaginativos` → *Save Changes*. Es el texto de la pestaña del navegador.
6. **Fotos y logo.** Ya vienen cargados (salen de `assets/img/`). Para cambiarlos, mira la tabla de abajo.
7. **Ver el sitio:** botón **Open site**.
8. **Exportar el sitio completo.** En LocalWP: clic derecho sobre el sitio → **Export**. Se genera un `.zip` con los archivos y la base de datos. Para abrirlo en otra computadora, se arrastra ese `.zip` a LocalWP.

Para volver a cargar los datos iniciales sin duplicar nada (por ejemplo, si se borró un integrante): en LocalWP, clic derecho sobre el sitio → *Open site shell* → `wp mandoca seed`.

#### Qué se edita dónde

El panel está en inglés; el contenido del sitio, en español.

| Quiero cambiar… | Dónde |
|-----------------|-------|
| Textos, botones y orden de las secciones de la portada | *Pages → Inicio → Edit with Elementor* |
| La cabecera o el pie (incluido el correo de contacto) | *Templates → Saved Templates → Header / Footer → Edit with Elementor* |
| Colores y fuentes de todo el sitio | En el editor de Elementor: *Site Settings → Global Colors / Global Fonts* |
| Integrantes: alias, rol, área, foto, cita y juegos favoritos | *Team* |
| Las áreas del filtro | *Team → Areas* |
| Juegos: texto, estado, género, año, créditos, arte y enlace (itch.io, Steam…) | *Games* |
| Redes sociales (íconos del hero, el menú y el pie) | *Appearance → Customize → Social networks* (un campo vacío oculta esa red) |
| Logo | *Appearance → Customize → Site Identity → Logo* |

#### ¿Por qué Elementor, si la regla es "sin plugins"?

El tema no usa plugins: los tipos de contenido, las meta boxes, las redes y los datos iniciales están hechos con código propio de WordPress. **Elementor (versión gratis) es la única excepción**, porque un diseñador del equipo tiene que poder editar todo el sitio sin tocar código.

El tema también funciona sin Elementor. En ese caso la portada muestra las mismas secciones con sus textos por defecto, la cabecera y el pie salen de `template-parts/`, y el panel muestra un aviso para instalar Elementor.

---

## Conceptos del proyecto

### ¿Qué son las dependencias?

Son paquetes de código hechos por otras personas que un proyecto necesita para funcionar o para desarrollarse. Se anotan en `package.json` y se descargan en la carpeta `node_modules/` (que nunca se sube a GitHub).

Hay dos tipos:

- **`dependencies`**: las necesita el sitio para funcionar en producción (por ejemplo, una librería de animaciones).
- **`devDependencies`**: solo se usan mientras se desarrolla (formatear código, servidor local).

Este proyecto tiene **1 dependencia del sitio** y **2 dependencias de desarrollo**:

| Paquete | Tipo | Versión | Para qué |
|---------|------|---------|----------|
| `gsap` | dependency (del sitio) | `3.13.0` | Todas las animaciones: el núcleo de GSAP y sus plugins ScrollTrigger, Flip y SplitText (desde la versión 3.13 todos sus plugins son gratis) |
| `live-server` | devDependency | `^1.2.2` | Servidor local desde la terminal (igual que la extensión Live Server) |
| `prettier` | devDependency | `^3.3.3` | Ordena y formatea el código automáticamente |

Para que el sitio funcione **no hace falta** `npm install`. WordPress (`functions.php`) y la vista previa (`preview/index.html`) cargan GSAP desde **jsDelivr** con la misma versión fija; en `package.json` queda anotada para que todos sepan cuál usamos. Si algún día se cambia la versión, hay que cambiarla en los tres lugares: `package.json`, `MANDOCA_GSAP_VERSION` en `functions.php` y `preview/index.html`.

**Elementor** también es una dependencia, pero de otro tipo: es un plugin de WordPress, no un paquete de npm, y se instala desde el panel (ver *Cómo verlo*).

### ¿Qué son los gestores de paquetes?

Son programas que instalan, actualizan y eliminan dependencias. Leen `package.json` y guardan las versiones exactas en un archivo *lock*.

| Gestor | Instalar todo | Agregar un paquete | Archivo lock |
|--------|---------------|--------------------|--------------|
| **npm** (viene con Node.js) | `npm install` | `npm install -D prettier` | `package-lock.json` |
| **pnpm** (más rápido, ahorra espacio) | `pnpm install` | `pnpm add -D prettier` | `pnpm-lock.yaml` |
| **Yarn** | `yarn` | `yarn add -D prettier` | `yarn.lock` |

El equipo usa **npm**. Lo importante es que todos usen el mismo gestor, para no mezclar archivos lock.

```bash
npm install        # instala las dependencias de package.json
npm run preview    # abre preview/index.html con live-server
npm run format     # formatea el código con prettier
```

### ¿Qué son las ramas?

Una rama es una línea de trabajo paralela dentro del repositorio. Permite que cada persona haga cambios sin romper la versión que funciona; cuando el cambio está listo, se une (*merge*) a la rama principal.

Este repositorio usa **3 tipos de ramas**:

| Tipo | Qué contiene |
|------|--------------|
| `main` | Versión estable, la que se entrega |
| `develop` | Donde se juntan los cambios antes de pasar a `main` |
| `feature/<tarea>` | Una rama por tarea; al terminar se une a `develop` |

En total hay **16 ramas**:

| Rama | Para qué sirvió |
|------|-----------------|
| `main` | Entrega final (recibe `develop` con un Pull Request) |
| `develop` | Integración de todas las tareas |
| `feature/tema-base` | Pasar el sitio estático a un tema de WordPress |
| `feature/custom-post-types` | Tipos de contenido Team y Games, meta boxes y datos iniciales |
| `feature/elementor` | Widgets Mandoca, cabecera y pie como plantillas, y colores y fuentes globales |
| `feature/animaciones` | Todas las animaciones con GSAP, la vitrina y el carrusel |
| `feature/quitar-circulo` | Quitar la sección del círculo con física, que se descartó |
| `feature/preview-live-server` | Vista previa estática y configuración de Live Server |
| `feature/cabecera-arriba` | Cambiar la barra lateral por una barra superior |
| `feature/pruebas` | Pruebas en 3 tamaños de pantalla, arreglos y captura del tema |
| `feature/equipo` | Equipo real de 5 integrantes y fotos desde el seed |
| `feature/textos-equipo` | Citas y juegos favoritos de cada integrante, y redes reales del estudio |
| `feature/juegos-nuevos` | Los 4 juegos del estudio y el enlace externo de cada juego |
| `feature/portadas-hd` | Portadas de los juegos en mejor calidad y sus descripciones reales |
| `feature/contacto-en-pie` | Quitar el formulario de suscripción y pasar el contacto al pie |
| `feature/readme` | Este README |

Para verlas: en GitHub Desktop, menú **Current Branch**; en la terminal, `git branch -a`. El detalle de cada rama y sus commits está en [`docs/GUIA-GIT.md`](docs/GUIA-GIT.md).

### ¿Qué son los contribuyentes?

Son las personas que han hecho commits en el repositorio. GitHub los cuenta solo y los muestra en **Insights → Contributors**.

| Nombre | Usuario de GitHub | Aporte |
|--------|-------------------|--------|
| Devinzon Acosta | [@Devz99AC](https://github.com/Devz99AC) | Coordinación y base del tema: WordPress, widgets y plantillas de Elementor, barra superior, contacto en el pie, enlaces de los juegos y README |
| José Figueredo | [@momoyeus](https://github.com/momoyeus) | Front-end y diseño: animaciones con GSAP (ScrollTrigger y Flip), vitrina y carrusel de juegos, y fotos del equipo |
| Carlos Mogollon | [@verladoth](https://github.com/verladoth) | Contenido: tipos de contenido Team y Games, datos del equipo y de los juegos, y guía de Git |
| Alejandro Mendez | [@AleGpu](https://github.com/AleGpu) | Pruebas y arreglos, portadas de los juegos, hero sin manchas, licencia y dependencias |

### Conceptos de WordPress y de animación

| Concepto | Qué es, en una frase | Dónde está |
|----------|----------------------|------------|
| **Tema** | La carpeta que decide cómo se ve un sitio de WordPress: plantillas PHP, CSS y JavaScript | Todo este repositorio |
| **Template part** | Un pedazo de HTML reutilizable; aquí, una sección de la página | `template-parts/` |
| **Custom Post Type (CPT)** | Un tipo de contenido propio, como las entradas, pero para integrantes (*Team*) y juegos (*Games*) | `inc/cpt.php` |
| **Taxonomía** | Una forma de agrupar contenido, como las categorías; aquí, las áreas del equipo | `inc/cpt.php` |
| **Meta box** | Una caja extra en la pantalla de edición con campos propios (rol, estado, año…) | `inc/meta-boxes.php` |
| **Nonce** | Un código de un solo uso que prueba que el formulario salió de nuestro panel | `inc/meta-boxes.php` |
| **Enqueue** | La forma correcta de cargar CSS y JS en WordPress: se piden con `wp_enqueue_style` / `wp_enqueue_script` y WordPress los imprime en orden | `functions.php` |
| **Seed** | Los datos iniciales que el tema crea al activarse, sin duplicar | `inc/seed.php` |
| **Widget de Elementor** | Un bloque que se arrastra en el editor; los nuestros usan las mismas template parts | `inc/widgets/` |
| **GSAP** | Librería de animación; aquí solo anima `transform` y `opacity`, para ir a 60 fps | `assets/js/animations.js` |
| **ScrollTrigger** | Plugin de GSAP que lanza una animación cuando una sección llega a cierta posición del scroll | `assets/js/animations.js` |
| **Flip** | Plugin de GSAP que guarda dónde está cada tarjeta, deja que el filtro cambie el orden y anima la diferencia | `assets/js/animations.js` |
| **SplitText** | Plugin de GSAP que divide un texto en palabras o líneas para animarlas una por una | `assets/js/animations.js` |
| **Reducir movimiento** | Una opción del sistema operativo; con `gsap.matchMedia()` el sitio la respeta y no mueve nada | `assets/js/animations.js` |

---

## Commits

Seguimos el estándar **[Conventional Commits](https://www.conventionalcommits.org/es/v1.0.0/)**:

```
tipo(alcance): descripción corta en minúsculas
```

| Tipo | Cuándo se usa | Ejemplo |
|------|---------------|---------|
| `feat` | Nueva funcionalidad | `feat(anim): reordenar equipo con flip al filtrar` |
| `fix` | Corrección de un error | `fix(css): evitar el scroll horizontal por la entrada del carrusel` |
| `docs` | Solo documentación | `docs(readme): explicar cómo verlo con live server y localwp` |
| `style` | Formato, sin cambiar lógica | `style: aplicar prettier` |
| `refactor` | Reorganizar código sin cambiar lo que hace | `refactor(js): reemplazar intersection observer por scrolltrigger` |
| `perf` | Mejora de rendimiento | `perf(img): convertir fotos a webp` |
| `chore` | Tareas de mantenimiento | `chore(vscode): agregar configuración de live server` |
| `build` | Dependencias o configuración | `build: encolar gsap y sus plugins desde jsdelivr` |

La guía completa, con el orden de commits sugerido y el paso a paso en GitHub Desktop, está en [`docs/GUIA-GIT.md`](docs/GUIA-GIT.md).

---

## Licencia

Este proyecto está bajo la **Licencia MIT**, a nombre de los cuatro integrantes del equipo. Ver el archivo [`LICENSE`](LICENSE).

El nombre, el logo y las imágenes de Mandoca Studio pertenecen a la marca y se usan solo con fines académicos.
