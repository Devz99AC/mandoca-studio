<?php
/**
 * Clase base de los widgets "Mandoca" para Elementor.
 *
 * Un widget de Elementor es un bloque que el diseñador arrastra al editor.
 * Cada widget Mandoca:
 *   1. define sus campos (pestaña Content) y estilos (pestaña Style);
 *   2. toma los valores iniciales de inc/defaults.php;
 *   3. dibuja la sección con la misma plantilla de template-parts/ que usa el tema.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 * Funciones comunes a todos los widgets Mandoca.
 */
abstract class Mandoca_Widget_Base extends \Elementor\Widget_Base {

	/**
	 * Plantilla de template-parts/ que dibuja este widget (sin .php).
	 *
	 * @var string
	 */
	protected $part = '';

	/**
	 * Todos los widgets Mandoca van en la categoría "Mandoca Studio".
	 *
	 * @return string[]
	 */
	public function get_categories() {
		return array( 'mandoca' );
	}

	/**
	 * Palabras para encontrar el widget en el buscador del panel.
	 *
	 * @return string[]
	 */
	public function get_keywords() {
		return array( 'mandoca', $this->part );
	}

	/**
	 * Sin envoltorio extra: el HTML queda igual al de la vista previa.
	 *
	 * @return bool
	 */
	public function has_widget_inner_wrapper(): bool {
		return false;
	}

	/**
	 * Valor por defecto de un campo (de inc/defaults.php).
	 *
	 * @param string $key Nombre del campo.
	 * @return mixed
	 */
	protected function default_value( $key ) {
		$defaults = mandoca_defaults( $this->part );
		return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	}

	/**
	 * Campo de texto de una línea con su valor por defecto.
	 *
	 * @param string $key   Nombre del campo.
	 * @param string $label Etiqueta en el panel.
	 * @param array  $extra Opciones extra de Elementor.
	 */
	protected function add_text( $key, $label, $extra = array() ) {
		$this->add_control(
			$key,
			array_merge(
				array(
					'label'       => $label,
					'type'        => Controls_Manager::TEXT,
					'default'     => $this->default_value( $key ),
					'label_block' => true,
				),
				$extra
			)
		);
	}

	/**
	 * Campo de texto de varias líneas con su valor por defecto.
	 *
	 * @param string $key   Nombre del campo.
	 * @param string $label Etiqueta en el panel.
	 * @param array  $extra Opciones extra de Elementor.
	 */
	protected function add_textarea( $key, $label, $extra = array() ) {
		$this->add_control(
			$key,
			array_merge(
				array(
					'label'   => $label,
					'type'    => Controls_Manager::TEXTAREA,
					'rows'    => 3,
					'default' => $this->default_value( $key ),
				),
				$extra
			)
		);
	}

	/**
	 * Campo de enlace con su valor por defecto.
	 *
	 * @param string $key         Nombre del campo.
	 * @param string $label       Etiqueta en el panel.
	 * @param string $default_url Enlace por defecto.
	 */
	protected function add_link( $key, $label, $default_url ) {
		$this->add_control(
			$key,
			array(
				'label'       => $label,
				'type'        => Controls_Manager::URL,
				'default'     => array( 'url' => $default_url ),
				'placeholder' => '#seccion o https://…',
			)
		);
	}

	/**
	 * Interruptor sí/no con su valor por defecto.
	 *
	 * @param string $key   Nombre del campo.
	 * @param string $label Etiqueta en el panel.
	 * @param array  $extra Opciones extra de Elementor (por ejemplo, 'condition').
	 */
	protected function add_switch( $key, $label, $extra = array() ) {
		$this->add_control(
			$key,
			array_merge(
				array(
					'label'        => $label,
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => $this->default_value( $key ) ? 'yes' : '',
				),
				$extra
			)
		);
	}

