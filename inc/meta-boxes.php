<?php
/**
 * Meta boxes: campos personalizados de cada tipo de contenido.
 *
 * Un meta box es una caja extra en la pantalla de edición con campos propios
 * (por ejemplo, el "rol" de un integrante). Los valores se guardan como
 * metadatos de la entrada, con la clave "_mandoca_<campo>".
 *
 * Todos los campos se definen en mandoca_meta_fields(); el resto del archivo
 * los dibuja y los guarda de forma segura (nonce + permisos + sanitizado).
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Campos de cada tipo de contenido.
 *
 * @return array tipo de contenido => [ campo => configuración ].
 */
function mandoca_meta_fields() {
	return array(
		'miembro' => array(
			'title'  => __( 'Member details', 'mandoca-studio' ),
			'fields' => array(
				'rol'       => array(
					'label'       => __( 'Role', 'mandoca-studio' ),
					'type'        => 'text',
					'placeholder' => 'Compositor y diseñador de sonido',
					'description' => __( 'Shown in orange under the alias. Choose the area for the filter in the "Areas" box.', 'mandoca-studio' ),
				),
				'cita'      => array(
					'label'       => __( 'Quote', 'mandoca-studio' ),
					'type'        => 'textarea',
					'placeholder' => 'I am here to Even the Odds.',
					'description' => __( 'Favorite quote, without quotation marks (the theme adds them).', 'mandoca-studio' ),
				),
				'fuente'    => array(
					'label'       => __( 'Quote source', 'mandoca-studio' ),
					'type'        => 'text',
					'placeholder' => 'Final Fantasy XVI',
					'description' => __( 'Where the quote comes from. Leave empty if it is the member\'s own.', 'mandoca-studio' ),
				),
				'favoritos' => array(
					'label'       => __( 'Favorite games', 'mandoca-studio' ),
					'type'        => 'text',
					'placeholder' => 'The Witcher 3, Metaphor: ReFantazio',
				),
				'jugando'   => array(
					'label'       => __( 'Currently playing', 'mandoca-studio' ),
					'type'        => 'text',
					'placeholder' => 'Xenoblade Chronicles 3',
				),
			),
		),
		'juego'   => array(
			'title'  => __( 'Game details', 'mandoca-studio' ),
			'fields' => array(
				'estado'  => array(
					'label'       => __( 'Status', 'mandoca-studio' ),
					'type'        => 'text',
					'placeholder' => 'En desarrollo',
					'description' => __( 'Shown as a tag, e.g. "En desarrollo" or "Prototipo".', 'mandoca-studio' ),
				),
				'genero'  => array(
					'label'       => __( 'Genre', 'mandoca-studio' ),
					'type'        => 'text',
					'placeholder' => 'Acción · Aventura',
				),
				'anio'    => array(
					'label'       => __( 'Year', 'mandoca-studio' ),
					'type'        => 'number',
					'placeholder' => '2026',
				),
				'equipo'  => array(
					'label'       => __( 'Team credits', 'mandoca-studio' ),
					'type'        => 'textarea',
					'placeholder' => "Arte: CrimReaper\nMúsica: JackRevon",
					'description' => __( 'One credit per line. Each line becomes a pill under the description.', 'mandoca-studio' ),
				),
				'ajuste'  => array(
					'label'       => __( 'Image fit', 'mandoca-studio' ),
					'type'        => 'select',
					'options'     => array(
						'cover'   => __( 'Cover — fill the frame (screenshots)', 'mandoca-studio' ),
						'contain' => __( 'Contain — show the whole image (transparent art)', 'mandoca-studio' ),
					),
					'description' => __( 'How the game art fits inside its 16:10 frame.', 'mandoca-studio' ),
				),
			),
		),
	);
}

/**
 * Registra los metadatos para que WordPress sepa su tipo y cómo limpiarlos.
 */
