<?php
/**
 * Datos iniciales ("seed").
 *
 * Al activar el tema, y una sola vez, se crean las áreas, los 5 integrantes
 * (con su foto de assets/img/equipo/), los 4 juegos y el logo. Si el tema se activa de nuevo no se duplica nada:
 * se guarda una marca en la opción "mandoca_seed_content" y además se revisa
 * si cada integrante o juego ya existe antes de crearlo.
 *
 * Si cambias estos datos, cambia también preview/index.html.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Áreas del equipo (taxonomía "area"), en el orden del filtro.
 *
 * @return array slug => nombre.
 */
function mandoca_seed_areas() {
	return array(
		'programacion' => 'Programación',
		'arte'         => 'Arte',
		'audio'        => 'Audio',
	);
}

/**
 * Los 5 integrantes, con los datos de mandocastudio.com/about-us: rol
 * (traducido), cita favorita (en su idioma original), juegos favoritos y
 * lo que están jugando.
 *
 * @return array
 */
function mandoca_seed_members() {
	return array(
		array(
			'name'      => 'JackRevon',
			'area'      => 'audio',
			'role'      => 'Compositor y diseñador de sonido',
			'cita'      => 'Why worry about a problem if it has a solution? And if it doesn’t, why worry?',
			'fuente'    => '',
			'favoritos' => 'Factorio, OSRS, Darkwood, Jak and Daxter Saga',
			'jugando'   => 'Elden Ring',
		),
		array(
			'name'      => 'Jhonken099',
			'area'      => 'programacion',
			'role'      => 'Programador de mecánicas y UI',
			'cita'      => 'The past can hurt. But the way I see it, you can either run from it or learn from it.',
			'fuente'    => 'The Lion King',
			'favoritos' => 'GOW Ragnarok, Mass Effect 2, Enter the Gungeon, TLOU 2',
			'jugando'   => 'SMT and Persona Series',
		),
		array(
			'name'      => 'Devz',
			'area'      => 'programacion',
			'role'      => 'Programador de gameplay y herramientas',
			'cita'      => 'I am here to Even the Odds.',
			'fuente'    => 'Final Fantasy XVI',
			'favoritos' => 'The Witcher 3, Metaphor: ReFantazio, Warcraft Series',
			'jugando'   => 'Xenoblade Chronicles 3',
		),
		array(
			'name'      => 'CrimReaper',
			'area'      => 'arte',
			'role'      => 'Artista conceptual e ilustrador',
			'cita'      => 'I’m not talented at all. It’s just that I spend more time thinking about art than others',
			'fuente'    => 'Blue Period',
			'favoritos' => 'Hollow Knight, Patapon 2, Mario Galaxy, A Link to the Past',
			'jugando'   => 'Final Fantasy IX',
		),
		array(
			'name'      => 'Momoye',
			'area'      => 'arte',
			'role'      => 'Generalista 3D, animador y diseñador',
			'cita'      => 'I am the morning sun, come to vanquish this horrible night.',
			'fuente'    => 'Castlevania: Order of Ecclesia',
			'favoritos' => 'Symphony of The Night, Dark Souls, Persona 3, SF: 3rd Strike',
			'jugando'   => 'The Legend of Zelda: Breath of the Wild',
		),
	);
}

/**
 * Los 4 juegos del estudio.
 *
 * El arte de cada uno va en assets/img/juegos/<slug>.webp. Si todavía no
 * está, se ve un arte provisional; cuando se agregue el archivo, el seed lo
 * pone solo (al activar el tema o con `wp mandoca seed`).
 * Los textos son provisionales hasta que el equipo los confirme.
 *
 * @return array
 */
