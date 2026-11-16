<?php
/**
 * Sección: cabecera con logo, menú y botón de contacto.
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'cabecera').
 */

defined( 'ABSPATH' ) || exit;

$mandoca_logo  = $args['logo_url'] ? $args['logo_url'] : mandoca_logo_url();
$mandoca_home  = is_front_page() ? '#inicio' : home_url( '/' );
$mandoca_label = trim( str_replace( '.', ' ', $args['brand'] ) ) . ', ir al inicio';
?>
<header class="site-header" data-header>
	<div class="container header-inner">
		<a href="<?php echo esc_url( $mandoca_home ); ?>" class="brand" aria-label="<?php echo esc_attr( $mandoca_label ); ?>">
			<?php if ( $mandoca_logo ) : ?>
				<img src="<?php echo esc_url( $mandoca_logo ); ?>" alt="" class="brand-logo" width="40" height="40">
			<?php endif; ?>
			<span class="brand-name"><?php echo mandoca_brand_html( $args['brand'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_brand_html(). ?></span>
		</a>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="menu" aria-label="Abrir menú" data-label-open="Abrir menú" data-label-close="Cerrar menú">
			<span></span><span></span><span></span>
		</button>

		<nav class="nav" id="menu" aria-label="Principal">
			<?php foreach ( (array) $args['links'] as $mandoca_link ) : ?>
				<?php if ( ! empty( $mandoca_link['text'] ) ) : ?>
					<a href="<?php echo esc_url( mandoca_section_url( $mandoca_link['url'] ) ); ?>"<?php echo ! empty( $mandoca_link['external'] ) ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $mandoca_link['text'] ); ?></a>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php if ( $args['cta_text'] ) : ?>
				<a href="<?php echo esc_url( mandoca_section_url( $args['cta_url'] ) ); ?>" class="nav-cta"><?php echo esc_html( $args['cta_text'] ); ?></a>
			<?php endif; ?>
		</nav>
	</div>
</header>
