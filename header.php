<?php
/**
 * Cabecera del sitio: <head>, apertura de <body> y la barra de navegación.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#contenido">Saltar al contenido</a>

<?php
// Cabecera: primero la plantilla "Header" de Elementor; si no existe, la del tema.
if ( ! mandoca_is_elementor_template_view() && ! mandoca_render_elementor_template( 'header' ) ) {
	mandoca_render_part( 'cabecera' );
}
?>

<main id="contenido" class="site-main">