	/**
	 * Campos comunes de una sección: ID para el menú y fondo alterno.
	 */
	protected function add_section_fields() {
		$this->add_text(
			'section_id',
			esc_html__( 'Section ID', 'mandoca-studio' ),
			array( 'description' => esc_html__( 'Menu links point here with #ID (e.g. #juegos). No spaces.', 'mandoca-studio' ) )
		);
		if ( array_key_exists( 'alt', mandoca_defaults( $this->part ) ) ) {
			$this->add_switch( 'alt', esc_html__( 'Alternate background', 'mandoca-studio' ) );
		}
	}

	/**
	 * Nota con un enlace al panel donde se edita el contenido.
	 *
	 * @param string $text      Texto de la nota.
	 * @param string $post_type Tipo de contenido al que enlaza.
	 */
	protected function add_content_note( $text, $post_type ) {
		$this->add_control(
			'content_note',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf(
					'%s <a href="%s" target="_blank">%s</a>',
					esc_html( $text ),
					esc_url( admin_url( 'edit.php?post_type=' . $post_type ) ),
					esc_html__( 'Open in dashboard', 'mandoca-studio' )
				),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);
	}

	/**
	 * Estilos de la sección: color de fondo y espacio arriba/abajo.
	 *
	 * @param string $selector Elemento de la sección.
	 */
	protected function add_section_style( $selector = '{{WRAPPER}} .section' ) {
		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Section', 'mandoca-studio' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'section_bg',
			array(
				'label'     => esc_html__( 'Background color', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( $selector => 'background-color: {{VALUE}};' ),
			)
		);
		$this->add_responsive_control(
			'section_padding',
			array(
				'label'              => esc_html__( 'Vertical padding', 'mandoca-studio' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => array( 'px', 'rem', 'vh' ),
				'allowed_dimensions' => 'vertical',
				'selectors'          => array( $selector => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}};' ),
			)
		);
		$this->end_controls_section();
	}

	/**
	 * Estilos de un texto: color y tipografía.
	 *
	 * @param string $id         Prefijo de los controles.
	 * @param string $label      Título del grupo en el panel.
	 * @param string $selector   Elemento al que se aplica.
	 * @param bool   $typography ¿Agregar también tipografía?
	 */
	protected function add_text_style( $id, $label, $selector, $typography = true ) {
		$this->add_control(
			$id . '_heading',
			array(
				'label'     => $label,
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			$id . '_color',
			array(
				'label'     => esc_html__( 'Color', 'mandoca-studio' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array( $selector => 'color: {{VALUE}};' ),
			)
		);
		if ( $typography ) {
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $id . '_typography',
					'selector' => $selector,
				)
			);
		}
	}

	/**
	 * Abre la sección de estilos "Texts" (se cierra con end_controls_section()).
	 */
	protected function start_text_styles() {
		$this->start_controls_section(
			'style_texts',
			array(
				'label' => esc_html__( 'Texts', 'mandoca-studio' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
	}

	/**
	 * URL de un campo de enlace de Elementor.
	 *
	 * @param mixed $value Valor del campo.
	 * @return string
	 */
	protected function url( $value ) {
		return is_array( $value ) && isset( $value['url'] ) ? (string) $value['url'] : (string) $value;
	}

	/**
	 * Lista de enlaces de un repetidor de Elementor.
	 *
	 * @param array $items Filas del repetidor (text + link).
	 * @return array
	 */
	protected function links( $items ) {
		$result = array();
		foreach ( (array) $items as $item ) {
			$result[] = array(
				'text'     => isset( $item['text'] ) ? $item['text'] : '',
				'url'      => $this->url( isset( $item['link'] ) ? $item['link'] : '' ),
				'external' => ! empty( $item['link']['is_external'] ),
			);
		}
		return $result;
	}

	/**
	 * Aviso que solo se ve en el editor (por ejemplo, si no hay juegos).
	 *
	 * @param string $message Texto del aviso.
	 */
	protected function editor_notice( $message ) {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			printf( '<div class="container mandoca-editor-notice">%s</div>', esc_html( $message ) );
		}
	}

	/**
	 * Dibuja la sección con la plantilla del tema.
	 *
	 * @param array $args Datos de la sección.
	 */
	protected function render_part( array $args ) {
		mandoca_render_part( $this->part, $args );
	}
}
