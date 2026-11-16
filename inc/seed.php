<?php
/**
 * Datos iniciales ("seed").
 *
 * Al activar el tema, y una sola vez, se crean las áreas, los 6 integrantes,
 * los 2 juegos y el logo. Si el tema se activa de nuevo no se duplica nada:
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
		'programacion'    => 'Programación',
		'arte'            => 'Arte',
		'audio-narrativa' => 'Audio y narrativa',
	);
}

/**
 * Los 6 integrantes con sus roles y descripciones actuales.
 *
 * @return array
 */
function mandoca_seed_members() {
	return array(
		array(
			'name' => 'JackRevon',
			'area' => 'audio-narrativa',
			'role' => 'Compositor y diseñador de sonido',
			'bio'  => 'Compone la música original y crea los efectos de sonido. Se encarga de que cada mundo tenga su propia atmósfera.',
		),
		array(
			'name' => 'Jhonken099',
			'area' => 'programacion',
			'role' => 'Programador de mecánicas y UI',
			'bio'  => 'Programa las mecánicas principales y las interfaces: menús, HUD e inventarios que el jugador usa en todo momento.',
		),
		array(
			'name' => 'Devz',
			'area' => 'programacion',
			'role' => 'Programador de gameplay y herramientas',
			'bio'  => 'Construye el gameplay y las herramientas internas que aceleran el trabajo del resto del equipo dentro del motor.',
		),
		array(
			'name' => 'CrimReaper',
			'area' => 'arte',
			'role' => 'Artista conceptual e ilustrador',
			'bio'  => 'Define el estilo visual: dibuja personajes, escenarios y las ilustraciones que sirven de guía para todo el arte del juego.',
		),
		array(
			'name' => 'Momoye',
			'area' => 'arte',
			'role' => 'Generalista 3D, animador y diseñador',
			'bio'  => 'Modela, texturiza y anima en 3D. Lleva los conceptos de papel a modelos que se mueven dentro del juego.',
		),
		array(
			'name' => 'GLDNWTCH',
			'area' => 'audio-narrativa',
			'role' => 'Guionista y planificador de escenarios',
			'bio'  => 'Escribe la historia, los diálogos y el orden de los escenarios para que cada nivel cuente algo.',
		),
	);
}

/**
 * Los 2 juegos con sus datos actuales (textos provisionales hasta que el
 * equipo los confirme).
 *
 * @return array
 */
function mandoca_seed_games() {
	return array(
		array(
			'title'   => 'Skathos',
			'slug'    => 'skathos',
			'content' => 'Un mundo oscuro y vertical donde cada ascenso cuesta y cada caída enseña algo. Nuestra primera apuesta por un juego que mezcle exploración, combate y una historia contada a través del entorno.',
			'estado'  => 'En desarrollo',
			'genero'  => 'Acción · Aventura',
			'anio'    => '2026',
			'equipo'  => "Arte: CrimReaper\nMúsica: JackRevon\nHistoria: GLDNWTCH",
			'ajuste'  => 'cover',
			'image'   => 'assets/img/juegos/skathos.webp',
		),
		array(
			'title'   => 'Void Mask',
			'slug'    => 'void-mask',
			'content' => 'Una máscara que deja ver lo que el mundo esconde. Un prototipo de puzzles narrativos donde cambiar de perspectiva es la única forma de avanzar.',
			'estado'  => 'Prototipo',
			'genero'  => 'Puzzle · Narrativo',
			'anio'    => '2026',
			'equipo'  => "Mecánicas: Jhonken099\nGameplay: Devz\n3D y animación: Momoye",
			'ajuste'  => 'contain',
			'image'   => 'assets/img/juegos/void-mask.webp',
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
		$slug = sanitize_title( $member['name'] );
		if ( get_page_by_path( $slug, OBJECT, 'miembro' ) ) {
			continue;
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'miembro',
				'post_status'  => 'publish',
				'post_title'   => $member['name'],
				'post_name'    => $slug,
				'post_content' => $member['bio'],
				'menu_order'   => $order,
			),
			true
		);
		if ( is_wp_error( $id ) ) {
			continue;
		}
		update_post_meta( $id, '_mandoca_rol', $member['role'] );
		wp_set_object_terms( $id, $member['area'], 'area' );
	}

	// Juegos.
	foreach ( mandoca_seed_games() as $order => $game ) {
		if ( get_page_by_path( $game['slug'], OBJECT, 'juego' ) ) {
			continue;
		}
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
		foreach ( array( 'estado', 'genero', 'anio', 'equipo', 'ajuste' ) as $key ) {
			update_post_meta( $id, '_mandoca_' . $key, $game[ $key ] );
		}
		$image_id = mandoca_seed_image( $game['image'], $game['title'], $id );
		if ( $image_id ) {
			set_post_thumbnail( $id, $image_id );
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
	if ( ! file_exists( $path ) ) {
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
