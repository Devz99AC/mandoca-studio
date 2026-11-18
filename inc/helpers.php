<?php
/**
 * Funciones de ayuda que usan las plantillas y los widgets.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Versión de un archivo del tema para que el navegador no use una copia vieja
 * (usa la fecha de modificación del archivo).
 *
 * @param string $relative Ruta dentro del tema, por ejemplo "assets/css/main.css".
 * @return string
 */
function mandoca_asset_version( $relative ) {
	$path = MANDOCA_DIR . '/' . ltrim( $relative, '/' );
	return file_exists( $path ) ? (string) filemtime( $path ) : MANDOCA_VERSION;
}

/**
 * Imprime una sección de template-parts/ con sus datos.
 *
 * Los datos que no se pasen se toman de mandoca_defaults(). Así la misma
 * plantilla sirve para el widget de Elementor y para la portada sin Elementor.
 *
 * @param string $slug Nombre del archivo en template-parts/ (sin .php).
 * @param array  $args Datos de la sección.
 */
function mandoca_render_part( $slug, $args = array() ) {
	get_template_part( 'template-parts/' . $slug, null, wp_parse_args( $args, mandoca_defaults( $slug ) ) );
}

/**
 * Iniciales de un nombre: "JackRevon" → "JA". Se usan cuando falta la foto.
 *
 * @param string $name Alias del integrante.
 * @return string
 */
function mandoca_initials( $name ) {
	$letters = preg_replace( '/[^A-Za-z]/', '', remove_accents( (string) $name ) );
	return strtoupper( substr( $letters, 0, 2 ) );
}

/**
 * Título con palabras resaltadas: lo que va entre *asteriscos* se pinta en
 * naranja. Primero se escapa el texto y después se agregan las etiquetas <em>.
 *
 * @param string $text Texto escrito en el panel.
 * @return string HTML seguro.
 */
function mandoca_highlight( $text ) {
	return preg_replace( '/\*(.+?)\*/u', '<em>$1</em>', esc_html( $text ) );
}

/**
 * Nombre de la marca con el punto en naranja: "Mandoca.Studio".
 *
 * @param string $text Nombre escrito en el panel.
 * @return string HTML seguro.
 */
function mandoca_brand_html( $text ) {
	return preg_replace( '/\./', '<span class="brand-dot">.</span>', esc_html( $text ), 1 );
}

/**
 * Enlaces de una sola página: "#juegos" funciona en la portada; en otras
 * páginas se convierte en "https://sitio/#juegos" para volver a la portada.
 *
 * @param string $url Enlace escrito en el panel.
 * @return string
 */
function mandoca_section_url( $url ) {
	if ( is_string( $url ) && 0 === strpos( $url, '#' ) && ! is_front_page() ) {
		return home_url( '/' ) . $url;
	}
	return $url;
}

/**
 * Texto con el año actual: "© {year} Mandoca Studio" → "© 2026 Mandoca Studio".
 * El año queda dentro de <span data-year> para que JS lo actualice.
 *
 * @param string $text Texto escrito en el panel.
 * @return string HTML seguro.
 */
function mandoca_with_year( $text ) {
	$year = '<span data-year>' . esc_html( gmdate( 'Y' ) ) . '</span>';
	return str_replace( '{year}', $year, esc_html( $text ) );
}

/**
 * URL del logo: el que se suba en Personalizar > Identidad del sitio o, si no
 * hay, el que trae el tema.
 *
 * @return string
 */
function mandoca_logo_url() {
	$logo_id = get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		$url = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}
	return MANDOCA_URI . '/assets/img/logo-mark.png';
}

/**
 * Integrantes del equipo (tipo de contenido "miembro"), en el orden del panel.
 *
 * @return array Lista de integrantes con nombre, rol, descripción, área y foto.
 */