function mandoca_seed_games() {
	return array(
		array(
			'title'        => 'Meteor Strike',
			'slug'         => 'meteor-strike',
			'content'      => "Después de ganar la guerra contra los humanos, los animales conquistaron las estrellas y fundaron una Federación Galáctica. Todo era paz hasta que llegó, en meteoritos, un parásito malvado que da comezón. La Federación envía a sus dos mejores soldados, Chicharrón y Pepperoni, a proteger a todos los animales.\n\nHecho para la Juntos Game Jam, a beneficio de los afectados por el terremoto en Venezuela.",
			'estado'       => 'Game jam',
			'genero'       => '',
			'anio'         => '2026',
			'equipo'       => '',
			'ajuste'       => 'contain', // Portada completa (pixel art con su propio fondo).
			'enlace'       => '',
			'enlace_texto' => '',
			'image'        => 'assets/img/juegos/meteor-strike.webp',
		),
		array(
			'title'        => 'Echoes',
			'slug'         => 'echoes',
			'content'      => 'Descubre Echoes en su página de itch.io.',
			'estado'       => 'En itch.io',
			'genero'       => '',
			'anio'         => '',
			'equipo'       => '',
			'ajuste'       => 'cover',
			'enlace'       => 'https://mandocastudio.itch.io/echoes',
			'enlace_texto' => 'Ver en itch.io',
			'image'        => 'assets/img/juegos/echoes.webp',
		),
		array(
			'title'        => 'Tadventure: Road to Neverpond',
			'slug'         => 'tadventure-road-neverpond',
			'content'      => 'Hecho para la Global Game Jam 2025.',
			'estado'       => 'Game jam',
			'genero'       => '',
			'anio'         => '2025',
			'equipo'       => '',
			'ajuste'       => 'cover',
			'enlace'       => '',
			'enlace_texto' => '',
			'image'        => 'assets/img/juegos/tadventure-road-neverpond.webp',
		),
		array(
			'title'        => 'Unknown Project',
			'slug'         => 'unknown-project',
			'content'      => 'Muy pronto compartiremos más sobre este proyecto.',
			'estado'       => 'En desarrollo',
			'genero'       => '',
			'anio'         => '',
			'equipo'       => '',
			'ajuste'       => 'cover',
			'enlace'       => '',
			'enlace_texto' => '',
			'image'        => 'assets/img/juegos/unknown-project.webp',
		),
	);
}

/**
 * Crea áreas, integrantes, juegos y logo (una sola vez).
 *
 * @param bool $force true para ignorar la marca de "ya sembrado" (no duplica igual).
 */
function mandoca_seed_content( $force = false ) {
	if ( get_option( 'mandoca_seed_content' ) && ! $force ) {
		return;
	}
	if ( ! post_type_exists( 'miembro' ) || ! post_type_exists( 'juego' ) ) {
		return;
	}

	// Áreas.
	foreach ( mandoca_seed_areas() as $slug => $name ) {
		if ( ! term_exists( $slug, 'area' ) ) {
			wp_insert_term( $name, 'area', array( 'slug' => $slug ) );
		}
	}

	// Integrantes.
	foreach ( mandoca_seed_members() as $order => $member ) {
		$slug     = sanitize_title( $member['name'] );
		$existing = get_page_by_path( $slug, OBJECT, 'miembro' );
		$id       = $existing ? $existing->ID : 0;

		if ( ! $id ) {
			$id = wp_insert_post(
				array(
					'post_type'    => 'miembro',
					'post_status'  => 'publish',
					'post_title'   => $member['name'],
					'post_name'    => $slug,
					'post_content' => '',
					'menu_order'   => $order,
				),
				true
			);
			if ( is_wp_error( $id ) ) {
				continue;
			}
			update_post_meta( $id, '_mandoca_rol', $member['role'] );
			foreach ( array( 'cita', 'fuente', 'favoritos', 'jugando' ) as $key ) {
				update_post_meta( $id, '_mandoca_' . $key, $member[ $key ] );
			}
			wp_set_object_terms( $id, $member['area'], 'area' );
		}

		// Foto: assets/img/equipo/<alias>.webp, solo si existe y el integrante
		// todavía no tiene una (no reemplaza las que se suban desde el panel).
		if ( ! has_post_thumbnail( $id ) ) {
			$photo_id = mandoca_seed_image( 'assets/img/equipo/' . $slug . '.webp', $member['name'], $id );
			if ( $photo_id ) {
				set_post_thumbnail( $id, $photo_id );
			}
		}
	}

	// Juegos.
	foreach ( mandoca_seed_games() as $order => $game ) {
		$existing = get_page_by_path( $game['slug'], OBJECT, 'juego' );
		$id       = $existing ? $existing->ID : 0;

		if ( ! $id ) {
			$id = wp_insert_post(
				array(
					'post_type'    => 'juego',
					'post_status'  => 'publish',
					'post_title'   => $game['title'],
					'post_name'    => $game['slug'],
					'post_content' => $game['content'],
					'menu_order'   => $order,
				),
				true
			);
			if ( is_wp_error( $id ) ) {
				continue;
			}
			foreach ( array( 'estado', 'genero', 'anio', 'equipo', 'ajuste', 'enlace', 'enlace_texto' ) as $key ) {
				update_post_meta( $id, '_mandoca_' . $key, $game[ $key ] );
			}
		}

		// Arte: solo si el archivo existe y el juego todavía no tiene imagen
		// (no reemplaza la que se suba desde el panel).
		if ( $game['image'] && ! has_post_thumbnail( $id ) ) {
			$image_id = mandoca_seed_image( $game['image'], $game['title'], $id );
			if ( $image_id ) {
				set_post_thumbnail( $id, $image_id );
			}
		}
	}

	// Logo (solo si todavía no se subió uno en Personalizar).
	if ( ! get_theme_mod( 'custom_logo' ) ) {
		$logo_id = mandoca_seed_image( 'assets/img/logo-mark.png', 'Mandoca Studio' );
		if ( $logo_id ) {
			set_theme_mod( 'custom_logo', $logo_id );
		}
	}

	update_option( 'mandoca_seed_content', MANDOCA_VERSION, false );
}
add_action( 'after_switch_theme', 'mandoca_seed_content' );

