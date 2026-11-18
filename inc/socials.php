<?php
/**
 * Redes sociales.
 *
 * Las direcciones se editan en un solo lugar (Apariencia > Personalizar >
 * Social networks) y se muestran como íconos en el hero, en el menú y en el
 * pie. Un campo vacío oculta esa red.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Redes disponibles: nombre, dirección por defecto e ícono SVG (24×24).
 *
 * @return array
 */
function mandoca_social_networks() {
	return array(
		'instagram' => array(
			'label'   => 'Instagram',
			'default' => 'https://www.instagram.com/mandocastudio/',
			'icon'    => '<rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1.3" fill="currentColor"/>',
		),
		'x'         => array(
			'label'   => 'X',
			'default' => 'https://x.com/mandocastudio',
			'icon'    => '<path fill="currentColor" d="M4 4l6.8 9.1L4.3 20h2.2l5.3-5.7 4.3 5.7H20l-7.1-9.6L19 4h-2.2l-4.9 5.3L8 4H4z"/>',
		),
		'youtube'   => array(
			'label'   => 'YouTube',
			'default' => 'https://www.youtube.com/@MandocaStudio',
			'icon'    => '<path fill="currentColor" fill-rule="evenodd" d="M21.6 7.2a2.5 2.5 0 0 0-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.8 1.8c1.6.4 7.8.4 7.8.4s6.2 0 7.8-.4a2.5 2.5 0 0 0 1.8-1.8A26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8zM10 15.2 15.2 12 10 8.8z"/>',
		),
		'tiktok'    => array(
			'label'   => 'TikTok',
			'default' => '',
			'icon'    => '<path fill="currentColor" d="M16.6 3c.3 2.2 1.6 3.6 3.9 3.8v2.7c-1.4.1-2.6-.3-3.9-1.1v5.1c0 6.4-7 8.4-9.8 3.8-1.8-3-.7-8.2 5.2-8.4v2.9c-.4.1-.9.2-1.3.3-1.3.4-2 1.3-1.8 2.8.4 2.7 5.3 3.5 4.9-1.8V3h2.8z"/>',
		),
		'facebook'  => array(
			'label'   => 'Facebook',
			'default' => '',
			'icon'    => '<path fill="currentColor" d="M14 8h3V4.5h-3c-2.8 0-4.5 1.8-4.5 4.6V11H7v3.5h2.5V21H13v-6.5h3l.5-3.5H13V9.2c0-.7.4-1.2 1-1.2z"/>',
		),
		'discord'   => array(
			'label'   => 'Discord',
			'default' => '',
			'icon'    => '<path fill="currentColor" d="M19.3 5.3A16.5 16.5 0 0 0 15.2 4l-.5 1a15 15 0 0 0-5.4 0L8.8 4a16.5 16.5 0 0 0-4.1 1.3C2.1 9.2 1.4 13 1.8 16.7A16.6 16.6 0 0 0 6.8 19l1-1.6a10.7 10.7 0 0 1-1.6-.8l.4-.3a11.8 11.8 0 0 0 10.8 0l.4.3a10.7 10.7 0 0 1-1.6.8l1 1.6a16.6 16.6 0 0 0 5-2.3c.5-4.3-.7-8-2.9-11.4zM8.7 14.5c-1 0-1.8-.9-1.8-2s.8-2 1.8-2 1.8.9 1.8 2-.8 2-1.8 2zm6.6 0c-1 0-1.8-.9-1.8-2s.8-2 1.8-2 1.8.9 1.8 2-.8 2-1.8 2z"/>',
		),
		'twitch'    => array(
			'label'   => 'Twitch',
			'default' => '',
			'icon'    => '<path fill="currentColor" d="M4 3 3 6v13h4v2h2.5l2-2H15l5-5V3H4zm14 10-3 3h-3.5l-2 2v-2H6V5h12v8zm-3-6h-2v5h2V7zm-4.5 0h-2v5h2V7z"/>',
		),
	);
}

/**
 * Redes con dirección (las que se muestran en el sitio).
 *
 * @return array Lista de redes: slug, label, url.
 */
function mandoca_get_socials() {
	$socials = array();
	foreach ( mandoca_social_networks() as $slug => $network ) {
		$url = get_theme_mod( 'mandoca_social_' . $slug, $network['default'] );
		if ( $url ) {
			$socials[] = array(
				'slug'  => $slug,
				'label' => $network['label'],
				'url'   => $url,
			);
		}
	}
	return $socials;
}

/**
 * Imprime la lista de redes como íconos.
 *
 * @param string $class       Clase extra para ubicarla (hero-socials, menu-socials, footer-socials).
 * @param bool   $show_labels true para mostrar el nombre junto al ícono.
 */
function mandoca_render_socials( $class, $show_labels = false ) {
	$socials  = mandoca_get_socials();
	$networks = mandoca_social_networks();
	if ( ! $socials ) {
		return;
	}
	$svg_tags = array(
		'path'   => array(
			'd'         => true,
			'fill'      => true,
			'fill-rule' => true,
		),
		'rect'   => array(
			'x'            => true,
			'y'            => true,
			'width'        => true,
			'height'       => true,
			'rx'           => true,
			'fill'         => true,
			'stroke'       => true,
			'stroke-width' => true,
		),
		'circle' => array(
			'cx'           => true,
			'cy'           => true,
			'r'            => true,
			'fill'         => true,
			'stroke'       => true,
			'stroke-width' => true,
		),
	);
	?>
	<ul class="socials <?php echo esc_attr( $class ); ?>" aria-label="Redes sociales">
		<?php foreach ( $socials as $social ) : ?>
			<li>
				<a href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
					<svg class="icon" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" focusable="false"><?php echo wp_kses( $networks[ $social['slug'] ]['icon'], $svg_tags ); ?></svg>
					<?php if ( $show_labels ) : ?>
						<span class="socials-label"><?php echo esc_html( $social['label'] ); ?></span>
					<?php endif; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php
}

/**
 * Sección "Social networks" en Apariencia > Personalizar.
 *
 * @param WP_Customize_Manager $wp_customize Personalizador.
 */
function mandoca_customize_socials( $wp_customize ) {
	$wp_customize->add_section(
		'mandoca_socials',
		array(
			'title'       => __( 'Social networks', 'mandoca-studio' ),
			'description' => __( 'Shown as icons in the hero, the menu and the footer. Leave a field empty to hide that network.', 'mandoca-studio' ),
			'priority'    => 30,
		)
	);

	foreach ( mandoca_social_networks() as $slug => $network ) {
		$wp_customize->add_setting(
			'mandoca_social_' . $slug,
			array(
				'default'           => $network['default'],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'mandoca_social_' . $slug,
			array(
				'label'   => $network['label'],
				'section' => 'mandoca_socials',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'mandoca_customize_socials' );
