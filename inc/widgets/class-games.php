<?php
/**
 * Widget "Mandoca Games": un bloque grande por juego.
 *
 * El diseño se edita aquí; los juegos (texto, arte, estado…) se editan en
 * el panel, en "Games".
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;

/**
 * Vitrina de juegos.
 */
class Mandoca_Games_Widget extends Mandoca_Widget_Base {

	/**
	 * Plantilla que dibuja este widget.
	 *
	 * @var string
	 */
	protected $part = 'juegos';

	/**
	 * Nombre interno.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'mandoca-games';
	}

	/**
	 * Nombre en el panel.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mandoca Games', 'mandoca-studio' );
	}

	/**
	 * Ícono en el panel.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
	}

	/**
	 * Lee los juegos del panel: Elementor no debe guardar una copia vieja.
	 *
	 * @return bool
	 */
	protected function is_dynamic_content(): bool {
		return true;
	}

	/**
	 * Campos y estilos del widget.
	 */
	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Content', 'mandoca-studio' ) ) );
		$this->add_content_note( esc_html__( 'Games (text, art, status, credits) are edited in Dashboard → Games. Use the "Order" field to sort them.', 'mandoca-studio' ), 'juego' );
		$this->add_section_fields();
		$this->add_text( 'eyebrow', esc_html__( 'Eyebrow', 'mandoca-studio' ) );
		$this->add_text( 'title', esc_html__( 'Title', 'mandoca-studio' ) );
		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'mandoca-studio' ),
				'type'    => Controls_Manager::SELECT,
				'default' => $this->default_value( 'layout' ),
				'options' => array(
					'showcase' => esc_html__( 'Showcase (full-width panels)', 'mandoca-studio' ),
					'blocks'   => esc_html__( 'Blocks (art and text alternated)', 'mandoca-studio' ),
				),
			)
		);
		$this->add_responsive_control(
			'showcase_height',
			array(
				'label'      => esc_html__( 'Showcase height', 'mandoca-studio' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'vh', 'px' ),
				'range'      => array(
					'vh' => array(
						'min' => 40,
						'max' => 100,
					),
					'px' => array(
						'min' => 360,
						'max' => 1000,
					),
				),
				'selectors'  => array( '{{WRAPPER}} .showcase.is-ready' => 'height: {{SIZE}}{{UNIT}};' ),
				'condition'  => array( 'layout' => 'showcase' ),
			)
		);
		$this->add_switch( 'zigzag', esc_html__( 'Alternate image side', 'mandoca-studio' ), array( 'condition' => array( 'layout' => 'blocks' ) ) );
		$this->add_control(
			'limit',
			array(
				'label'       => esc_html__( 'Number of games', 'mandoca-studio' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'default'     => 0,
				'description' => esc_html__( '0 shows all games.', 'mandoca-studio' ),
			)
		);
		$this->end_controls_section();

		$this->add_section_style();

		$this->start_text_styles();
		$this->add_text_style( 'eyebrow', esc_html__( 'Eyebrow', 'mandoca-studio' ), '{{WRAPPER}} .eyebrow' );
		$this->add_text_style( 'heading', esc_html__( 'Section title', 'mandoca-studio' ), '{{WRAPPER}} .section-head h2' );
		$this->add_text_style( 'game_title', esc_html__( 'Game title', 'mandoca-studio' ), '{{WRAPPER}} .game-info h3' );
		$this->add_text_style( 'game_text', esc_html__( 'Game description', 'mandoca-studio' ), '{{WRAPPER}} .game-info > p:not(.game-meta)' );
		$this->add_text_style( 'art_title', esc_html__( 'Title over the art', 'mandoca-studio' ), '{{WRAPPER}} .art-title' );
		$this->end_controls_section();

		$this->start_controls_section(
			'style_art',
			array(
				'label' => esc_html__( 'Art frame', 'mandoca-studio' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'art_radius',
			array(
				'label'      => esc_html__( 'Corner radius', 'mandoca-studio' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 48,
					),
				),
				'selectors'  => array( '{{WRAPPER}} .game-art' => 'border-radius: {{SIZE}}{{UNIT}};' ),
			)
		);
		$this->add_control(
			'tag_bg',
			array(
				'label'     => esc_html__( 'Status tag background', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .tag' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Dibuja el widget con template-parts/juegos.php.
	 */
	protected function render() {
		$s     = $this->get_settings_for_display();
		$limit = (int) $s['limit'];
		$games = mandoca_get_games( $limit > 0 ? $limit : -1 );

		if ( ! $games ) {
			$this->editor_notice( esc_html__( 'There are no published games yet. Add them in Dashboard → Games.', 'mandoca-studio' ) );
		}

		$this->render_part(
			array(
				'section_id' => $s['section_id'],
				'layout'     => $s['layout'],
				'alt'        => 'yes' === $s['alt'],
				'eyebrow'    => $s['eyebrow'],
				'title'      => $s['title'],
				'zigzag'     => 'yes' === $s['zigzag'],
				'games'      => $games,
			)
		);
	}
}
