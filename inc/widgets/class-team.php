<?php
/**
 * Widget "Mandoca Team": tarjetas del equipo con filtro por área.
 *
 * El diseño se edita aquí; los integrantes (alias, foto, rol, área) se editan
 * en el panel, en "Team".
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;

/**
 * Sección "Equipo".
 */
class Mandoca_Team_Widget extends Mandoca_Widget_Base {

	/**
	 * Plantilla que dibuja este widget.
	 *
	 * @var string
	 */
	protected $part = 'equipo';

	/**
	 * Nombre interno.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'mandoca-team';
	}

	/**
	 * Nombre en el panel.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mandoca Team', 'mandoca-studio' );
	}

	/**
	 * Ícono en el panel.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-person';
	}

	/**
	 * Lee el equipo del panel: Elementor no debe guardar una copia vieja.
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
		$this->add_content_note( esc_html__( 'Members (alias, photo, role, quote, favorite games, area) are edited in Dashboard → Team. Use the "Order" field to sort them.', 'mandoca-studio' ), 'miembro' );
		$this->add_section_fields();
		$this->add_text( 'eyebrow', esc_html__( 'Eyebrow', 'mandoca-studio' ) );
		$this->add_text( 'title', esc_html__( 'Title', 'mandoca-studio' ) );
		$this->add_textarea( 'lead', esc_html__( 'Intro text', 'mandoca-studio' ) );
		$this->add_switch( 'show_filters', esc_html__( 'Show area filter', 'mandoca-studio' ) );
		$this->add_text(
			'all_label',
			esc_html__( '"All" button text', 'mandoca-studio' ),
			array( 'condition' => array( 'show_filters' => 'yes' ) )
		);
		$this->add_text( 'favorites_label', esc_html__( '"Favorite games" label', 'mandoca-studio' ) );
		$this->add_text( 'playing_label', esc_html__( '"Currently playing" label', 'mandoca-studio' ) );
		$this->add_responsive_control(
			'columns',
			array(
				'label'       => esc_html__( 'Columns', 'mandoca-studio' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''  => esc_html__( 'Default', 'mandoca-studio' ),
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'description' => esc_html__( 'Default: 3 on desktop, 2 on tablet, 1 on mobile.', 'mandoca-studio' ),
				'selectors'   => array( '{{WRAPPER}} .team' => 'grid-template-columns: repeat({{VALUE}}, 1fr);' ),
			)
		);
		$this->end_controls_section();

		$this->add_section_style();

		$this->start_text_styles();
		$this->add_text_style( 'eyebrow', esc_html__( 'Eyebrow', 'mandoca-studio' ), '{{WRAPPER}} .eyebrow' );
		$this->add_text_style( 'heading', esc_html__( 'Title', 'mandoca-studio' ), '{{WRAPPER}} .section-head h2' );
		$this->add_text_style( 'lead', esc_html__( 'Intro text', 'mandoca-studio' ), '{{WRAPPER}} .section-lead' );
		$this->add_text_style( 'name', esc_html__( 'Member alias', 'mandoca-studio' ), '{{WRAPPER}} .member h3' );
		$this->add_text_style( 'role', esc_html__( 'Member role', 'mandoca-studio' ), '{{WRAPPER}} .member-role' );
		$this->add_text_style( 'quote', esc_html__( 'Member quote', 'mandoca-studio' ), '{{WRAPPER}} .member-quote p' );
		$this->add_text_style( 'facts', esc_html__( 'Favorite games / playing', 'mandoca-studio' ), '{{WRAPPER}} .member-facts dd' );
		$this->add_text_style( 'bio', esc_html__( 'Member description', 'mandoca-studio' ), '{{WRAPPER}} .member-bio p' );
		$this->end_controls_section();

		$this->start_controls_section(
			'style_cards',
			array(
				'label' => esc_html__( 'Cards & filter', 'mandoca-studio' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'card_bg',
			array(
				'label'     => esc_html__( 'Card background', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .member' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'card_border',
			array(
				'label'     => esc_html__( 'Card border', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .member' => 'border-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'filter_active_bg',
			array(
				'label'     => esc_html__( 'Active filter background', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .filter.is-active' => 'background-color: {{VALUE}}; border-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'filter_active_color',
			array(
				'label'     => esc_html__( 'Active filter text', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .filter.is-active' => 'color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Dibuja el widget con template-parts/equipo.php.
	 */
	protected function render() {
		$s       = $this->get_settings_for_display();
		$members = mandoca_get_members();

		if ( ! $members ) {
			$this->editor_notice( esc_html__( 'There are no published members yet. Add them in Dashboard → Team.', 'mandoca-studio' ) );
		}

		$this->render_part(
			array(
				'section_id'      => $s['section_id'],
				'alt'             => 'yes' === $s['alt'],
				'eyebrow'         => $s['eyebrow'],
				'title'           => $s['title'],
				'lead'            => $s['lead'],
				'show_filters'    => 'yes' === $s['show_filters'],
				'all_label'       => $s['all_label'],
				'favorites_label' => $s['favorites_label'],
				'playing_label'   => $s['playing_label'],
				'members'         => $members,
			)
		);
	}
}
