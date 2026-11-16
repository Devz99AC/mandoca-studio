<?php
/**
 * Pie del sitio: cierre de <main>, pie de página y cierre de <body>.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;
?>
</main>

<?php
// Pie: primero la plantilla "Footer" de Elementor; si no existe, el del tema.
if ( ! mandoca_is_elementor_template_view() && ! mandoca_render_elementor_template( 'footer' ) ) {
	mandoca_render_part( 'pie' );
}
?>

<?php wp_footer(); ?>
</body>
</html>
