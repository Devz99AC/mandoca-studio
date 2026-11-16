<?php
/**
 * Plantilla general: páginas, entradas y cualquier otra vista.
 *
 * Las páginas hechas con Elementor ocupan todo el ancho; el resto se muestra
 * dentro de un contenedor con estilos de texto básicos.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		if ( is_singular() && mandoca_is_built_with_elementor( get_the_ID() ) ) {
			the_content();
			continue;
		}
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'container page-content' ); ?>>
			<header class="page-header">
				<?php if ( is_singular() ) : ?>
					<h1><?php the_title(); ?></h1>
				<?php else : ?>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php endif; ?>
			</header>
			<div class="entry-content">
				<?php is_singular() ? the_content() : the_excerpt(); ?>
			</div>
		</article>
		<?php
	}

	the_posts_pagination( array( 'class' => 'container pagination' ) );
} else {
	?>
	<div class="container page-content">
		<h1>No encontramos lo que buscas</h1>
		<p><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Volver al inicio</a></p>
	</div>
	<?php
}

get_footer();
