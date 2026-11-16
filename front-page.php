<?php
/**
 * Portada.
 *
 * - Si la página de inicio está hecha con Elementor (o tiene contenido), se
 *   muestra ese contenido: es lo que edita el diseñador.
 * - Si no, se muestran las secciones del tema con sus textos por defecto.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

get_header();

$mandoca_page_id     = is_page() ? get_queried_object_id() : 0;
$mandoca_use_content = $mandoca_page_id
	&& ( mandoca_is_built_with_elementor( $mandoca_page_id ) || '' !== trim( (string) get_post_field( 'post_content', $mandoca_page_id ) ) );

if ( $mandoca_use_content ) {
	while ( have_posts() ) {
		the_post();
		the_content();
	}
} else {
	foreach ( array( 'hero', 'marquee', 'juegos', 'destacados', 'estudio', 'equipo', 'contacto' ) as $mandoca_section ) {
		mandoca_render_part( $mandoca_section );
	}
}

get_footer();
