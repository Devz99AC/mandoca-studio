<?php
/**
 * Sección: hero (título principal, cita y botones).
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'hero').
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="hero"<?php echo $args['section_id'] ? ' id="' . esc_attr( $args['section_id'] ) . '"' : ''; ?>>
	<?php if ( $args['show_orbs'] ) : ?>
		<div class="hero-bg" aria-hidden="true">
			<span class="orb-layer" data-depth="60"><span class="orb orb-1"></span></span>
			<span class="orb-layer" data-depth="-35"><span class="orb orb-2"></span></span>
			<span class="grain"></span>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $args['show_socials'] ) ) : ?>
		<div class="container hero-top">
			<?php mandoca_render_socials( 'hero-socials' ); ?>
		</div>
	<?php endif; ?>

	<div class="container hero-inner">
		<?php if ( $args['eyebrow'] ) : ?>
			<p class="eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></p>
		<?php endif; ?>

		<h1 class="hero-title"><?php echo mandoca_highlight( $args['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_highlight(). ?></h1>

		<?php if ( $args['quote'] ) : ?>
			<blockquote class="hero-quote">
				<p><?php echo esc_html( $args['quote'] ); ?></p>
				<?php if ( $args['cite'] ) : ?>
					<cite><?php echo esc_html( $args['cite'] ); ?></cite>
				<?php endif; ?>
			</blockquote>
		<?php endif; ?>

		<?php if ( $args['btn1_text'] || $args['btn2_text'] ) : ?>
			<div class="hero-actions">
				<?php if ( $args['btn1_text'] ) : ?>
					<a href="<?php echo esc_url( mandoca_section_url( $args['btn1_url'] ) ); ?>" class="btn btn-primary"><?php echo esc_html( $args['btn1_text'] ); ?></a>
				<?php endif; ?>
				<?php if ( $args['btn2_text'] ) : ?>
					<a href="<?php echo esc_url( mandoca_section_url( $args['btn2_url'] ) ); ?>" class="btn btn-ghost"><?php echo esc_html( $args['btn2_text'] ); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $args['scroll_text'] ) : ?>
		<a href="<?php echo esc_url( mandoca_section_url( $args['scroll_url'] ) ); ?>" class="scroll-hint" aria-label="<?php echo esc_attr( $args['scroll_label'] ); ?>">
			<span><?php echo esc_html( $args['scroll_text'] ); ?></span>
		</a>
	<?php endif; ?>
</section>