/**
 * Sube una imagen del tema a la Biblioteca de medios (una sola vez).
 *
 * @param string $relative Ruta dentro del tema.
 * @param string $title    Título de la imagen.
 * @param int    $parent   Entrada a la que pertenece (0 = ninguna).
 * @return int ID del adjunto, o 0 si falló.
 */
function mandoca_seed_image( $relative, $title, $parent = 0 ) {
	$path = MANDOCA_DIR . '/' . $relative;
	if ( ! $relative || ! is_file( $path ) ) {
		return 0;
	}

	// ¿Ya se subió antes? Se reconoce por la ruta guardada en sus metadatos.
	$existing = get_posts(
		array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'fields'      => 'ids',
			'numberposts' => 1,
			'meta_key'    => '_mandoca_seed_source', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- solo corre al activar el tema.
			'meta_value'  => $relative, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value -- solo corre al activar el tema.
		)
	);
	if ( $existing ) {
		return (int) $existing[0];
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// WordPress mueve el archivo al subirlo, así que trabajamos con una copia.
	$tmp = wp_tempnam( basename( $path ) );
	if ( ! $tmp || ! copy( $path, $tmp ) ) {
		return 0;
	}

	$id = media_handle_sideload(
		array(
			'name'     => basename( $path ),
			'tmp_name' => $tmp,
		),
		$parent,
		$title
	);

	if ( is_wp_error( $id ) ) {
		wp_delete_file( $tmp );
		return 0;
	}

	update_post_meta( $id, '_mandoca_seed_source', $relative );
	return (int) $id;
}

/**
 * Configuración de Elementor (una sola vez, cuando Elementor está activo).
 *
 * Se ejecuta al activar el tema y también al entrar al panel, por si
 * Elementor se instala después del tema.
 *
 * @param bool $force true para ignorar la marca de "ya configurado".
 */
function mandoca_seed_elementor( $force = false ) {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return;
	}
	if ( get_option( 'mandoca_seed_elementor' ) && ! $force ) {
		return;
	}

	if ( ! mandoca_seed_kit() ) {
		return; // Elementor todavía no creó su kit; se intenta en la próxima carga.
	}

	mandoca_seed_elementor_template( 'header', 'Header', 'mandoca-header' );
	mandoca_seed_elementor_template( 'footer', 'Footer', 'mandoca-footer' );
	mandoca_seed_front_page();

	update_option( 'mandoca_seed_elementor', MANDOCA_VERSION, false );
	\Elementor\Plugin::$instance->files_manager->clear_cache();
}
add_action( 'after_switch_theme', 'mandoca_seed_elementor', 20 );
add_action( 'admin_init', 'mandoca_seed_elementor' );

