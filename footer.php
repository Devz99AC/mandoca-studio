<?php
/**
 * Pie del sitio: cierre de <main>, pie de página y cierre de <body>.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;
?>
</main>

<?php mandoca_render_part( 'pie' ); ?>

<?php wp_footer(); ?>
</body>
</html>
