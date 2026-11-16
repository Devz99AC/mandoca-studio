# Guía de Git para el equipo

Cómo trabajamos el repositorio con **GitHub Desktop**, **VS Code** y **Live Server**.

---

## 1. Crear el repositorio (solo una persona)

1. Abre GitHub Desktop → `File → Add local repository` y elige la carpeta `mandoca-studio-web`.
2. Si pide inicializarlo, pulsa **create a repository** (deja la rama como `main`).
3. Haz el primer commit (ver la lista de abajo) y pulsa **Publish repository**.
4. En GitHub.com: `Settings → Collaborators → Add people` e invita al resto del equipo.

El resto del equipo: `File → Clone repository` → pestaña GitHub.com → elegir el repo.

## 2. Ramas

```
main ──●────────────────────────●──────────  (entrega)
        \                      /
develop  ●──────●──────●──────●              (integración)
          \    /  \    /
feature/   ●──●    ●──●                      (una por tarea)
```

En GitHub Desktop:

1. **Current Branch → New Branch**, nombre `develop`, basada en `main` → **Publish branch**.
2. Para cada tarea: **New Branch** basada en `develop`, con nombre `feature/<tarea>`:
   - `feature/estructura-html`
   - `feature/estilos`
   - `feature/interacciones-js`
   - `feature/fotos-equipo`
   - `feature/readme`
3. Al terminar la tarea: **Push origin** → **Create Pull Request** hacia `develop`.
4. Cuando todo funcione en `develop`, se abre un Pull Request de `develop` a `main`.

## 3. Hacer un commit en GitHub Desktop

1. Guarda los archivos en VS Code y revisa en Live Server que todo se vea bien.
2. En GitHub Desktop, marca solo los archivos que van juntos.
3. En **Summary** escribe el mensaje con el formato de abajo.
4. En **Description** (opcional) explica el porqué, si hace falta.
5. **Commit to `<rama>`** → **Push origin**.

## 4. Formato de los mensajes (Conventional Commits)

```
tipo(alcance): descripción en minúsculas, en presente y sin punto final
```

| Tipo | Uso |
|------|-----|
| `feat` | Funcionalidad nueva |
| `fix` | Arreglo de un error |
| `docs` | Documentación (README, guías) |
| `style` | Formato o espacios, sin cambiar lógica |
| `refactor` | Reorganizar código sin cambiar su comportamiento |
| `perf` | Rendimiento (imágenes más livianas, etc.) |
| `test` | Pruebas |
| `build` | Dependencias, `package.json` |
| `ci` | Automatizaciones de GitHub |
| `chore` | Mantenimiento (`.gitignore`, configuración) |
| `revert` | Deshacer un commit anterior |

**Bien:** `feat(equipo): agregar tarjetas con foto y rol`
**Mal:** `cambios`, `Update index.html`, `ya quedó`

Un commit = un cambio lógico. Si el mensaje necesita un “y”, probablemente son dos commits.

## 5. Orden de commits sugerido para este proyecto

| # | Rama | Mensaje |
|---|------|---------|
| 1 | `main` | `chore: crear estructura inicial del proyecto` |
| 2 | `main` | `chore: agregar .gitignore y .editorconfig` |
| 3 | `feature/estructura-html` | `feat(html): agregar cabecera, hero y pie de página` |
| 4 | `feature/estructura-html` | `feat(juegos): agregar bloques de Skathos y Void Mask` |
| 5 | `feature/estructura-html` | `feat(equipo): agregar tarjetas de los seis integrantes` |
| 6 | `feature/estilos` | `style(css): definir variables de color y tipografía` |
| 7 | `feature/estilos` | `feat(css): agregar diseño responsive y menú móvil` |
| 8 | `feature/interacciones-js` | `feat(js): agregar menú móvil y animaciones al hacer scroll` |
| 9 | `feature/interacciones-js` | `feat(equipo): agregar filtro por área` |
| 10 | `feature/interacciones-js` | `feat(newsletter): validar correo antes de enviar` |
| 11 | `feature/fotos-equipo` | `feat(img): agregar fotos del equipo y logo` |
| 12 | `feature/fotos-equipo` | `perf(img): convertir fotos a webp` |
| 13 | `feature/readme` | `docs(readme): agregar funcionalidades, stack y estructura` |
| 14 | `feature/readme` | `docs: agregar guía de git y licencia MIT` |
| 15 | `develop` | `build: agregar prettier y live-server como devDependencies` |
| 16 | `develop` | `refactor(css): agrupar estilos por sección` |

Repartan los commits entre todos: así cada integrante aparece como contribuyente en GitHub.

## 6. Si algo sale mal

- **Conflicto al hacer merge:** GitHub Desktop muestra los archivos en conflicto → **Open in Visual Studio Code** → elige *Accept Current*, *Accept Incoming* o *Accept Both* → guarda → **Continue merge**.
- **Commit con mensaje equivocado (sin hacer push):** clic derecho en el commit → **Amend commit**.
- **Deshacer un commit ya subido:** clic derecho → **Revert changes in commit** (crea un commit `revert` sin borrar historia).