/**
 * Colores y fuentes globales de Elementor (Site Settings) con la marca.
 *
 * Los colores del sistema se reemplazan; los colores propios que haya creado
 * el diseñador se conservan.
 *
 * @return bool true si se pudo guardar.
 */
function mandoca_seed_kit() {
	$kit_id = (int) \Elementor\Plugin::$instance->kits_manager->get_active_id();
	if ( ! $kit_id || ! get_post( $kit_id ) ) {
		return false;
	}

	$settings = get_post_meta( $kit_id, '_elementor_page_settings', true );
	$settings = is_array( $settings ) ? $settings : array();

	$settings['system_colors'] = array(
		array(
			'_id'   => 'primary',
			'title' => 'Black (background)',
			'color' => '#0A0A0A',
		),
		array(
			'_id'   => 'secondary',
			'title' => 'White (text)',
			'color' => '#FFFFFF',
		),
		array(
			'_id'   => 'text',
			'title' => 'Light gray (secondary text)',
			'color' => '#ADADAD',
		),
		array(
			'_id'   => 'accent',
			'title' => 'Orange (accent)',
			'color' => '#E55901',
		),
	);

	$brand_colors = array(
		'gris'  => array(
			'_id'   => 'gris',
			'title' => 'Dark gray (details)',
			'color' => '#585858',
		),
		'crema' => array(
			'_id'   => 'crema',
			'title' => 'Cream (details)',
			'color' => '#FEF1E4',
		),
	);
	$custom = isset( $settings['custom_colors'] ) && is_array( $settings['custom_colors'] ) ? $settings['custom_colors'] : array();
	foreach ( $custom as $color ) {
		if ( isset( $color['_id'] ) && ! isset( $brand_colors[ $color['_id'] ] ) ) {
			$brand_colors[ $color['_id'] ] = $color;
		}
	}
	$settings['custom_colors'] = array_values( $brand_colors );

	$settings['system_typography'] = array(
		array(
			'_id'                    => 'primary',
			'title'                  => 'Headings (Montserrat)',
			'typography_typography'  => 'custom',
			'typography_font_family' => 'Montserrat',
			'typography_font_weight' => '800',
		),
		array(
			'_id'                    => 'secondary',
			'title'                  => 'Subheadings (Montserrat)',
			'typography_typography'  => 'custom',
			'typography_font_family' => 'Montserrat',
			'typography_font_weight' => '600',
		),
		array(
			'_id'                    => 'text',
			'title'                  => 'Body (Inter)',
			'typography_typography'  => 'custom',
			'typography_font_family' => 'Inter',
			'typography_font_weight' => '400',
		),
		array(
			'_id'                    => 'accent',
			'title'                  => 'Labels (JetBrains Mono)',
			'typography_typography'  => 'custom',
			'typography_font_family' => 'JetBrains Mono',
			'typography_font_weight' => '400',
		),
	);

	// Ancho de los contenedores de Elementor igual al del tema (1160 px).
	$settings['container_width'] = array(
		'unit'  => 'px',
		'size'  => 1160,
		'sizes' => array(),
	);

	update_post_meta( $kit_id, '_elementor_page_settings', $settings );

	// Que Elementor no imponga sus colores y fuentes por defecto: manda el tema.
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );

	return true;
}

/**
 * ID aleatorio de 7 caracteres, como los que usa Elementor para cada elemento.
 *
 * @return string
 */
function mandoca_el_id() {
	return substr( md5( wp_generate_uuid4() ), 0, 7 );
}

/**
 * Un contenedor de Elementor a todo el ancho, sin relleno, con un widget adentro.
 * Es la "fila" que el diseñador ve en el editor.
 *
 * @param string $widget Nombre interno del widget (por ejemplo, "mandoca-hero").
 * @param string $title  Nombre de la fila en el panel "Structure" de Elementor.
 * @return array
 */
