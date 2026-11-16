<?php
/**
 * Sección: círculo con física (como "We are Thunderful").
 *
 * Un anillo de texto que gira y, dentro, piezas que caen y ruedan con física
 * real (Matter.js, en animations.js). Sin JavaScript o con "reducir
 * movimiento" se ve el anillo quieto con el logo en el centro.
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'tumbler').
 */

defined( 'ABSPATH' ) || exit;

$mandoca_path_id = wp_unique_id( 'tumbler-path-' );
$mandoca_piece   = $args['piece_url'] ? $args['piece_url'] : MANDOCA_URI . '/assets/img/logo-mark.png';
?>
<section class="section tumbler<?php echo $args['alt'] ? ' section-alt' : ''; ?>"<?php echo $args['section_id'] ? ' id="' . esc_attr( $args['section_id'] ) . '"' : ''; ?> data-tumbler data-pieces="<?php echo esc_attr( (int) $args['pieces'] ); ?>" data-piece="<?php echo esc_url( $mandoca_piece ); ?>" aria-label="<?php echo esc_attr( $args['ring_text'] ); ?>">
	<div class="tumbler-stage">
		<svg class="tumbler-ring" viewBox="0 0 500 500" aria-hidden="true" focusable="false">
			<defs>
				<path id="<?php echo esc_attr( $mandoca_path_id ); ?>" d="M250,250 m-212,0 a212,212 0 1,1 424,0 a212,212 0 1,1 -424,0"/>
			</defs>
			<text>
				<textPath href="#<?php echo esc_attr( $mandoca_path_id ); ?>" textLength="1325" lengthAdjust="spacing"><?php echo esc_html( $args['ring_text'] ); ?></textPath>
			</text>
		</svg>
		<img class="tumbler-mark" src="<?php echo esc_url( $mandoca_piece ); ?>" alt="" width="256" height="256" loading="lazy">
		<div class="tumbler-canvas" aria-hidden="true"></div>
	</div>
</section>
