# Arte de los juegos

Una imagen por juego, horizontal (16:9 o 16:10), en formato `.webp`, con estos nombres exactos:

| Juego                         | Archivo                          | Origen                                                                                 |
| ----------------------------- | -------------------------------- | -------------------------------------------------------------------------------------- |
| Meteor Strike                 | `meteor-strike.webp`             | Portada del juego (pixel art de 300×200, ampliada 5× sin suavizado). Ajuste: *Contain* |
| Echoes                        | `echoes.webp`                    | Arte del juego (1092×614)                                                              |
| Tadventure: Road to Neverpond | `tadventure-road-neverpond.webp` | Portada del juego (862×480, ampliada 2×)                                               |
| Unknown Project               | `unknown-project.webp`           | *Pendiente*                                                                            |

- **En WordPress:** al activar el tema (o con `wp mandoca seed`) las imágenes de esta carpeta se suben solas a la Biblioteca de medios y quedan como arte de cada juego, si el juego todavía no tiene uno. Para cambiarlas: *Games → editar el juego → Game art*.
- **En la vista previa (Live Server):** `preview/index.html` usa estos mismos archivos. Cuando agregues una imagen, agrega también su `<img>` en `preview/index.html` (igual que el de Meteor Strike).
- Si un juego no tiene imagen, se muestra un arte provisional hecho con CSS.