function mandoca_register_meta() {
	foreach ( mandoca_meta_fields() as $post_type => $box ) {
		foreach ( $box['fields'] as $key => $field ) {
			register_post_meta(
				$post_type,
				'_mandoca_' . $key,
				array(
					'type'              => 'string',
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => 'textarea' === $field['type'] ? 'sanitize_textarea_field' : 'sanitize_text_field',
					'auth_callback'     => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}
}
add_action( 'init', 'mandoca_register_meta' );

/**
 * Agrega un meta box a cada tipo de contenido que tenga campos.
 */
function mandoca_add_meta_boxes() {
	foreach ( mandoca_meta_fields() as $post_type => $box ) {
		add_meta_box(
			'mandoca-' . $post_type . '-details',
			$box['title'],
			'mandoca_render_meta_box',
			$post_type,
			'normal',
			'high',
			array( 'post_type' => $post_type )
		);
	}
}
add_action( 'add_meta_boxes', 'mandoca_add_meta_boxes' );

/**
 * Dibuja los campos del meta box.
 *
 * @param WP_Post $post Entrada que se está editando.
 * @param array   $box  Datos del meta box (incluye el tipo de contenido).
 */
function mandoca_render_meta_box( $post, $box ) {
	$fields = mandoca_meta_fields()[ $box['args']['post_type'] ]['fields'];

	// El nonce es un código de un solo uso: prueba que el formulario salió de nuestro panel.
	wp_nonce_field( 'mandoca_save_meta', 'mandoca_meta_nonce' );

	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( $fields as $key => $field ) {
		$id    = 'mandoca-' . $key;
		$name  = 'mandoca_' . $key;
		$value = get_post_meta( $post->ID, '_mandoca_' . $key, true );
		if ( '' === $value && isset( $field['default'] ) ) {
			$value = $field['default'];
		}

		echo '<tr><th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $field['label'] ) . '</label></th><td>';

		switch ( $field['type'] ) {
			case 'textarea':
				printf(
					'<textarea id="%1$s" name="%2$s" class="large-text" rows="4" placeholder="%3$s">%4$s</textarea>',
					esc_attr( $id ),
					esc_attr( $name ),
					esc_attr( isset( $field['placeholder'] ) ? $field['placeholder'] : '' ),
					esc_textarea( $value )
				);
				break;

			case 'select':
				printf( '<select id="%1$s" name="%2$s">', esc_attr( $id ), esc_attr( $name ) );
				foreach ( $field['options'] as $option_value => $option_label ) {
					printf(
						'<option value="%1$s"%2$s>%3$s</option>',
						esc_attr( $option_value ),
						selected( $value, $option_value, false ),
						esc_html( $option_label )
					);
				}
				echo '</select>';
				break;

			default:
				printf(
					'<input type="%1$s" id="%2$s" name="%3$s" class="regular-text" value="%4$s" placeholder="%5$s">',
					esc_attr( 'number' === $field['type'] ? 'number' : 'text' ),
					esc_attr( $id ),
					esc_attr( $name ),
					esc_attr( $value ),
					esc_attr( isset( $field['placeholder'] ) ? $field['placeholder'] : '' )
				);
		}

		if ( ! empty( $field['description'] ) ) {
			echo '<p class="description">' . esc_html( $field['description'] ) . '</p>';
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

/**
 * Guarda los campos al publicar o actualizar.
 *
 * @param int     $post_id ID de la entrada.
 * @param WP_Post $post    Entrada.
 */
function mandoca_save_meta( $post_id, $post ) {
	$all = mandoca_meta_fields();
	if ( ! isset( $all[ $post->post_type ] ) ) {
		return;
	}

	// 1. ¿El formulario trae nuestro nonce y es válido?
	$nonce = isset( $_POST['mandoca_meta_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['mandoca_meta_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'mandoca_save_meta' ) ) {
		return;
	}
	// 2. No guardar en los autoguardados.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// 3. ¿El usuario puede editar esta entrada?
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// 4. Limpiar cada valor según su tipo y guardarlo.
	foreach ( $all[ $post->post_type ]['fields'] as $key => $field ) {
		$name = 'mandoca_' . $key;
		if ( ! isset( $_POST[ $name ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $name ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- se limpia abajo según el tipo.

		switch ( $field['type'] ) {
			case 'textarea':
				$value = sanitize_textarea_field( $raw );
				break;
			case 'number':
				$value = '' === trim( $raw ) ? '' : (string) absint( $raw );
				break;
			case 'select':
				$value = array_key_exists( $raw, $field['options'] ) ? $raw : (string) key( $field['options'] );
				break;
			default:
				$value = sanitize_text_field( $raw );
		}

		update_post_meta( $post_id, '_mandoca_' . $key, $value );
	}
}
add_action( 'save_post', 'mandoca_save_meta', 10, 2 );
