<?php
/**
 * Widget "Mandoca Marquee": cinta de palabras infinita que reacciona al scroll.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * Cinta (marquee).
 */
class Mandoca_Marquee_Widget extends Mandoca_Widget_Base {

	/**
	 * Plantilla que dibuja este widget.
	 *
	 * @var string
	 */
	protected $part = 'marquee';

	/**
	 * Nombre interno.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'mandoca-marquee';
	}

	/**
	 * Nombre en el panel.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mandoca Marquee', 'mandoca-studio' );
	}

	/**
	 * Ícono en el panel.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-animation-text';
	}

	/**
	 * Campos y estilos del widget.
	 */
	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Content', 'mandoca-studio' ) ) );
		$this->add_text(
			'text',
			esc_html__( 'Words', 'mandoca-studio' ),
			array( 'description' => esc_html__( 'Separate words with "·". They alternate between outline and orange fill.', 'mandoca-studio' ) )
		);
		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Speed (px per second)', 'mandoca-studio' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 10,
				'max'     => 400,
				'default' => $this->default_value( 'speed' ),
			)
		);
		$this->add_control(
			'direction',
			array(
				'label'   => esc_html__( 'Direction', 'mandoca-studio' ),
				'type'    => Controls_Manager::SELECT,
				'default' => $this->default_value( 'direction' ),
				'options' => array(
					'left'  => esc_html__( 'To the left', 'mandoca-studio' ),
					'right' => esc_html__( 'To the right', 'mandoca-studio' ),
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_marquee',
			array(
				'label' => esc_html__( 'Marquee', 'mandoca-studio' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'band_bg',
			array(
				'label'     => esc_html__( 'Background color', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .marquee' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'outline_color',
			array(
				'label'     => esc_html__( 'Outline words', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .marquee-item.is-outline' => '-webkit-text-stroke-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'fill_color',
			array(
				'label'     => esc_html__( 'Filled words', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .marquee-item.is-fill' => 'color: {{VALUE}};' ),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'words_typography',
				'selector' => '{{WRAPPER}} .marquee-item, {{WRAPPER}} .marquee-sep',
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Dibuja el widget con template-parts/marquee.php.
	 */
	protected function render() {
		$s = $this->get_settings_for_display();
		$this->render_part(
			array(
				'text'      => $s['text'],
				'speed'     => (int) $s['speed'],
				'direction' => $s['direction'],
			)
		);
	}
}
