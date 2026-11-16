<?php
/**
 * Tipos de contenido propios (Custom Post Types) y taxonomías.
 *
 * Un Custom Post Type es una sección nueva en el panel, como "Entradas" o
 * "Páginas", pero para nuestro propio tipo de contenido. Así cualquiera puede
 * agregar un integrante del equipo sin tocar código.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

/**
 * "Team" en el panel: tipo de contenido "miembro" y taxonomía "area".
 *
 * - Título = alias del integrante.
 * - Contenido = qué hace.
 * - Imagen destacada = foto.
 * - Rol = campo personalizado (meta box en inc/meta-boxes.php).
 * - Área = taxonomía que usa el filtro (Programación, Arte, Audio y narrativa).
 */
function mandoca_register_member_type() {
	register_post_type(
		'miembro',
		array(
			'labels'        => array(
				'name'                  => __( 'Team Members', 'mandoca-studio' ),
				'singular_name'         => __( 'Team Member', 'mandoca-studio' ),
				'menu_name'             => __( 'Team', 'mandoca-studio' ),
				'all_items'             => __( 'All Members', 'mandoca-studio' ),
				'add_new'               => __( 'Add Member', 'mandoca-studio' ),
				'add_new_item'          => __( 'Add New Member', 'mandoca-studio' ),
				'edit_item'             => __( 'Edit Member', 'mandoca-studio' ),
				'new_item'              => __( 'New Member', 'mandoca-studio' ),
				'search_items'          => __( 'Search Members', 'mandoca-studio' ),
				'not_found'             => __( 'No members found.', 'mandoca-studio' ),
				'not_found_in_trash'    => __( 'No members found in Trash.', 'mandoca-studio' ),
				'featured_image'        => __( 'Photo', 'mandoca-studio' ),
				'set_featured_image'    => __( 'Set photo', 'mandoca-studio' ),
				'remove_featured_image' => __( 'Remove photo', 'mandoca-studio' ),
				'use_featured_image'    => __( 'Use as photo', 'mandoca-studio' ),
			),
			'description'   => __( 'People on the Mandoca Studio team.', 'mandoca-studio' ),
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'show_in_rest'  => true,
			'menu_position' => 20,
			'menu_icon'     => 'dashicons-groups',
			'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'has_archive'   => false,
			'rewrite'       => false,
			'query_var'     => false,
		)
	);

	register_taxonomy(
		'area',
		array( 'miembro' ),
		array(
			'labels'            => array(
				'name'          => __( 'Areas', 'mandoca-studio' ),
				'singular_name' => __( 'Area', 'mandoca-studio' ),
				'all_items'     => __( 'All Areas', 'mandoca-studio' ),
				'edit_item'     => __( 'Edit Area', 'mandoca-studio' ),
				'add_new_item'  => __( 'Add New Area', 'mandoca-studio' ),
				'search_items'  => __( 'Search Areas', 'mandoca-studio' ),
				'not_found'     => __( 'No areas found.', 'mandoca-studio' ),
			),
			'description'       => __( 'Used by the team filter on the home page.', 'mandoca-studio' ),
			'hierarchical'      => true, // Casillas de verificación en el panel.
			'public'            => false,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => false,
		)
	);
}
add_action( 'init', 'mandoca_register_member_type' );

/**
 * Nuestros tipos de contenido usan el editor clásico: es más simple para un
 * texto corto y los meta boxes se ven debajo del texto.
 *
 * @param bool   $use_block_editor ¿Usar el editor de bloques?
 * @param string $post_type        Tipo de contenido.
 * @return bool
 */
function mandoca_classic_editor_for_cpt( $use_block_editor, $post_type ) {
	return in_array( $post_type, mandoca_cpt_slugs(), true ) ? false : $use_block_editor;
}
add_filter( 'use_block_editor_for_post_type', 'mandoca_classic_editor_for_cpt', 10, 2 );

/**
 * Lista de nuestros tipos de contenido.
 *
 * @return string[]
 */
function mandoca_cpt_slugs() {
	return array( 'miembro' );
}

/**
 * Texto de ayuda en el campo del título.
 *
 * @param string  $text Texto por defecto.
 * @param WP_Post $post Entrada que se está editando.
 * @return string
 */
function mandoca_title_placeholder( $text, $post ) {
	if ( 'miembro' === $post->post_type ) {
		return __( 'Alias (e.g. JackRevon)', 'mandoca-studio' );
	}
	return $text;
}
add_filter( 'enter_title_here', 'mandoca_title_placeholder', 10, 2 );

/**
 * Columnas de la lista de integrantes: foto y rol.
 *
 * @param array $columns Columnas por defecto.
 * @return array
 */
function mandoca_member_columns( $columns ) {
	$result = array();
	foreach ( $columns as $key => $label ) {
		if ( 'title' === $key ) {
			$result['mandoca_photo'] = __( 'Photo', 'mandoca-studio' );
		}
		$result[ $key ] = $label;
		if ( 'title' === $key ) {
			$result['mandoca_role'] = __( 'Role', 'mandoca-studio' );
		}
	}
	return $result;
}
add_filter( 'manage_miembro_posts_columns', 'mandoca_member_columns' );

/**
 * Contenido de las columnas de foto y rol.
 *
 * @param string $column  Columna.
 * @param int    $post_id ID del integrante.
 */
function mandoca_member_column_content( $column, $post_id ) {
	if ( 'mandoca_photo' === $column ) {
		if ( has_post_thumbnail( $post_id ) ) {
			echo get_the_post_thumbnail( $post_id, array( 48, 48 ) );
		} else {
			echo '<span class="mandoca-initials">' . esc_html( mandoca_initials( get_the_title( $post_id ) ) ) . '</span>';
		}
	}
	if ( 'mandoca_role' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_mandoca_rol', true ) );
	}
}
add_action( 'manage_miembro_posts_custom_column', 'mandoca_member_column_content', 10, 2 );

/**
 * Estilos pequeños para las columnas del panel.
 */
function mandoca_admin_column_styles() {
	wp_add_inline_style(
		'wp-admin',
		'.column-mandoca_photo{width:56px}.column-mandoca_photo img{width:48px;height:48px;object-fit:cover;border-radius:8px}' .
		'.mandoca-initials{display:inline-grid;place-items:center;width:48px;height:48px;border-radius:8px;background:#585858;color:#fff;font-weight:700}'
	);
}
add_action( 'admin_enqueue_scripts', 'mandoca_admin_column_styles' );
