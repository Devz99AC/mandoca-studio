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

```
mandoca-studio-web/
├── index.html              # Página principal (todas las secciones)
├── css/
│   └── styles.css          # Estilos: variables, secciones y responsive
├── js/
│   └── main.js             # Menú, filtro, validación, animaciones
├── assets/
│   └── img/
│       ├── favicon.svg     # Ícono de la pestaña
│       ├── logo.png        # Logo de la marca (agregar)
│       ├── equipo/         # Fotos de los integrantes
│       └── juegos/         # Capturas de los juegos (opcional)
├── docs/
│   └── GUIA-GIT.md         # Ramas, commits y flujo con GitHub Desktop
├── .vscode/
│   └── extensions.json     # Extensiones recomendadas (Live Server, Claude Code…)
├── .editorconfig           # Mismo formato de código para todos
├── .gitignore              # Archivos que Git no debe subir
├── package.json            # Datos del proyecto y dependencias de desarrollo
├── LICENSE                 # Licencia MIT
└── README.md               # Este archivo
```

---

## Cómo verlo en tu computadora

1. Clona el repositorio con **GitHub Desktop** (`File → Clone repository`).
2. Ábrelo en **VS Code** (`Repository → Open in Visual Studio Code`).
3. Clic derecho sobre `index.html` → **Open with Live Server**. Se abre en `http://127.0.0.1:5500`.

No hace falta instalar nada más: el sitio es HTML, CSS y JavaScript puro.

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
