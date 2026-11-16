# Mandoca Studio — Sitio web

Sitio web de una sola página para **Mandoca Studio**, un estudio independiente de videojuegos formado por un grupo de amigos. Presenta los juegos en desarrollo, la historia del estudio y a cada integrante con su foto y lo que hace.

- **Marca:** [mandocastudio.com](https://www.mandocastudio.com/)
- **Referencia de diseño:** [thunderfulgames.com](https://thunderfulgames.com/) (juegos destacados en grande, bloques por juego, llamada a la comunidad y pie con redes)

> Proyecto académico. Los textos de los juegos (Skathos y Void Mask) son de ejemplo y deben confirmarse con la marca.

---

## Funcionalidades

1. **Diseño responsive con menú móvil.** El sitio se adapta a escritorio, tablet y celular; en pantallas pequeñas el menú se convierte en un botón hamburguesa que se cierra al elegir una opción o con la tecla Escape.
2. **Sección de juegos estilo vitrina.** Cada juego tiene su bloque con arte, género, año, estado (en desarrollo / prototipo) y quién del equipo trabaja en él, al estilo de Thunderful Games.
3. **Equipo con foto y descripción.** Una tarjeta por integrante con foto, alias, rol y qué hace. Si falta una foto, se muestran sus iniciales automáticamente.
4. **Filtro del equipo por área.** Botones para ver solo Programación, Arte o Audio y narrativa.
5. **Formulario de newsletter con validación.** Revisa el correo en el navegador y muestra mensajes claros de error o de éxito, sin recargar la página.

Extra: animaciones de entrada al hacer scroll, que se desactivan si el sistema tiene activado “reducir movimiento”.

---

## Stack tecnológico

| Capa | Herramienta | Para qué la usamos |
|------|-------------|--------------------|
| Estructura | **HTML5** | Contenido y secciones de la página |
| Estilos | **CSS3** (variables, Grid, Flexbox) | Diseño, colores de la marca y responsive |
| Interacción | **JavaScript** (ES6, sin librerías) | Menú, filtro, validación y animaciones |
| Tipografías | **Google Fonts** | Montserrat (títulos) e Inter (texto), las mismas de mandocastudio.com, y JetBrains Mono para etiquetas |
| Editor | **Visual Studio Code** | Escribir el código |
| Asistente | **Claude Code** (extensión de VS Code) | Apoyo para generar y revisar código |
| Vista previa | **Live Server** (extensión de VS Code) | Ver los cambios en el navegador al guardar |
| Control de versiones | **Git** + **GitHub Desktop** | Commits, ramas y subir el código a GitHub |
| Repositorio | **GitHub** | Guardar el proyecto y trabajar en equipo |
| Entorno WordPress | **LocalWP** | Correr en local una copia WordPress del sitio original de la marca para compararlo (opcional) |

---

## Colorimetría

La paleta sale del logo de Mandoca, que es monocromo (negro, blanco y gris), más el naranja de acento que usa su sitio web. Todos los colores están como variables al inicio de `css/styles.css`.

| Color | Hex | Origen | Uso en el sitio |
|-------|-----|--------|-----------------|
| Negro | `#0A0A0A` | Logo | Fondo principal |
| Blanco | `#FFFFFF` | Logo | Títulos y texto |
| Gris claro | `#ADADAD` | Logo | Texto secundario |
| Gris oscuro | `#585858` | Sitio de la marca | Detalles y avatares |
| Naranja | `#E55901` | Sitio de la marca | Botones y acentos (con moderación) |
| Crema | `#FEF1E4` | Sitio de la marca | Línea de la cita y foco |

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
