<?php
/**
 * Widget "Mandoca Featured Carousel": carrusel infinito de juegos.
 *
 * El diseño se edita aquí; los juegos se editan en el panel, en "Games".
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;

/**
 * Carrusel de destacados.
 */
class Mandoca_Carousel_Widget extends Mandoca_Widget_Base {

	/**
	 * Plantilla que dibuja este widget.
	 *
	 * @var string
	 */
	protected $part = 'destacados';

	/**
	 * Nombre interno.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'mandoca-carousel';
	}

	/**
	 * Nombre en el panel.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mandoca Featured Carousel', 'mandoca-studio' );
	}

	/**
	 * Ícono en el panel.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-slider-push';
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
		$this->add_content_note( esc_html__( 'The cards show the games from Dashboard → Games. Clicking a card opens that game in the Games showcase.', 'mandoca-studio' ), 'juego' );
		$this->add_section_fields();
		$this->add_text( 'title', esc_html__( 'Title', 'mandoca-studio' ) );
		$this->add_text( 'tab_text', esc_html__( 'Card side tab text', 'mandoca-studio' ) );
		$this->add_link( 'card_link', esc_html__( 'Card link', 'mandoca-studio' ), $this->default_value( 'card_url' ) );
		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Speed (px per second)', 'mandoca-studio' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 300,
				'default' => $this->default_value( 'speed' ),
			)
		);
		$this->end_controls_section();

		$this->add_section_style();

		$this->start_controls_section(
			'style_cards',
			array(
				'label' => esc_html__( 'Cards', 'mandoca-studio' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'card_width',
			array(
				'label'      => esc_html__( 'Card width', 'mandoca-studio' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vw' ),
				'range'      => array(
					'px' => array(
						'min' => 220,
						'max' => 800,
					),
					'vw' => array(
						'min' => 20,
						'max' => 90,
					),
				),
				'selectors'  => array( '{{WRAPPER}} .card' => 'width: {{SIZE}}{{UNIT}};' ),
			)
		);
		$this->add_control(
			'tab_bg',
			array(
				'label'     => esc_html__( 'Side tab color', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .card-tab' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();

		$this->start_text_styles();
		$this->add_text_style( 'heading', esc_html__( 'Title', 'mandoca-studio' ), '{{WRAPPER}} .featured-title' );
		$this->add_text_style( 'card_title', esc_html__( 'Card title', 'mandoca-studio' ), '{{WRAPPER}} .card-title' );
		$this->end_controls_section();
	}

	/**
	 * Dibuja el widget con template-parts/destacados.php.
	 */
	protected function render() {
		$s     = $this->get_settings_for_display();
		$games = mandoca_get_games();

		if ( ! $games ) {
			$this->editor_notice( esc_html__( 'There are no published games yet. Add them in Dashboard → Games.', 'mandoca-studio' ) );
			return;
		}

		$this->render_part(
			array(
				'section_id' => $s['section_id'],
				'alt'        => 'yes' === $s['alt'],
				'title'      => $s['title'],
				'tab_text'   => $s['tab_text'],
				'card_url'   => $this->url( $s['card_link'] ),
				'speed'      => (int) $s['speed'],
				'games'      => $games,
			)
		);
	}
}
