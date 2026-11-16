<?php
/**
 * Sección: equipo con filtro por área.
 *
 * Los integrantes salen del panel (Team). Si alguien no tiene foto, se
 * muestran sus iniciales.
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'equipo').
 */

defined( 'ABSPATH' ) || exit;

$mandoca_members = is_array( $args['members'] ) ? $args['members'] : mandoca_get_members();
$mandoca_areas   = is_array( $args['areas'] ) ? $args['areas'] : mandoca_get_areas();
?>
<section class="section<?php echo $args['alt'] ? ' section-alt' : ''; ?>"<?php echo $args['section_id'] ? ' id="' . esc_attr( $args['section_id'] ) . '"' : ''; ?> data-team>
	<div class="container">
		<?php if ( $args['eyebrow'] || $args['title'] || $args['lead'] ) : ?>
			<header class="section-head reveal">
				<?php if ( $args['eyebrow'] ) : ?>
					<p class="eyebrow"><?php echo esc_html( $args['eyebrow'] ); ?></p>
				<?php endif; ?>
				<?php if ( $args['title'] ) : ?>
					<h2><?php echo mandoca_highlight( $args['title'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado en mandoca_highlight(). ?></h2>
				<?php endif; ?>
				<?php if ( $args['lead'] ) : ?>
					<p class="section-lead"><?php echo esc_html( $args['lead'] ); ?></p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<?php if ( $args['show_filters'] && count( $mandoca_areas ) > 1 ) : ?>
			<div class="filters reveal" role="group" aria-label="<?php echo esc_attr( $args['filter_label'] ); ?>">
				<button class="filter is-active" type="button" data-filter="todos" aria-pressed="true"><?php echo esc_html( $args['all_label'] ); ?></button>
				<?php foreach ( $mandoca_areas as $mandoca_slug => $mandoca_name ) : ?>
					<button class="filter" type="button" data-filter="<?php echo esc_attr( $mandoca_slug ); ?>" aria-pressed="false"><?php echo esc_html( $mandoca_name ); ?></button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<ul class="team">
			<?php foreach ( $mandoca_members as $mandoca_member ) : ?>
				<?php $mandoca_alt = 'Foto de ' . $mandoca_member['name']; ?>
				<li class="member reveal" data-area="<?php echo esc_attr( $mandoca_member['area'] ); ?>">
					<?php
					if ( ! empty( $mandoca_member['photo_id'] ) ) {
						echo wp_get_attachment_image(
							$mandoca_member['photo_id'],
							'mandoca-member',
							false,
							array(
								'class'   => 'member-photo',
								'alt'     => $mandoca_alt,
								'loading' => 'lazy',
							)
						);
					} elseif ( ! empty( $mandoca_member['photo_url'] ) ) {
						printf(
							'<img class="member-photo" src="%s" alt="%s" loading="lazy" width="400" height="400">',
							esc_url( $mandoca_member['photo_url'] ),
							esc_attr( $mandoca_alt )
						);
					} else {
						printf(
							'<div class="member-initials" role="img" aria-label="%s">%s</div>',
							esc_attr( $mandoca_alt ),
							esc_html( mandoca_initials( $mandoca_member['name'] ) )
						);
					}
					?>
					<h3><?php echo esc_html( $mandoca_member['name'] ); ?></h3>
					<?php if ( $mandoca_member['role'] ) : ?>
						<p class="member-role"><?php echo esc_html( $mandoca_member['role'] ); ?></p>
					<?php endif; ?>
					<div class="member-bio"><?php echo wp_kses_post( wpautop( $mandoca_member['bio'] ) ); ?></div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
