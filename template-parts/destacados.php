<?php
/**
 * Sección: carrusel de juegos destacados (como "Featured" de Thunderful).
 *
 * Las tarjetas corren sin fin, se detienen con el mouse encima y se pueden
 * arrastrar (animations.js). Al hacer clic se abre ese juego en la vitrina o,
 * si el juego tiene enlace (Games → Link), esa página en otra pestaña.
 * Sin JavaScript o con "reducir movimiento" es una fila que se desliza a mano.
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'destacados').
 */

defined( 'ABSPATH' ) || exit;

$mandoca_games = is_array( $args['games'] ) ? $args['games'] : mandoca_get_games( (int) $args['limit'] );
if ( ! $mandoca_games ) {
	return;
}
?>
<section class="section featured<?php echo $args['alt'] ? ' section-alt' : ''; ?>"<?php echo $args['section_id'] ? ' id="' . esc_attr( $args['section_id'] ) . '"' : ''; ?>>
	<div class="container featured-head">
		<div class="featured-title-wrap">
			<svg class="featured-icon" viewBox="0 0 24 24" width="40" height="40" aria-hidden="true" focusable="false"><path fill="currentColor" d="M7 7h10a5 5 0 0 1 4.9 6l-.8 3.9a2.6 2.6 0 0 1-4.4 1.3L14.2 16H9.8l-2.5 2.2a2.6 2.6 0 0 1-4.4-1.3L2.1 13A5 5 0 0 1 7 7zm0 3v1.5H5.5V13H7v1.5h1.5V13H10v-1.5H8.5V10H7zm9.5 0a1.2 1.2 0 1 0 0 2.4 1.2 1.2 0 0 0 0-2.4zm-2 2.6a1.2 1.2 0 1 0 0 2.4 1.2 1.2 0 0 0 0-2.4z"/></svg>
			<h2 class="featured-title"><?php echo esc_html( $args['title'] ); ?></h2>
		</div>
	</div>

	<div class="carousel" data-loop data-speed="<?php echo esc_attr( (int) $args['speed'] ); ?>" data-pause-hover data-draggable>
		<div class="loop-track">
			<div class="loop-set">
				<?php foreach ( $mandoca_games as $mandoca_game ) : ?>
					<?php
					$mandoca_has_img = ! empty( $mandoca_game['image_id'] ) || ! empty( $mandoca_game['image_url'] );
					// Si el juego tiene enlace (itch.io, Steam…), la tarjeta lo abre en otra pestaña.
					$mandoca_link = ! empty( $mandoca_game['link'] );
					?>
					<a class="card" href="<?php echo esc_url( $mandoca_link ? $mandoca_game['link'] : mandoca_section_url( $args['card_url'] ) ); ?>"<?php echo $mandoca_link ? ' target="_blank" rel="noopener"' : ''; ?> data-game="<?php echo esc_attr( $mandoca_game['slug'] ); ?>" draggable="false">
						<div class="card-art<?php echo $mandoca_has_img ? ' fit-' . esc_attr( $mandoca_game['fit'] ) : ' is-placeholder'; ?>" aria-hidden="true">
							<?php mandoca_game_image( $mandoca_game, 'card-img' ); ?>
						</div>
						<div class="card-info">
							<?php if ( $mandoca_game['status'] ) : ?>
								<span class="badge" data-badge><?php echo esc_html( $mandoca_game['status'] ); ?></span>
							<?php endif; ?>
							<h3 class="card-title"><?php echo esc_html( $mandoca_game['title'] ); ?></h3>
							<?php if ( mandoca_game_meta( $mandoca_game, ' / ' ) ) : ?>
								<p class="card-meta"><?php echo esc_html( mandoca_game_meta( $mandoca_game, ' / ' ) ); ?></p>
							<?php endif; ?>
						</div>
						<span class="card-tab"><?php echo esc_html( $args['tab_text'] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
