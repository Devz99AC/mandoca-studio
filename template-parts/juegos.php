<?php
/**
 * Sección: juegos.
 *
 * Dos diseños (se elige en el widget Mandoca Games):
 * - "showcase": vitrina a todo el ancho, como el hero de Thunderful. Cada
 *   juego es un panel alto; al pasar el mouse se abre y muestra su texto.
 * - "blocks": un bloque grande por juego, con el arte y el texto alternados.
 *
 * Los juegos salen del panel (Games). Si un juego no tiene imagen destacada
 * se muestra un arte provisional hecho con CSS.
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'juegos').
 */

defined( 'ABSPATH' ) || exit;

$mandoca_games  = is_array( $args['games'] ) ? $args['games'] : mandoca_get_games( (int) $args['limit'] );
$mandoca_layout = 'blocks' === $args['layout'] ? 'blocks' : 'showcase';
?>
<section class="section section-games section-games--<?php echo esc_attr( $mandoca_layout ); ?><?php echo $args['alt'] ? ' section-alt' : ''; ?>"<?php echo $args['section_id'] ? ' id="' . esc_attr( $args['section_id'] ) . '"' : ''; ?>>
	<?php if ( $args['eyebrow'] || $args['title'] ) : ?>
		<div class="container">
			<header class="section-head">
				<?php if ( $args['eyebrow'] ) : ?>
					<p class="eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></p>
				<?php endif; ?>
				<?php if ( $args['title'] ) : ?>
					<h2><?php echo mandoca_highlight( $args['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_highlight(). ?></h2>
				<?php endif; ?>
			</header>
		</div>
	<?php endif; ?>

	<?php if ( 'showcase' === $mandoca_layout ) : ?>

		<div class="showcase" data-showcase>
			<?php foreach ( $mandoca_games as $mandoca_i => $mandoca_game ) : ?>
				<?php $mandoca_has_img = ! empty( $mandoca_game['image_id'] ) || ! empty( $mandoca_game['image_url'] ); ?>
				<article class="showcase-item<?php echo 0 === $mandoca_i ? ' is-active' : ''; ?>" tabindex="0" data-game="<?php echo esc_attr( $mandoca_game['slug'] ); ?>" aria-label="<?php echo esc_attr( $mandoca_game['title'] ); ?>">
					<div class="showcase-art<?php echo $mandoca_has_img ? ' fit-' . esc_attr( $mandoca_game['fit'] ) : ' is-placeholder'; ?>" aria-hidden="true">
						<?php mandoca_game_image( $mandoca_game, 'showcase-img' ); ?>
					</div>
					<span class="showcase-tint" aria-hidden="true"></span>

					<div class="showcase-info">
						<?php if ( $mandoca_game['status'] ) : ?>
							<span class="badge" data-badge><?php echo esc_html( $mandoca_game['status'] ); ?></span>
						<?php endif; ?>
						<h3 class="showcase-title"><?php echo esc_html( $mandoca_game['title'] ); ?></h3>
						<p class="showcase-meta"><?php echo esc_html( mandoca_game_meta( $mandoca_game, ' / ' ) ); ?></p>
					</div>

					<div class="showcase-more">
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

	<?php else : ?>

		<div class="container">
			<?php foreach ( $mandoca_games as $mandoca_i => $mandoca_game ) : ?>
				<?php
				$mandoca_reverse = $args['zigzag'] && 1 === $mandoca_i % 2;
				$mandoca_has_img = ! empty( $mandoca_game['image_id'] ) || ! empty( $mandoca_game['image_url'] );
				$mandoca_art     = 'game-art art-' . sanitize_html_class( $mandoca_game['slug'] );
				$mandoca_art    .= $mandoca_has_img ? ' has-image fit-' . $mandoca_game['fit'] : ' is-placeholder';
				?>
				<article class="game<?php echo $mandoca_reverse ? ' game-reverse' : ''; ?>" data-game="<?php echo esc_attr( $mandoca_game['slug'] ); ?>">
					<div class="<?php echo esc_attr( $mandoca_art ); ?>" role="img" aria-label="<?php echo esc_attr( 'Arte de ' . $mandoca_game['title'] ); ?>">
						<?php
						if ( $mandoca_has_img ) {
							mandoca_game_image( $mandoca_game, 'game-img' );
						} else {
							echo '<span class="mask" aria-hidden="true"></span>';
						}
						?>
						<span class="art-title"><?php echo esc_html( $mandoca_game['title'] ); ?></span>
					</div>

					<div class="game-info">
						<p class="game-meta">
							<?php if ( $mandoca_game['status'] ) : ?>
								<span class="tag"><?php echo esc_html( $mandoca_game['status'] ); ?></span>
							<?php endif; ?>
							<?php echo esc_html( mandoca_game_meta( $mandoca_game, ' · ' ) ); ?>
						</p>
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

	<?php endif; ?>
</section>
