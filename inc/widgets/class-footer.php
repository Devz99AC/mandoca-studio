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
use Elementor\Repeater;

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

		$social = new Repeater();
		$social->add_control(
			'text',
			array(
				'label' => esc_html__( 'Network', 'mandoca-studio' ),
				'type'  => Controls_Manager::TEXT,
			)
		);
		$social->add_control(
			'link',
			array(
				'label' => esc_html__( 'Link', 'mandoca-studio' ),
				'type'  => Controls_Manager::URL,
			)
		);
		$default_socials = array();
		foreach ( $this->default_value( 'socials' ) as $item ) {
			$default_socials[] = array(
				'text' => $item['text'],
				'link' => array( 'url' => $item['url'] ),
			);
		}
		$this->add_control(
			'socials',
			array(
				'label'       => esc_html__( 'Social networks', 'mandoca-studio' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $social->get_controls(),
				'default'     => $default_socials,
				'title_field' => '{{{ text }}}',
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
		$this->add_text_style( 'social', esc_html__( 'Social links', 'mandoca-studio' ), '{{WRAPPER}} .socials a' );
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
				'brand'   => $s['brand'],
				'socials' => $this->links( $s['socials'] ),
				'copy'    => $s['copy'],
			)
		);
	}
}
