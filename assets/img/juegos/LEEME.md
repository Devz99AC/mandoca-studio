# Arte de los juegos

Una imagen por juego, horizontal (16:9 o 16:10), en formato `.webp`, con estos nombres exactos:

| Juego                      | Archivo                          | Origen |
|----------------------------|----------------------------------|--------|
| Meteor Strike              | `meteor-strike.webp`             | Arte del juego (pantalla de victoria) |
| Echoes                     | `echoes.webp`                    | *Pendiente* |
| Tadventure Road: Neverpond | `tadventure-road-neverpond.webp` | *Pendiente* (página de la Global Game Jam 2025) |
| Unknown Project            | `unknown-project.webp`           | *Pendiente* |

- **En WordPress:** al activar el tema (o con `wp mandoca seed`) las imágenes de esta carpeta se suben solas a la Biblioteca de medios y quedan como arte de cada juego, si el juego todavía no tiene uno. Para cambiarlas: *Games → editar el juego → Game art*.
- **En la vista previa (Live Server):** `preview/index.html` usa estos mismos archivos. Cuando agregues una imagen, agrega también su `<img>` en `preview/index.html` (igual que el de Meteor Strike).
- Si un juego no tiene imagen, se muestra un arte provisional hecho con CSS.
