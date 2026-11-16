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

		<?php
		if ( ! empty( $args['show_socials'] ) ) {
			mandoca_render_socials( 'footer-socials', true );
		}
		?>

		<?php if ( $args['copy'] ) : ?>
			<p class="copy"><?php echo mandoca_with_year( $args['copy'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_with_year(). ?></p>
		<?php endif; ?>
	</div>
</footer>
