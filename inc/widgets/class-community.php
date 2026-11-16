<?php
/**
 * Widget "Mandoca Community & Contact": newsletter y correo de contacto.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;

/**
 * Sección "Comunidad / Contacto".
 */
class Mandoca_Community_Widget extends Mandoca_Widget_Base {

	/**
	 * Plantilla que dibuja este widget.
	 *
	 * @var string
	 */
	protected $part = 'contacto';

	/**
	 * Nombre interno.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'mandoca-community';
	}

	/**
	 * Nombre en el panel.
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Mandoca Community & Contact', 'mandoca-studio' );
	}

	/**
	 * Ícono en el panel.
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-mail';
	}

	/**
	 * Campos y estilos del widget.
	 */
	protected function register_controls() {
		$this->start_controls_section( 'content', array( 'label' => esc_html__( 'Newsletter', 'mandoca-studio' ) ) );
		$this->add_section_fields();
		$this->add_text( 'eyebrow', esc_html__( 'Eyebrow', 'mandoca-studio' ) );
		$this->add_text( 'title', esc_html__( 'Title', 'mandoca-studio' ) );
		$this->add_textarea( 'text', esc_html__( 'Text', 'mandoca-studio' ) );
		$this->add_text( 'label', esc_html__( 'Field label', 'mandoca-studio' ) );
		$this->add_text( 'placeholder', esc_html__( 'Field placeholder', 'mandoca-studio' ) );
		$this->add_text( 'button', esc_html__( 'Button text', 'mandoca-studio' ) );
		$this->add_text( 'msg_empty', esc_html__( 'Message: empty email', 'mandoca-studio' ) );
		$this->add_text( 'msg_invalid', esc_html__( 'Message: invalid email', 'mandoca-studio' ) );
		$this->add_text(
			'msg_ok',
			esc_html__( 'Message: success', 'mandoca-studio' ),
			array( 'description' => esc_html__( '{email} is replaced by the address the visitor typed.', 'mandoca-studio' ) )
		);
		$this->end_controls_section();

		$this->start_controls_section( 'contact', array( 'label' => esc_html__( 'Contact', 'mandoca-studio' ) ) );
		$this->add_text( 'contact_eyebrow', esc_html__( 'Eyebrow', 'mandoca-studio' ) );
		$this->add_text( 'contact_title', esc_html__( 'Title', 'mandoca-studio' ) );
		$this->add_textarea( 'contact_text', esc_html__( 'Text', 'mandoca-studio' ) );
		$this->add_text( 'email', esc_html__( 'Email', 'mandoca-studio' ) );
		$this->end_controls_section();

		$this->add_section_style();

		$this->start_text_styles();
		$this->add_text_style( 'eyebrow', esc_html__( 'Eyebrows', 'mandoca-studio' ), '{{WRAPPER}} .eyebrow' );
		$this->add_text_style( 'heading', esc_html__( 'Titles', 'mandoca-studio' ), '{{WRAPPER}} .cta-card h2' );
		$this->add_text_style( 'body', esc_html__( 'Texts', 'mandoca-studio' ), '{{WRAPPER}} .cta-card > p' );
		$this->add_text_style( 'mail', esc_html__( 'Email link', 'mandoca-studio' ), '{{WRAPPER}} .mail-link' );
		$this->end_controls_section();

		$this->start_controls_section(
			'style_cards',
			array(
				'label' => esc_html__( 'Cards & button', 'mandoca-studio' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'card_bg',
			array(
				'label'     => esc_html__( 'Card background', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .cta-card' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_control(
			'button_bg',
			array(
				'label'     => esc_html__( 'Button background', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( '{{WRAPPER}} .btn-primary' => 'background-color: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Dibuja el widget con template-parts/contacto.php.
	 */
	protected function render() {
		$s    = $this->get_settings_for_display();
		$keys = array( 'section_id', 'eyebrow', 'title', 'text', 'label', 'placeholder', 'button', 'msg_empty', 'msg_invalid', 'msg_ok', 'contact_eyebrow', 'contact_title', 'contact_text', 'email' );
		$args = array( 'alt' => 'yes' === $s['alt'] );

		foreach ( $keys as $key ) {
			$args[ $key ] = $s[ $key ];
		}

		$this->render_part( $args );
	}
}
