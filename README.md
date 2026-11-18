# Mandoca Studio — Tema de WordPress

Tema de WordPress propio para **Mandoca Studio**, un estudio independiente de videojuegos formado por un grupo de amigos. Es un sitio de una sola página que presenta los juegos, la historia del estudio y a cada integrante con su foto y lo que hace. Se edita con **Elementor** (versión gratis) y tiene animaciones hechas con **GSAP**.

- **Marca:** [mandocastudio.com](https://www.mandocastudio.com/)
- **Referencia de diseño y animación:** [thunderfulgames.com](https://thunderfulgames.com/): vitrina de juegos tipo acordeón, carrusel de destacados, cinta animada, menú a pantalla completa y entradas al hacer scroll, con la paleta de Mandoca.

> Proyecto académico. Las fotos, alias y roles del equipo salen de [mandocastudio.com/about-us](https://www.mandocastudio.com/about-us/). Los textos de los juegos son provisionales, y *Proyecto 03* y *Proyecto 04* son espacios reservados para juegos que todavía no se anuncian.

---

## Funcionalidades

1. **Editable con Elementor, sin tocar código.** La portada es una página de Elementor armada con **9 widgets propios** (categoría *Mandoca*): Header, Hero, Marquee, Games, Featured Carousel, Studio Intro, Team, Community & Contact y Footer. Se pueden combinar con los widgets nativos de Elementor. La cabecera y el pie son plantillas de Elementor, y los colores y las fuentes globales de Elementor están conectados con los del tema.
2. **Contenido administrable desde el panel de WordPress.** Hay dos tipos de contenido propios: **Team** (alias, rol, área y foto de cada integrante) y **Games** (estado, género, año, créditos y arte de cada juego). Las redes sociales y el logo se cambian en *Appearance → Customize*. Al activar el tema se cargan solos los datos iniciales, sin duplicar nada.
3. **Animaciones estilo Thunderful con GSAP:**
   - el título del hero entra palabra por palabra;
   - los orbes del fondo siguen al mouse;
   - la cinta se acelera con el scroll;
   - la vitrina de juegos se abre como acordeón;
   - el carrusel de destacados es infinito y se puede arrastrar;
   - las cifras cuentan desde cero;
   - los encabezados se revelan con una línea naranja;
   - la cabecera se oculta al bajar;
   - los botones son magnéticos.

   Con *reducir movimiento* activado en el sistema, nada se mueve y todo se ve al instante.
4. **Equipo con filtro por área animado.** Los botones Todos / Programación / Arte / Audio reacomodan las tarjetas con **GSAP Flip**. Si un integrante no tiene foto, se muestran sus iniciales.
5. **Responsive, con menú a pantalla completa y newsletter validado.** Se adapta a escritorio, tablet y celular. El menú se abre a pantalla completa y se cierra con la tecla Escape. El formulario revisa el correo y muestra mensajes de error o de éxito sin recargar la página; esos mensajes también se editan en Elementor.

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
| Interacción | **JavaScript** (ES6) | Menú, filtro del equipo y validación del formulario |
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
| Gris oscuro | `#585858` | Sitio de la marca | *Dark gray (details)* | Orbe del hero, arte provisional de los juegos e iniciales |
| Naranja | `#E55901` | Sitio de la marca | Accent · *Orange (accent)* | Botones y acentos (con moderación) |
| Crema | `#FEF1E4` | Sitio de la marca | *Cream (details)* | Línea de la cita, datos de los juegos, foco del teclado y mensaje de éxito |

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
│   └── widgets/               # Los 9 widgets Mandoca (más su clase base)
├── template-parts/            # El HTML de cada sección (lo usan los widgets y la portada)
│   ├── cabecera.php           # Cabecera y menú a pantalla completa
│   ├── hero.php
│   ├── marquee.php            # Cinta animada
│   ├── juegos.php             # Vitrina de juegos
│   ├── destacados.php         # Carrusel de destacados
│   ├── estudio.php
│   ├── equipo.php             # Equipo con filtro
│   ├── contacto.php           # Comunidad (newsletter) y contacto
│   └── pie.php
├── assets/
│   ├── css/main.css           # Todos los estilos (los colores, como variables al inicio)
│   ├── js/main.js             # Menú, filtro del equipo y formulario (JavaScript puro)
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
   - las áreas, los 5 integrantes con su foto y los 4 juegos con su arte;
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
| La cabecera o el pie | *Templates → Saved Templates → Header / Footer → Edit with Elementor* |
| Colores y fuentes de todo el sitio | En el editor de Elementor: *Site Settings → Global Colors / Global Fonts* |
| Integrantes: alias, rol, área, qué hace y foto | *Team* |
| Las áreas del filtro | *Team → Areas* |
| Juegos: texto, estado, género, año, créditos y arte | *Games* |
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

Este proyecto tiene **0 dependencias** de producción y **2 dependencias de desarrollo**, ambas opcionales:

| Paquete | Tipo | Para qué |
|---------|------|----------|
| `live-server` | devDependency | Servidor local desde la terminal (igual que la extensión Live Server) |
| `prettier` | devDependency | Ordena y formatea el código automáticamente |

### ¿Qué son los gestores de paquetes?

Son programas que instalan, actualizan y eliminan dependencias. Leen `package.json` y guardan las versiones exactas en un archivo *lock*.

| Gestor | Instalar todo | Agregar un paquete | Archivo lock |
|--------|---------------|--------------------|--------------|
| **npm** (viene con Node.js) | `npm install` | `npm install -D prettier` | `package-lock.json` |
| **pnpm** (más rápido, ahorra espacio) | `pnpm install` | `pnpm add -D prettier` | `pnpm-lock.yaml` |
| **Yarn** | `yarn` | `yarn add -D prettier` | `yarn.lock` |

El equipo usa **npm**. Lo importante es que todos usen el mismo gestor, para no mezclar archivos lock.

```bash
npm install        # instala las devDependencies
npm run dev        # abre el sitio con live-server
npm run format     # formatea el código con prettier
```

### ¿Qué son las ramas?

Una rama es una línea de trabajo paralela dentro del repositorio. Permite que cada persona haga cambios sin romper la versión que funciona; cuando el cambio está listo, se une (*merge*) a la rama principal.

Este repositorio usa **3 tipos de ramas**:

| Rama | Qué contiene |
|------|--------------|
| `main` | Versión estable, la que se entrega y se publica |
| `develop` | Donde se juntan los cambios antes de pasar a `main` |
| `feature/<nombre>` | Una rama temporal por tarea, por ejemplo `feature/seccion-equipo` |

Para ver cuántas ramas hay: en GitHub Desktop, menú **Current Branch**; en la terminal, `git branch -a`.

### ¿Qué son los contribuyentes?

Son las personas que han hecho commits en el repositorio. GitHub los cuenta solo y los muestra en **Insights → Contributors**.

| Nombre | Usuario de GitHub | Aporte |
|--------|-------------------|--------|
| _Integrante 1_ | `@usuario1` | Estructura HTML y README |
| _Integrante 2_ | `@usuario2` | Estilos y responsive |
| _Integrante 3_ | `@usuario3` | JavaScript e interacciones |
| _Integrante 4_ | `@usuario4` | Fotos y textos del equipo |

> Reemplacen esta tabla con sus nombres y usuarios reales.

---

## Commits

Seguimos el estándar **[Conventional Commits](https://www.conventionalcommits.org/es/v1.0.0/)**:

```
tipo(alcance): descripción corta en minúsculas
```

| Tipo | Cuándo se usa | Ejemplo |
|------|---------------|---------|
| `feat` | Nueva funcionalidad | `feat(equipo): agregar filtro por área` |
| `fix` | Corrección de un error | `fix(menu): cerrar el menú al tocar un enlace` |
| `docs` | Solo documentación | `docs(readme): agregar estructura de carpetas` |
| `style` | Formato, sin cambiar lógica | `style: aplicar prettier` |
| `refactor` | Reorganizar código sin cambiar lo que hace | `refactor(css): mover colores a variables` |
| `perf` | Mejora de rendimiento | `perf(img): convertir fotos a webp` |
| `chore` | Tareas de mantenimiento | `chore: agregar .gitignore` |
| `build` | Dependencias o configuración | `build: agregar prettier como devDependency` |

La guía completa, con el orden de commits sugerido y el paso a paso en GitHub Desktop, está en [`docs/GUIA-GIT.md`](docs/GUIA-GIT.md).

---

## Licencia

Este proyecto está bajo la **Licencia MIT**. Ver el archivo [`LICENSE`](LICENSE).

El nombre, el logo y las imágenes de Mandoca Studio pertenecen a la marca y se usan solo con fines académicos.
