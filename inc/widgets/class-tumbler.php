<?php
/**
 * Widget "Mandoca Tumbler": anillo de texto que gira con piezas que ruedan
 * dentro con física real (Matter.js).
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * Círculo con física.
 */
class Mandoca_Tumbler_Widget extends Mandoca_Widget_Base {

	/**
	 * Plantilla que dibuja este widget.
	 *
	 * @var string
	 */
	protected $part = 'tumbler';

	/**
	 * Nombre interno.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'mandoca-tumbler';
	}

	/**
	 * Nombre en el panel.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mandoca Tumbler (physics)', 'mandoca-studio' );
	}

	/**
	 * Ícono en el panel.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-spinner';
	}

	/**
	 * Matter.js solo se carga en las páginas que usan este widget.
	 *
	 * @return string[]
	 */
	public function get_script_depends() {
		return array( 'matter-js' );
	}

	/**
	 * Campos y estilos del widget.
	 */
	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Content', 'mandoca-studio' ) ) );
		$this->add_section_fields();
		$this->add_text(
			'ring_text',
			esc_html__( 'Ring text', 'mandoca-studio' ),
			array( 'description' => esc_html__( 'It is stretched to fill the whole circle. End it with " · " so it joins smoothly.', 'mandoca-studio' ) )
		);
		$this->add_control(
			'pieces',
			array(
				'label'   => esc_html__( 'Number of pieces', 'mandoca-studio' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 40,
				'default' => $this->default_value( 'pieces' ),
			)
		);
		$this->add_control(
			'piece',
			array(
				'label'       => esc_html__( 'Piece image', 'mandoca-studio' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => array( 'url' => '' ),
				'description' => esc_html__( 'Square PNG with transparency. Empty uses the Mandoca logo.', 'mandoca-studio' ),
			)
		);
		$this->end_controls_section();

		$this->add_section_style();

		$this->start_controls_section(
			'style_ring',
			array(
				'label' => esc_html__( 'Ring', 'mandoca-studio' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'stage_size',
			array(
				'label'      => esc_html__( 'Size', 'mandoca-studio' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vw', 'vh' ),
				'range'      => array(
					'px' => array(
						'min' => 240,
						'max' => 900,
					),
				),
				'selectors'  => array( '{{WRAPPER}} .tumbler-stage' => 'width: {{SIZE}}{{UNIT}};' ),
			)
		);
		$this->add_control(
			'ring_color',
			array(
				'label'     => esc_html__( 'Text color', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .tumbler-ring text' => 'fill: {{VALUE}};' ),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'ring_typography',
				'selector' => '{{WRAPPER}} .tumbler-ring text',
				'exclude'  => array( 'font_size', 'line_height' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Dibuja el widget con template-parts/tumbler.php.
	 */
	protected function render() {
		$s = $this->get_settings_for_display();
		$this->render_part(
			array(
				'section_id' => $s['section_id'],
				'alt'        => 'yes' === $s['alt'],
				'ring_text'  => $s['ring_text'],
				'pieces'     => (int) $s['pieces'],
				'piece_url'  => $this->url( $s['piece'] ),
			)
		);
	}
}
