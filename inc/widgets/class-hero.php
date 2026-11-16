<?php
/**
 * Widget "Mandoca Hero": título principal, cita y botones.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;

/**
 * Hero de la portada.
 */
class Mandoca_Hero_Widget extends Mandoca_Widget_Base {

	/**
	 * Plantilla que dibuja este widget.
	 *
	 * @var string
	 */
	protected $part = 'hero';

	/**
	 * Nombre interno.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'mandoca-hero';
	}

	/**
	 * Nombre en el panel.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mandoca Hero', 'mandoca-studio' );
	}

	/**
	 * Ícono en el panel.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-banner';
	}

	/**
	 * Campos y estilos del widget.
	 */
	protected function register_controls() {
		// Content: textos.
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Content', 'mandoca-studio' ) ) );
		$this->add_text( 'section_id', esc_html__( 'Section ID', 'mandoca-studio' ) );
		$this->add_text( 'eyebrow', esc_html__( 'Eyebrow', 'mandoca-studio' ) );
		$this->add_textarea(
			'title',
			esc_html__( 'Title', 'mandoca-studio' ),
			array( 'description' => esc_html__( 'Words between *asterisks* are highlighted in orange.', 'mandoca-studio' ) )
		);
		$this->add_textarea( 'quote', esc_html__( 'Quote', 'mandoca-studio' ) );
		$this->add_text( 'cite', esc_html__( 'Quote author', 'mandoca-studio' ) );
		$this->end_controls_section();

		// Content: botones.
		$this->start_controls_section( 'buttons', array( 'label' => esc_html__( 'Buttons', 'mandoca-studio' ) ) );
		$this->add_text( 'btn1_text', esc_html__( 'Main button text', 'mandoca-studio' ) );
		$this->add_link( 'btn1_link', esc_html__( 'Main button link', 'mandoca-studio' ), $this->default_value( 'btn1_url' ) );
		$this->add_text( 'btn2_text', esc_html__( 'Second button text', 'mandoca-studio' ) );
		$this->add_link( 'btn2_link', esc_html__( 'Second button link', 'mandoca-studio' ), $this->default_value( 'btn2_url' ) );
		$this->end_controls_section();

		// Content: extras.
		$this->start_controls_section( 'extras', array( 'label' => esc_html__( 'Background & scroll hint', 'mandoca-studio' ) ) );
		$this->add_switch( 'show_orbs', esc_html__( 'Glowing background orbs', 'mandoca-studio' ) );
		$this->add_text(
			'scroll_text',
			esc_html__( 'Scroll hint text', 'mandoca-studio' ),
			array( 'description' => esc_html__( 'Leave empty to hide it.', 'mandoca-studio' ) )
		);
		$this->add_link( 'scroll_link', esc_html__( 'Scroll hint link', 'mandoca-studio' ), $this->default_value( 'scroll_url' ) );
		$this->end_controls_section();

		// Style: sección.
		$this->start_controls_section(
			'style_hero',
			array(
				'label' => esc_html__( 'Section', 'mandoca-studio' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'min_height',
			array(
				'label'      => esc_html__( 'Minimum height', 'mandoca-studio' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'vh', 'px' ),
				'range'      => array(
					'vh' => array(
						'min' => 40,
						'max' => 100,
					),
					'px' => array(
						'min' => 300,
						'max' => 1200,
					),
				),
				'selectors'  => array( '{{WRAPPER}} .hero' => 'min-height: {{SIZE}}{{UNIT}};' ),
			)
		);
		$this->add_control(
			'hero_bg',
			array(
				'label'     => esc_html__( 'Background color', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .hero' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'orb1_color',
			array(
				'label'     => esc_html__( 'Orb 1 color', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .orb-1' => 'background: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'orb2_color',
			array(
				'label'     => esc_html__( 'Orb 2 color', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .orb-2' => 'background: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();

		// Style: textos.
		$this->start_text_styles();
		$this->add_text_style( 'eyebrow', esc_html__( 'Eyebrow', 'mandoca-studio' ), '{{WRAPPER}} .eyebrow' );
		$this->add_text_style( 'title', esc_html__( 'Title', 'mandoca-studio' ), '{{WRAPPER}} .hero-title' );
		$this->add_text_style( 'highlight', esc_html__( 'Highlighted words', 'mandoca-studio' ), '{{WRAPPER}} .hero-title em', false );
		$this->add_text_style( 'quote', esc_html__( 'Quote', 'mandoca-studio' ), '{{WRAPPER}} .hero-quote p' );
		$this->add_control(
			'quote_line',
			array(
				'label'     => esc_html__( 'Quote line color', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .hero-quote' => 'border-left-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();

		// Style: botones.
		$this->start_controls_section(
			'style_buttons',
			array(
				'label' => esc_html__( 'Buttons', 'mandoca-studio' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'btn1_bg',
			array(
				'label'     => esc_html__( 'Main button background', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .btn-primary' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'btn1_color',
			array(
				'label'     => esc_html__( 'Main button text', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .btn-primary' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'btn2_border',
			array(
				'label'     => esc_html__( 'Second button border', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .btn-ghost' => 'border-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Dibuja el widget con template-parts/hero.php.
	 */
	protected function render() {
		$s = $this->get_settings_for_display();

		$this->render_part(
			array(
				'section_id'  => $s['section_id'],
				'eyebrow'     => $s['eyebrow'],
				'title'       => $s['title'],
				'quote'       => $s['quote'],
				'cite'        => $s['cite'],
				'btn1_text'   => $s['btn1_text'],
				'btn1_url'    => $this->url( $s['btn1_link'] ),
				'btn2_text'   => $s['btn2_text'],
				'btn2_url'    => $this->url( $s['btn2_link'] ),
				'show_orbs'   => 'yes' === $s['show_orbs'],
				'scroll_text' => $s['scroll_text'],
				'scroll_url'  => $this->url( $s['scroll_link'] ),
			)
		);
	}
}
