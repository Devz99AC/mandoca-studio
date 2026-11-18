<?php
/**
 * Sección: pie de página con el contacto, la marca, las redes y los derechos.
 *
 * El pie lleva id="contacto": ahí apunta el botón "Contacto" de la cabecera.
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'pie').
 */

defined( 'ABSPATH' ) || exit;
?>
<footer class="site-footer" id="contacto">
	<?php if ( $args['contact_title'] || $args['email'] ) : ?>
		<div class="container footer-contact">
			<div class="footer-contact-text">
				<?php if ( $args['contact_eyebrow'] ) : ?>
					<p class="eyebrow"><?php echo esc_html( $args['contact_eyebrow'] ); ?></p>
				<?php endif; ?>
				<?php if ( $args['contact_title'] ) : ?>
					<h2 class="footer-contact-title"><?php echo esc_html( $args['contact_title'] ); ?></h2>
				<?php endif; ?>
				<?php if ( $args['contact_text'] ) : ?>
					<p class="footer-contact-desc"><?php echo esc_html( $args['contact_text'] ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $args['email'] ) : ?>
				<a class="mail-link" href="<?php echo esc_url( 'mailto:' . $args['email'] ); ?>"><?php echo esc_html( $args['email'] ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

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
