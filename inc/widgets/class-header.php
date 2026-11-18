<?php
/**
 * Widget "Mandoca Header": logo, nombre, menú y botón de contacto.
 *
 * Va dentro de la plantilla de Elementor "Header" (Templates → Saved
 * Templates), que el tema muestra arriba de todas las páginas.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

/**
 * Cabecera del sitio.
 */
class Mandoca_Header_Widget extends Mandoca_Widget_Base {

	/**
	 * Plantilla que dibuja este widget.
	 *
	 * @var string
	 */
	protected $part = 'cabecera';

	/**
	 * Nombre interno.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'mandoca-header';
	}

	/**
	 * Nombre en el panel.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mandoca Header', 'mandoca-studio' );
	}

	/**
	 * Ícono en el panel.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-header';
	}

	/**
	 * Campos y estilos del widget.
	 */
	protected function register_controls() {
		$this->start_controls_section( 'brand_section', array( 'label' => esc_html__( 'Brand', 'mandoca-studio' ) ) );
		$this->add_control(
			'layout',
			array(
				'label'       => esc_html__( 'Layout on desktop', 'mandoca-studio' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => $this->default_value( 'layout' ),
				'options'     => array(
					'sidebar' => esc_html__( 'Sidebar (vertical, left)', 'mandoca-studio' ),
					'top'     => esc_html__( 'Top bar', 'mandoca-studio' ),
				),
				'description' => esc_html__( 'On phones both look like a top bar with a menu button.', 'mandoca-studio' ),
			)
		);
		$this->add_control(
			'logo',
			array(
				'label'       => esc_html__( 'Logo', 'mandoca-studio' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => array( 'url' => '' ),
				'description' => esc_html__( 'Leave empty to use the logo from Appearance → Customize → Site Identity.', 'mandoca-studio' ),
			)
		);
		$this->add_text(
			'brand',
			esc_html__( 'Brand name', 'mandoca-studio' ),
			array( 'description' => esc_html__( 'The first dot is shown in orange.', 'mandoca-studio' ) )
		);
		$this->end_controls_section();

		$this->start_controls_section( 'menu_section', array( 'label' => esc_html__( 'Menu', 'mandoca-studio' ) ) );
		$link = new Repeater();
		$link->add_control(
			'text',
			array(
				'label' => esc_html__( 'Text', 'mandoca-studio' ),
				'type'  => Controls_Manager::TEXT,
			)
		);
		$link->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'mandoca-studio' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => '#seccion o https://…',
			)
		);
		$default_links = array();
		foreach ( $this->default_value( 'links' ) as $item ) {
			$default_links[] = array(
				'text' => $item['text'],
				'link' => array( 'url' => $item['url'] ),
			);
		}
		$this->add_control(
			'links',
			array(
				'label'       => esc_html__( 'Links', 'mandoca-studio' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $link->get_controls(),
				'default'     => $default_links,
				'title_field' => '{{{ text }}}',
				'description' => esc_html__( 'Use #ID to jump to a section of the home page (e.g. #equipo).', 'mandoca-studio' ),
			)
		);
		$this->add_text( 'cta_text', esc_html__( 'Button text', 'mandoca-studio' ) );
		$this->add_link( 'cta_link', esc_html__( 'Button link', 'mandoca-studio' ), $this->default_value( 'cta_url' ) );
		$this->end_controls_section();

		$this->start_controls_section(
			'style_header',
			array(
				'label' => esc_html__( 'Header', 'mandoca-studio' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'header_bg',
			array(
				'label'     => esc_html__( 'Background color', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .site-header' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_responsive_control(
			'logo_size',
			array(
				'label'      => esc_html__( 'Logo size', 'mandoca-studio' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 24,
						'max' => 64,
					),
				),
				'selectors'  => array( '{{WRAPPER}} .brand .brand-logo' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'brand_typography',
				'label'    => esc_html__( 'Brand typography', 'mandoca-studio' ),
				'selector' => '{{WRAPPER}} .brand-name',
			)
		);
		$this->add_control(
			'link_color',
			array(
				'label'     => esc_html__( 'Menu links', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .nav a:not(.nav-cta)' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'link_hover',
			array(
				'label'     => esc_html__( 'Menu links (hover)', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .nav a:not(.nav-cta):hover' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'cta_border',
			array(
				'label'     => esc_html__( 'Button border', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .nav a.nav-cta' => 'border-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Dibuja el widget con template-parts/cabecera.php.
	 */
	protected function render() {
		$s = $this->get_settings_for_display();

		$this->render_part(
			array(
				'layout'   => $s['layout'],
				'logo_url' => $this->url( $s['logo'] ),
				'brand'    => $s['brand'],
				'links'    => $this->links( $s['links'] ),
				'cta_text' => $s['cta_text'],
				'cta_url'  => $this->url( $s['cta_link'] ),
			)
		);
	}
}
