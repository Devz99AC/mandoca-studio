<?php
/**
 * Sección: comunidad (newsletter) y contacto.
 *
 * Los mensajes del formulario van en atributos data-* para que main.js los
 * lea igual en WordPress y en la vista previa.
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'contacto').
 */

defined( 'ABSPATH' ) || exit;

$mandoca_input_id = wp_unique_id( 'email-' );
?>
<section class="section<?php echo $args['alt'] ? ' section-alt' : ''; ?>"<?php echo $args['section_id'] ? ' id="' . esc_attr( $args['section_id'] ) . '"' : ''; ?>>
	<div class="container cta-grid">
		<div class="cta-card">
			<?php if ( $args['eyebrow'] ) : ?>
				<p class="eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></p>
			<?php endif; ?>
			<?php if ( $args['title'] ) : ?>
				<h2><?php echo mandoca_highlight( $args['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_highlight(). ?></h2>
			<?php endif; ?>
			<?php if ( $args['text'] ) : ?>
				<p><?php echo esc_html( $args['text'] ); ?></p>
			<?php endif; ?>

			<form class="newsletter" novalidate
				data-msg-empty="<?php echo esc_attr( $args['msg_empty'] ); ?>"
				data-msg-invalid="<?php echo esc_attr( $args['msg_invalid'] ); ?>"
				data-msg-ok="<?php echo esc_attr( $args['msg_ok'] ); ?>">
				<label for="<?php echo esc_attr( $mandoca_input_id ); ?>"><?php echo esc_html( $args['label'] ); ?></label>
				<div class="field-row">
					<input type="email" id="<?php echo esc_attr( $mandoca_input_id ); ?>" name="email" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>" autocomplete="email" required>
					<button type="submit" class="btn btn-primary"><?php echo esc_html( $args['button'] ); ?></button>
				</div>
				<p class="form-msg" role="status" aria-live="polite"></p>
			</form>
		</div>

		<?php if ( $args['contact_title'] || $args['email'] ) : ?>
			<div class="cta-card cta-contact">
				<?php if ( $args['contact_eyebrow'] ) : ?>
					<p class="eyebrow"><?php echo esc_html( $args['contact_eyebrow'] ); ?></p>
				<?php endif; ?>
				<?php if ( $args['contact_title'] ) : ?>
					<h2><?php echo esc_html( $args['contact_title'] ); ?></h2>
				<?php endif; ?>
				<?php if ( $args['contact_text'] ) : ?>
					<p><?php echo esc_html( $args['contact_text'] ); ?></p>
				<?php endif; ?>
				<?php if ( $args['email'] ) : ?>
					<a class="mail-link" href="<?php echo esc_url( 'mailto:' . $args['email'] ); ?>"><?php echo esc_html( $args['email'] ); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
