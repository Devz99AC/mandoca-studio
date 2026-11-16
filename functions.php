<?php
/**
 * Mandoca Studio — funciones del tema.
 *
 * Aquí se prepara el tema (soportes de WordPress), se encolan los estilos y
 * scripts, y se cargan los archivos de la carpeta inc/.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

define( 'MANDOCA_VERSION', '1.0.0' );
define( 'MANDOCA_DIR', get_template_directory() );
define( 'MANDOCA_URI', get_template_directory_uri() );

// Idioma del contenido del sitio (los textos de la página están en español,
// aunque el panel de WordPress esté en inglés).
define( 'MANDOCA_CONTENT_LANG', 'es' );

// Versiones fijas de las librerías de animación (las mismas en preview/index.html).
define( 'MANDOCA_GSAP_VERSION', '3.13.0' );
define( 'MANDOCA_MATTER_VERSION', '0.20.0' );

require_once MANDOCA_DIR . '/inc/helpers.php';
require_once MANDOCA_DIR . '/inc/defaults.php';
require_once MANDOCA_DIR . '/inc/socials.php';
require_once MANDOCA_DIR . '/inc/cpt.php';
require_once MANDOCA_DIR . '/inc/meta-boxes.php';
require_once MANDOCA_DIR . '/inc/seed.php';
require_once MANDOCA_DIR . '/inc/elementor.php';

/**
 * Soportes del tema: título automático, imágenes destacadas, logo, etc.
 */
function mandoca_setup() {
	load_theme_textdomain( 'mandoca-studio', MANDOCA_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'html5',
		array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	// Logo editable desde Apariencia > Personalizar > Identidad del sitio.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 256,
			'width'       => 256,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Tamaños de imagen que usa el tema.
	add_image_size( 'mandoca-member', 600, 600, true );
	add_image_size( 'mandoca-game', 1280, 800, true );
}
add_action( 'after_setup_theme', 'mandoca_setup' );

/**
 * Encola estilos y scripts del tema.
 *
 * Nunca escribimos <link> ni <script> a mano en las plantillas: WordPress los
 * imprime en wp_head() y wp_footer() con el orden y las versiones correctas.
 */
function mandoca_enqueue_assets() {
	wp_enqueue_style(
		'mandoca-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=JetBrains+Mono:wght@400;600&family=Montserrat:ital,wght@0,600;0,800;1,800&display=swap',
		array(),
		null // Google Fonts no necesita número de versión.
	);

	wp_enqueue_style(
		'mandoca-main',
		MANDOCA_URI . '/assets/css/main.css',
		array( 'mandoca-fonts' ),
		mandoca_asset_version( 'assets/css/main.css' )
	);

	$defer = array(
		'in_footer' => true,
		'strategy'  => 'defer',
	);

	wp_enqueue_script( 'mandoca-main', MANDOCA_URI . '/assets/js/main.js', array(), mandoca_asset_version( 'assets/js/main.js' ), $defer );

	// GSAP y sus plugins desde jsDelivr, con versión fija.
	$gsap = 'https://cdn.jsdelivr.net/npm/gsap@' . MANDOCA_GSAP_VERSION . '/dist/';
	wp_register_script( 'gsap', $gsap . 'gsap.min.js', array(), null, true );
	wp_register_script( 'gsap-scrolltrigger', $gsap . 'ScrollTrigger.min.js', array( 'gsap' ), null, true );
	wp_register_script( 'gsap-flip', $gsap . 'Flip.min.js', array( 'gsap' ), null, true );
	wp_register_script( 'gsap-splittext', $gsap . 'SplitText.min.js', array( 'gsap' ), null, true );

	// Los archivos de GSAP dejan window.default apuntando a GSAP; el reproductor
	// de medios de WordPress (que Elementor usa en el editor) espera que sea la
	// ventana. Después de cada archivo lo devolvemos a su lugar.
	foreach ( array( 'gsap', 'gsap-scrolltrigger', 'gsap-flip', 'gsap-splittext' ) as $mandoca_handle ) {
		wp_add_inline_script( $mandoca_handle, 'window.default = window;' );
	}

	// Matter.js (física). Solo se carga en las páginas que tienen el círculo con física.
	wp_register_script( 'matter-js', 'https://cdn.jsdelivr.net/npm/matter-js@' . MANDOCA_MATTER_VERSION . '/build/matter.min.js', array(), null, true );

	wp_enqueue_script(
		'mandoca-animations',
		MANDOCA_URI . '/assets/js/animations.js',
		array( 'gsap', 'gsap-scrolltrigger', 'gsap-flip', 'gsap-splittext', 'mandoca-main' ),
		mandoca_asset_version( 'assets/js/animations.js' ),
		$defer
	);
}
add_action( 'wp_enqueue_scripts', 'mandoca_enqueue_assets' );

/**
 * Cambia la clase "no-js" por "js" en <html> antes de pintar la página.
 * Así el CSS puede esconder el título del hero hasta que empiece su
 * animación, sin parpadeos. Sin JavaScript todo se ve normal.
 */
function mandoca_js_class() {
	wp_print_inline_script_tag( "document.documentElement.classList.replace('no-js','js');" );
}
add_action( 'wp_head', 'mandoca_js_class', 0 );

/**
 * Conecta con Google Fonts antes de pedir las tipografías (carga más rápida).
 *
 * @param array  $urls          URLs para la sugerencia.
 * @param string $relation_type Tipo de sugerencia (preconnect, dns-prefetch...).
 * @return array
 */
function mandoca_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'mandoca_resource_hints', 10, 2 );

/**
 * Favicon del tema mientras no se suba un "Icono del sitio" en Personalizar.
 */
function mandoca_favicon() {
	if ( has_site_icon() ) {
		return;
	}
	printf(
		'<link rel="icon" href="%s" type="image/svg+xml">' . "\n",
		esc_url( MANDOCA_URI . '/assets/img/favicon.svg' )
	);
}
add_action( 'wp_head', 'mandoca_favicon' );

/**
 * Meta descripción de la portada (el texto está en inc/defaults.php).
 */
function mandoca_meta_description() {
	if ( ! is_front_page() ) {
		return;
	}
	$description = mandoca_defaults( 'site' )['meta_description'];
	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
}
add_action( 'wp_head', 'mandoca_meta_description', 1 );

/**
 * Separador del título de la pestaña: "Mandoca Studio — Juegos creativos…".
 *
 * @return string
 */
function mandoca_title_separator() {
	return '—';
}
add_filter( 'document_title_separator', 'mandoca_title_separator' );

/**
 * El panel puede estar en inglés, pero el contenido de la página está en
 * español: marcamos el idioma correcto en <html lang="..."> para lectores de
 * pantalla y buscadores.
 *
 * @param string $output Atributos de idioma.
 * @return string
 */
function mandoca_content_language( $output ) {
	if ( is_admin() ) {
		return $output;
	}
	return preg_replace( '/lang="[^"]*"/', 'lang="' . esc_attr( MANDOCA_CONTENT_LANG ) . '"', $output );
}
add_filter( 'language_attributes', 'mandoca_content_language' );
