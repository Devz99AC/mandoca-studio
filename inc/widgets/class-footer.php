<?php
/**
 * Widget "Mandoca Footer": marca, redes sociales y derechos.
 *
 * Va dentro de la plantilla de Elementor "Footer" (Templates → Saved
 * Templates), que el tema muestra al final de todas las páginas.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;

/**
 * Pie del sitio.
 */
class Mandoca_Footer_Widget extends Mandoca_Widget_Base {

	/**
	 * Plantilla que dibuja este widget.
	 *
	 * @var string
	 */
	protected $part = 'pie';

	/**
	 * Nombre interno.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'mandoca-footer';
	}

	/**
	 * Nombre en el panel.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mandoca Footer', 'mandoca-studio' );
	}

	/**
	 * Ícono en el panel.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-footer';
	}

	/**
	 * Campos y estilos del widget.
	 */
	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Content', 'mandoca-studio' ) ) );
		$this->add_text(
			'brand',
			esc_html__( 'Brand name', 'mandoca-studio' ),
			array( 'description' => esc_html__( 'The first dot is shown in orange.', 'mandoca-studio' ) )
		);

		$this->add_switch( 'show_socials', esc_html__( 'Show social networks', 'mandoca-studio' ) );
		$this->add_control(
			'socials_note',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf(
					'%s <a href="%s" target="_blank">%s</a>',
					esc_html__( 'The networks are edited in one place for the whole site.', 'mandoca-studio' ),
					esc_url( admin_url( 'customize.php?autofocus[section]=mandoca_socials' ) ),
					esc_html__( 'Open Customize → Social networks', 'mandoca-studio' )
				),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);
		$this->add_text(
			'copy',
			esc_html__( 'Copyright text', 'mandoca-studio' ),
			array( 'description' => esc_html__( '{year} is replaced by the current year.', 'mandoca-studio' ) )
		);
		$this->end_controls_section();

		$this->add_section_style( '{{WRAPPER}} .site-footer' );

		$this->start_text_styles();
		$this->add_text_style( 'brand', esc_html__( 'Brand name', 'mandoca-studio' ), '{{WRAPPER}} .footer-brand' );
		$this->add_text_style( 'social', esc_html__( 'Social links', 'mandoca-studio' ), '{{WRAPPER}} .footer-socials a', false );
		$this->add_text_style( 'copy', esc_html__( 'Copyright', 'mandoca-studio' ), '{{WRAPPER}} .copy' );
		$this->end_controls_section();
	}

	/**
	 * Dibuja el widget con template-parts/pie.php.
	 */
	protected function render() {
		$s = $this->get_settings_for_display();

		$this->render_part(
			array(
				'brand'        => $s['brand'],
				'show_socials' => 'yes' === $s['show_socials'],
				'copy'         => $s['copy'],
			)
		);
	}
}
