<?php
/**
 * Sección: estudio (quiénes somos en una frase y cifras).
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'estudio').
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section<?php echo $args['alt'] ? ' section-alt' : ''; ?>"<?php echo $args['section_id'] ? ' id="' . esc_attr( $args['section_id'] ) . '"' : ''; ?>>
	<div class="container studio">
		<div class="section-head">
			<?php if ( $args['eyebrow'] ) : ?>
				<p class="eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></p>
			<?php endif; ?>
			<?php if ( $args['title'] ) : ?>
				<h2><?php echo mandoca_highlight( $args['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_highlight(). ?></h2>
			<?php endif; ?>
		</div>

		<div class="studio-text">
			<?php echo wp_kses_post( wpautop( $args['text'] ) ); ?>

			<?php if ( ! empty( $args['stats'] ) ) : ?>
				<dl class="stats">
					<?php foreach ( $args['stats'] as $mandoca_stat ) : ?>
						<div>
							<dt<?php echo is_numeric( $mandoca_stat['number'] ) ? ' data-count="' . esc_attr( $mandoca_stat['number'] ) . '"' : ''; ?>><?php echo esc_html( $mandoca_stat['number'] ); ?></dt>
							<dd><?php echo esc_html( $mandoca_stat['label'] ); ?></dd>
						</div>
					<?php endforeach; ?>
				</dl>
			<?php endif; ?>
		</div>
	</div>
</section>
