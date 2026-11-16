<?php
/**
 * Integración con Elementor (versión gratis).
 *
 * - Avisa en el panel si Elementor no está instalado.
 * - Agrega la categoría "Mandoca Studio" y sus widgets al editor.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Aviso en el panel si Elementor no está activo.
 */
function mandoca_elementor_missing_notice() {
	if ( did_action( 'elementor/loaded' ) || ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	printf(
		'<div class="notice notice-warning"><p>%s <a href="%s">%s</a></p></div>',
		esc_html__( 'The Mandoca Studio theme is designed to be edited with Elementor (free).', 'mandoca-studio' ),
		esc_url( admin_url( 'plugin-install.php?s=elementor&tab=search&type=term' ) ),
		esc_html__( 'Install Elementor', 'mandoca-studio' )
	);
}
add_action( 'admin_notices', 'mandoca_elementor_missing_notice' );

/**
 * Carga los colores y fuentes globales de Elementor (Site Settings) en todas
 * las páginas. Elementor solo lo hace en las páginas armadas con él, y el CSS
 * del tema los necesita en todas (ver assets/css/main.css).
 */
function mandoca_elementor_global_styles() {
	if ( did_action( 'elementor/loaded' ) ) {
		\Elementor\Plugin::$instance->kits_manager->frontend_before_enqueue_styles();
	}
}
add_action( 'wp_enqueue_scripts', 'mandoca_elementor_global_styles', 5 );

/**
 * Categoría "Mandoca Studio" en el panel de widgets de Elementor.
 *
 * @param \Elementor\Elements_Manager $elements_manager Administrador de elementos.
 */
function mandoca_elementor_category( $elements_manager ) {
	$elements_manager->add_category(
		'mandoca',
		array(
			'title' => esc_html__( 'Mandoca Studio', 'mandoca-studio' ),
			'icon'  => 'eicon-gallery-grid',
		)
	);
}
add_action( 'elementor/elements/categories_registered', 'mandoca_elementor_category' );

/**
 * Lista de widgets Mandoca: archivo en inc/widgets/ => clase.
 *
 * @return array
 */
function mandoca_elementor_widget_list() {
	return array(
		'header'    => 'Mandoca_Header_Widget',
		'footer'    => 'Mandoca_Footer_Widget',
		'hero'      => 'Mandoca_Hero_Widget',
		'games'     => 'Mandoca_Games_Widget',
		'studio'    => 'Mandoca_Studio_Widget',
		'team'      => 'Mandoca_Team_Widget',
		'community' => 'Mandoca_Community_Widget',
	);
}

/**
 * Registra los widgets Mandoca en Elementor.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Administrador de widgets.
 */
function mandoca_elementor_widgets( $widgets_manager ) {
	require_once MANDOCA_DIR . '/inc/widgets/class-mandoca-widget-base.php';

	foreach ( mandoca_elementor_widget_list() as $file => $class ) {
		require_once MANDOCA_DIR . '/inc/widgets/class-' . $file . '.php';
		$widgets_manager->register( new $class() );
	}
}
add_action( 'elementor/widgets/register', 'mandoca_elementor_widgets' );

/**
 * ID de la plantilla de Elementor de la cabecera o del pie.
 *
 * Las plantillas se crean al activar el tema (inc/seed.php) y se editan en
 * Templates → Saved Templates → "Header" / "Footer".
 *
 * @param string $location "header" o "footer".
 * @return int 0 si no existe o no está publicada.
 */
function mandoca_elementor_template_id( $location ) {
	if ( ! did_action( 'elementor/loaded' ) ) {
		return 0;
	}
	$id = (int) get_option( 'mandoca_' . $location . '_template' );
	return ( $id && 'publish' === get_post_status( $id ) ) ? $id : 0;
}

/**
 * Imprime la plantilla de Elementor de la cabecera o del pie.
 *
 * @param string $location "header" o "footer".
 * @return bool true si se imprimió; false para usar la versión PHP de respaldo.
 */
function mandoca_render_elementor_template( $location ) {
	$id = mandoca_elementor_template_id( $location );
	if ( ! $id ) {
		return false;
	}
	$html = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $id );
	if ( '' === trim( $html ) ) {
		return false;
	}
	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML generado y escapado por Elementor.
	return true;
}

/**
 * Carga en el <head> los estilos de la cabecera y el pie de Elementor
 * (si no, llegarían tarde y la página parpadearía).
 */
function mandoca_elementor_template_styles() {
	foreach ( array( 'header', 'footer' ) as $location ) {
		$id = mandoca_elementor_template_id( $location );
		if ( $id ) {
			\Elementor\Core\Files\CSS\Post::create( $id )->enqueue();
		}
	}
}
add_action( 'wp_enqueue_scripts', 'mandoca_elementor_template_styles', 20 );

/**
 * ¿Se está viendo o editando una plantilla de Elementor?
 * En ese caso el tema no agrega su propia cabecera ni su pie.
 *
 * @return bool
 */
function mandoca_is_elementor_template_view() {
	return is_singular( 'elementor_library' );
}
