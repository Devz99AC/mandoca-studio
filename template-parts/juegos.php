<?php
/**
 * Sección: juegos en desarrollo (un bloque grande por juego).
 *
 * Los juegos salen del panel (Games). Si un juego no tiene imagen destacada se
 * muestra el arte provisional hecho con CSS.
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'juegos').
 */

defined( 'ABSPATH' ) || exit;

$mandoca_games = is_array( $args['games'] ) ? $args['games'] : mandoca_get_games( (int) $args['limit'] );
?>
<section class="section<?php echo $args['alt'] ? ' section-alt' : ''; ?>"<?php echo $args['section_id'] ? ' id="' . esc_attr( $args['section_id'] ) . '"' : ''; ?>>
	<div class="container">
		<?php if ( $args['eyebrow'] || $args['title'] ) : ?>
			<header class="section-head reveal">
				<?php if ( $args['eyebrow'] ) : ?>
					<p class="eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></p>
				<?php endif; ?>
				<?php if ( $args['title'] ) : ?>
					<h2><?php echo mandoca_highlight( $args['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_highlight(). ?></h2>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<?php foreach ( $mandoca_games as $mandoca_i => $mandoca_game ) : ?>
			<?php
			$mandoca_reverse = $args['zigzag'] && 1 === $mandoca_i % 2;
			$mandoca_has_img = ! empty( $mandoca_game['image_id'] ) || ! empty( $mandoca_game['image_url'] );
			$mandoca_art     = 'game-art art-' . sanitize_html_class( $mandoca_game['slug'] );
			$mandoca_art    .= $mandoca_has_img ? ' has-image fit-' . $mandoca_game['fit'] : ' is-placeholder';
			$mandoca_meta    = implode( ' · ', array_filter( array( $mandoca_game['genre'], $mandoca_game['year'] ) ) );
			?>
			<article class="game<?php echo $mandoca_reverse ? ' game-reverse' : ''; ?> reveal">
				<div class="<?php echo esc_attr( $mandoca_art ); ?>" role="img" aria-label="<?php echo esc_attr( 'Arte de ' . $mandoca_game['title'] ); ?>">
					<?php
					if ( ! empty( $mandoca_game['image_id'] ) ) {
						echo wp_get_attachment_image(
							$mandoca_game['image_id'],
							'contain' === $mandoca_game['fit'] ? 'large' : 'mandoca-game',
							false,
							array(
								'class'   => 'game-img',
								'alt'     => '',
								'loading' => 'lazy',
							)
						);
					} elseif ( ! empty( $mandoca_game['image_url'] ) ) {
						printf( '<img class="game-img" src="%s" alt="" loading="lazy">', esc_url( $mandoca_game['image_url'] ) );
					} else {
						echo '<span class="mask" aria-hidden="true"></span>';
					}
					?>
					<span class="art-title"><?php echo esc_html( $mandoca_game['title'] ); ?></span>
				</div>

				<div class="game-info">
					<?php if ( $mandoca_game['status'] || $mandoca_meta ) : ?>
						<p class="game-meta">
							<?php if ( $mandoca_game['status'] ) : ?>
								<span class="tag"><?php echo esc_html( $mandoca_game['status'] ); ?></span>
							<?php endif; ?>
							<?php echo esc_html( $mandoca_meta ); ?>
						</p>
					<?php endif; ?>
					<h3><?php echo esc_html( $mandoca_game['title'] ); ?></h3>
					<?php echo wp_kses_post( wpautop( $mandoca_game['content'] ) ); ?>
					<?php if ( ! empty( $mandoca_game['credits'] ) ) : ?>
						<ul class="game-roles">
							<?php foreach ( $mandoca_game['credits'] as $mandoca_credit ) : ?>
								<li><?php echo esc_html( $mandoca_credit ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>
