<?php
/**
 * Sección: pie de página con marca, redes y derechos.
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'pie').
 */

defined( 'ABSPATH' ) || exit;
?>
<footer class="site-footer">
	<div class="container footer-inner">
		<?php if ( $args['brand'] ) : ?>
			<p class="footer-brand"><?php echo mandoca_brand_html( $args['brand'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_brand_html(). ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $args['socials'] ) ) : ?>
			<ul class="socials" aria-label="Redes sociales">
				<?php foreach ( $args['socials'] as $mandoca_social ) : ?>
					<?php if ( ! empty( $mandoca_social['text'] ) ) : ?>
						<li><a href="<?php echo esc_url( $mandoca_social['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $mandoca_social['text'] ); ?></a></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( $args['copy'] ) : ?>
			<p class="copy"><?php echo mandoca_with_year( $args['copy'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_with_year(). ?></p>
		<?php endif; ?>
	</div>
</footer>