function mandoca_get_members() {
	if ( ! post_type_exists( 'miembro' ) ) {
		return array();
	}

	$posts   = get_posts(
		array(
			'post_type'      => 'miembro',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'ASC',
			),
		)
	);
	$members = array();

	foreach ( $posts as $post ) {
		$areas     = get_the_terms( $post, 'area' );
		$members[] = array(
			'name'         => get_the_title( $post ),
			'role'         => get_post_meta( $post->ID, '_mandoca_rol', true ),
			'quote'        => get_post_meta( $post->ID, '_mandoca_cita', true ),
			'quote_source' => get_post_meta( $post->ID, '_mandoca_fuente', true ),
			'favorites'    => get_post_meta( $post->ID, '_mandoca_favoritos', true ),
			'playing'      => get_post_meta( $post->ID, '_mandoca_jugando', true ),
			'bio'          => $post->post_content,
			'area'         => ( $areas && ! is_wp_error( $areas ) ) ? $areas[0]->slug : '',
			'photo_id'     => get_post_thumbnail_id( $post ),
		);
	}

	return $members;
}

/**
 * Áreas del equipo (taxonomía "area") que tienen al menos un integrante.
 *
 * @return array slug => nombre.
 */
function mandoca_get_areas() {
	if ( ! taxonomy_exists( 'area' ) ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'area',
			'hide_empty' => true,
			'orderby'    => 'term_id',
		)
	);

	if ( is_wp_error( $terms ) ) {
		return array();
	}

	return wp_list_pluck( $terms, 'name', 'slug' );
}

/**
 * Juegos (tipo de contenido "juego"), en el orden del panel.
 *
 * @param int $limit Cuántos mostrar (-1 = todos).
 * @return array Lista de juegos con sus datos.
 */
function mandoca_get_games( $limit = -1 ) {
	if ( ! post_type_exists( 'juego' ) ) {
		return array();
	}

	$posts = get_posts(
		array(
			'post_type'      => 'juego',
			'post_status'    => 'publish',
			'posts_per_page' => (int) $limit,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'ASC',
			),
		)
	);
	$games = array();

	foreach ( $posts as $post ) {
		$credits = (string) get_post_meta( $post->ID, '_mandoca_equipo', true );
		$games[] = array(
			'slug'     => $post->post_name,
			'title'    => get_the_title( $post ),
			'content'  => $post->post_content,
			'status'   => get_post_meta( $post->ID, '_mandoca_estado', true ),
			'genre'    => get_post_meta( $post->ID, '_mandoca_genero', true ),
			'year'     => get_post_meta( $post->ID, '_mandoca_anio', true ),
			'credits'  => array_values( array_filter( array_map( 'trim', explode( "\n", $credits ) ) ) ),
			'fit'      => get_post_meta( $post->ID, '_mandoca_ajuste', true ) === 'contain' ? 'contain' : 'cover',
			'image_id' => get_post_thumbnail_id( $post ),
		);
	}

	return $games;
}

/**
 * Imprime la imagen de un juego (de la Biblioteca de medios o por URL).
 *
 * @param array  $game  Datos del juego (de mandoca_get_games()).
 * @param string $class Clase CSS de la imagen.
 */
function mandoca_game_image( $game, $class ) {
	if ( ! empty( $game['image_id'] ) ) {
		echo wp_get_attachment_image(
			$game['image_id'],
			'contain' === $game['fit'] ? 'large' : 'mandoca-game',
			false,
			array(
				'class'     => $class,
				'alt'       => '',
				'loading'   => 'lazy',
				'draggable' => 'false',
			)
		);
	} elseif ( ! empty( $game['image_url'] ) ) {
		printf( '<img class="%s" src="%s" alt="" loading="lazy" draggable="false">', esc_attr( $class ), esc_url( $game['image_url'] ) );
	}
}

/**
 * Línea de datos de un juego: "Acción · Aventura / 2026".
 *
 * @param array  $game      Datos del juego.
 * @param string $separator Separador entre género y año.
 * @return string
 */
function mandoca_game_meta( $game, $separator ) {
	return implode( $separator, array_filter( array( $game['genre'], $game['year'] ) ) );
}

/**
 * ¿La página actual se armó con Elementor?
 *
 * @param int $post_id ID de la página.
 * @return bool
 */
function mandoca_is_built_with_elementor( $post_id ) {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return false;
	}
	$document = \Elementor\Plugin::instance()->documents->get( $post_id );
	return $document && $document->is_built_with_elementor();
}
