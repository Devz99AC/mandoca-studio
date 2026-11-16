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
