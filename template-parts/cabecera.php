<?php
/**
 * Sección: cabecera (barra lateral o barra superior) y menú a pantalla completa.
 *
 * - "sidebar": barra vertical a la izquierda en escritorio, como Thunderful.
 * - "top": barra horizontal arriba.
 * En celular las dos se ven como barra superior con botón de menú.
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'cabecera').
 */

defined( 'ABSPATH' ) || exit;

$mandoca_layout = 'top' === $args['layout'] ? 'top' : 'sidebar';
$mandoca_logo   = $args['logo_url'] ? $args['logo_url'] : mandoca_logo_url();
$mandoca_home   = is_front_page() ? '#inicio' : home_url( '/' );
$mandoca_label  = trim( str_replace( '.', ' ', $args['brand'] ) ) . ', ir al inicio';
$mandoca_links  = array_values(
	array_filter(
		(array) $args['links'],
		function ( $link ) {
			return ! empty( $link['text'] );
		}
	)
);
?>
<header class="site-header site-header--<?php echo esc_attr( $mandoca_layout ); ?>" data-header>
	<div class="header-inner">
		<a href="<?php echo esc_url( $mandoca_home ); ?>" class="brand" aria-label="<?php echo esc_attr( $mandoca_label ); ?>">
			<?php if ( $mandoca_logo ) : ?>
				<img src="<?php echo esc_url( $mandoca_logo ); ?>" alt="" class="brand-logo" width="40" height="40">
			<?php endif; ?>
			<span class="brand-name"><?php echo mandoca_brand_html( $args['brand'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_brand_html(). ?></span>
		</a>

		<nav class="nav" id="menu" aria-label="Principal">
			<?php foreach ( $mandoca_links as $mandoca_link ) : ?>
				<a href="<?php echo esc_url( mandoca_section_url( $mandoca_link['url'] ) ); ?>"<?php echo ! empty( $mandoca_link['external'] ) ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $mandoca_link['text'] ); ?></a>
			<?php endforeach; ?>
			<?php if ( $args['cta_text'] ) : ?>
				<a href="<?php echo esc_url( mandoca_section_url( $args['cta_url'] ) ); ?>" class="nav-cta"><?php echo esc_html( $args['cta_text'] ); ?></a>
			<?php endif; ?>
		</nav>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="menu-panel" aria-label="Abrir menú" data-label-open="Abrir menú" data-label-close="Cerrar menú">
			<span></span><span></span><span></span>
		</button>
	</div>
</header>

<div class="menu-panel" id="menu-panel" data-menu-panel>
	<div class="menu-panel-inner">
		<nav class="menu-panel-nav" aria-label="Menú">
			<?php foreach ( $mandoca_links as $mandoca_i => $mandoca_link ) : ?>
				<a class="menu-panel-link" href="<?php echo esc_url( mandoca_section_url( $mandoca_link['url'] ) ); ?>"<?php echo ! empty( $mandoca_link['external'] ) ? ' target="_blank" rel="noopener"' : ''; ?>>
					<span class="menu-panel-num"><?php echo esc_html( sprintf( '%02d', $mandoca_i + 1 ) ); ?></span>
					<span class="menu-panel-text"><?php echo esc_html( $mandoca_link['text'] ); ?></span>
				</a>
			<?php endforeach; ?>
			<?php if ( $args['cta_text'] ) : ?>
				<a class="menu-panel-link is-cta" href="<?php echo esc_url( mandoca_section_url( $args['cta_url'] ) ); ?>">
					<span class="menu-panel-num"><?php echo esc_html( sprintf( '%02d', count( $mandoca_links ) + 1 ) ); ?></span>
					<span class="menu-panel-text"><?php echo esc_html( $args['cta_text'] ); ?></span>
				</a>
			<?php endif; ?>
		</nav>
		<div class="menu-panel-foot">
			<?php mandoca_render_socials( 'menu-socials' ); ?>
			<p class="menu-panel-brand"><?php echo mandoca_brand_html( $args['brand'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_brand_html(). ?></p>
		</div>
	</div>
</div>
