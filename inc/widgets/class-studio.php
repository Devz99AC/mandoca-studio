<?php
/**
 * Widget "Mandoca Studio Intro": presentación del estudio y cifras.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Repeater;

/**
 * Sección "Estudio".
 */
class Mandoca_Studio_Widget extends Mandoca_Widget_Base {

	/**
	 * Plantilla que dibuja este widget.
	 *
	 * @var string
	 */
	protected $part = 'estudio';

	/**
	 * Nombre interno.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'mandoca-studio-intro';
	}

	/**
	 * Nombre en el panel.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mandoca Studio Intro', 'mandoca-studio' );
	}

	/**
	 * Ícono en el panel.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-counter';
	}

	/**
	 * Campos y estilos del widget.
	 */
	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Content', 'mandoca-studio' ) ) );
		$this->add_section_fields();
		$this->add_text( 'eyebrow', esc_html__( 'Eyebrow', 'mandoca-studio' ) );
		$this->add_textarea( 'title', esc_html__( 'Title', 'mandoca-studio' ) );
		$this->add_textarea( 'text', esc_html__( 'Text', 'mandoca-studio' ), array( 'rows' => 5 ) );

		$stat = new Repeater();
		$stat->add_control(
			'number',
			array(
				'label'       => esc_html__( 'Number', 'mandoca-studio' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Numbers count up from 0 when they appear.', 'mandoca-studio' ),
			)
		);
		$stat->add_control(
			'label',
			array(
				'label' => esc_html__( 'Label', 'mandoca-studio' ),
				'type'  => Controls_Manager::TEXT,
			)
		);
		$this->add_control(
			'stats',
			array(
				'label'       => esc_html__( 'Stats', 'mandoca-studio' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $stat->get_controls(),
				'default'     => $this->default_value( 'stats' ),
				'title_field' => '{{{ number }}} {{{ label }}}',
			)
		);
		$this->end_controls_section();

		$this->add_section_style();

		$this->start_text_styles();
		$this->add_text_style( 'eyebrow', esc_html__( 'Eyebrow', 'mandoca-studio' ), '{{WRAPPER}} .eyebrow' );
		$this->add_text_style( 'heading', esc_html__( 'Title', 'mandoca-studio' ), '{{WRAPPER}} .section-head h2' );
		$this->add_text_style( 'body', esc_html__( 'Text', 'mandoca-studio' ), '{{WRAPPER}} .studio-text p' );
		$this->add_text_style( 'number', esc_html__( 'Numbers', 'mandoca-studio' ), '{{WRAPPER}} .stats dt' );
		$this->add_text_style( 'label', esc_html__( 'Number labels', 'mandoca-studio' ), '{{WRAPPER}} .stats dd' );
		$this->end_controls_section();
	}

	/**
	 * Dibuja el widget con template-parts/estudio.php.
	 */
	protected function render() {
		$s     = $this->get_settings_for_display();
		$stats = array();
		foreach ( (array) $s['stats'] as $row ) {
			$stats[] = array(
				'number' => isset( $row['number'] ) ? $row['number'] : '',
				'label'  => isset( $row['label'] ) ? $row['label'] : '',
			);
		}

		$this->render_part(
			array(
				'section_id' => $s['section_id'],
				'alt'        => 'yes' === $s['alt'],
				'eyebrow'    => $s['eyebrow'],
				'title'      => $s['title'],
				'text'       => $s['text'],
				'stats'      => $stats,
			)
		);
	}
}
