<?php
/**
 * Sección: cinta (marquee) infinita.
 *
 * Las palabras se separan con "·" y se alternan en contorno blanco y relleno
 * naranja. animations.js la hace correr sin fin y la acelera con el scroll.
 *
 * @package Mandoca_Studio
 *
 * @var array $args Datos de la sección (ver inc/defaults.php → 'marquee').
 */

defined( 'ABSPATH' ) || exit;

$mandoca_words = array_values( array_filter( array_map( 'trim', explode( '·', (string) $args['text'] ) ) ) );
if ( ! $mandoca_words ) {
	return;
}
// Con un número impar de palabras se repiten, para que el contorno y el relleno sigan alternándose.
if ( 1 === count( $mandoca_words ) % 2 ) {
	$mandoca_words = array_merge( $mandoca_words, $mandoca_words );
}
?>
<div class="marquee" aria-hidden="true" data-loop data-speed="<?php echo esc_attr( (int) $args['speed'] ); ?>" data-direction="<?php echo esc_attr( 'right' === $args['direction'] ? 'right' : 'left' ); ?>" data-scroll-boost>
	<div class="loop-track">
		<div class="loop-set">
			<?php foreach ( $mandoca_words as $mandoca_i => $mandoca_word ) : ?>
				<span class="marquee-item <?php echo 0 === $mandoca_i % 2 ? 'is-outline' : 'is-fill'; ?>"><?php echo esc_html( $mandoca_word ); ?></span>
				<span class="marquee-sep">·</span>
			<?php endforeach; ?>
		</div>
	</div>
</div>