function mandoca_el_section( $widget, $title = '' ) {
	return array(
		'id'       => mandoca_el_id(),
		'elType'   => 'container',
		'isInner'  => false,
		'settings' => array(
			'_title'        => $title,
			'content_width' => 'full',
			'padding'       => array(
				'unit'     => 'px',
				'top'      => '0',
				'right'    => '0',
				'bottom'   => '0',
				'left'     => '0',
				'isLinked' => true,
			),
		),
		'elements' => array(
			array(
				'id'         => mandoca_el_id(),
				'elType'     => 'widget',
				'widgetType' => $widget,
				'settings'   => array(),
				'elements'   => array(),
			),
		),
	);
}

/**
 * Guarda un diseño de Elementor en una página o plantilla.
 *
 * @param int    $post_id  Página o plantilla.
 * @param array  $elements Elementos de Elementor.
 * @param string $type     Tipo de documento de Elementor ("wp-page", "section").
 */
function mandoca_el_save( $post_id, $elements, $type ) {
	update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $post_id, '_elementor_template_type', $type );
	update_post_meta( $post_id, '_elementor_version', ELEMENTOR_VERSION );
	update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( $elements ) ) );
}

/**
 * Crea la plantilla "Header" o "Footer" en Templates → Saved Templates.
 *
 * @param string $location "header" o "footer".
 * @param string $title    Nombre de la plantilla.
 * @param string $widget   Widget que lleva adentro.
 */
function mandoca_seed_elementor_template( $location, $title, $widget ) {
	if ( mandoca_elementor_template_id( $location ) ) {
		return; // Ya existe: no duplicar.
	}

	$id = wp_insert_post(
		array(
			'post_type'   => 'elementor_library',
			'post_status' => 'publish',
			'post_title'  => $title,
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		return;
	}

	mandoca_el_save( $id, array( mandoca_el_section( $widget, $title ) ), 'section' );
	wp_set_object_terms( $id, 'section', 'elementor_library_type' );
	update_option( 'mandoca_' . $location . '_template', $id );
}

/**
 * Crea la página "Inicio" armada con los widgets Mandoca y la pone de portada.
 * Si la portada ya tiene contenido o diseño de Elementor, no la toca.
 */
function mandoca_seed_front_page() {
	$page_id = (int) get_option( 'page_on_front' );

	if ( 'page' !== get_option( 'show_on_front' ) || ! $page_id || ! get_post( $page_id ) ) {
		$existing = get_page_by_path( 'inicio' );
		$page_id  = $existing ? $existing->ID : wp_insert_post(
			array(
				'post_type'   => 'page',
				'post_status' => 'publish',
				'post_title'  => 'Inicio',
				'post_name'   => 'inicio',
			),
			true
		);
		if ( is_wp_error( $page_id ) ) {
			return;
		}
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_id );
	}

	if ( get_post_meta( $page_id, '_elementor_data', true ) || '' !== trim( (string) get_post_field( 'post_content', $page_id ) ) ) {
		return;
	}

	$sections = array(
		'mandoca-hero'         => 'Hero',
		'mandoca-marquee'      => 'Cinta',
		'mandoca-games'        => 'Juegos',
		'mandoca-carousel'     => 'Destacados',
		'mandoca-studio-intro' => 'Estudio',
		'mandoca-team'         => 'Equipo',
	);
	mandoca_el_save( $page_id, array_map( 'mandoca_el_section', array_keys( $sections ), $sections ), 'wp-page' );
}

/**
 * Comando de terminal para volver a sembrar los datos (sin duplicar):
 *   wp mandoca seed
 */
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command(
		'mandoca seed',
		function () {
			mandoca_seed_content( true );
			if ( function_exists( 'mandoca_seed_elementor' ) ) {
				mandoca_seed_elementor( true );
			}
			WP_CLI::success( 'Datos de Mandoca Studio revisados: lo que faltaba se creó, nada se duplicó.' );
		}
	);
}
