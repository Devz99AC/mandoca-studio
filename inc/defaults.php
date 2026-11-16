<?php
/**
 * Textos por defecto de cada sección.
 *
 * Son los textos actuales del sitio. Los usan:
 * - los widgets de Elementor como valor inicial de cada campo;
 * - la portada cuando Elementor no está activo (respaldo).
 * Si cambias un texto aquí, cámbialo también en preview/index.html.
 *
 * @package Mandoca_Studio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Devuelve los textos por defecto de una sección.
 *
 * @param string $section Nombre de la sección (igual que el archivo en template-parts/).
 * @return array
 */
function mandoca_defaults( $section ) {
	$defaults = array(
		'site'     => array(
			'meta_description' => 'Mandoca Studio es un estudio independiente formado por amigos que desarrollan juegos creativos e imaginativos.',
		),

		'cabecera' => array(
			'layout'   => 'sidebar', // "sidebar" (barra lateral, como Thunderful) o "top" (barra arriba).
			'logo_url' => '',
			'brand'    => 'Mandoca.Studio',
			'links'    => array(
				array(
					'text' => 'Juegos',
					'url'  => '#juegos',
				),
				array(
					'text' => 'Estudio',
					'url'  => '#estudio',
				),
				array(
					'text' => 'Equipo',
					'url'  => '#equipo',
				),
			),
			'cta_text' => 'Contacto',
			'cta_url'  => '#contacto',
		),

		'hero'     => array(
			'section_id'   => 'inicio',
			'eyebrow'      => 'Estudio independiente de videojuegos',
			'title'        => 'Desarrollamos juegos *creativos* e *imaginativos*.',
			'quote'        => '“La lucha por llegar a la cima basta para llenar el corazón de un hombre. Hay que imaginar a Sísifo feliz.”',
			'cite'         => '— Albert Camus',
			'btn1_text'    => 'Mira lo que estamos haciendo',
			'btn1_url'     => '#juegos',
			'btn2_text'    => 'Conoce al equipo',
			'btn2_url'     => '#equipo',
			'scroll_text'  => 'scroll',
			'scroll_url'   => '#juegos',
			'scroll_label' => 'Bajar a Juegos',
			'show_orbs'    => true,
			'show_socials' => true,
		),

		'marquee'  => array(
			'text'      => 'CREATIVE · IMAGINATIVE · GAMES',
			'speed'     => 90, // Píxeles por segundo.
			'direction' => 'left',
		),

		'juegos'   => array(
			'section_id' => 'juegos',
			'layout'     => 'showcase', // "showcase" (vitrina tipo Thunderful) o "blocks" (zig-zag).
			'alt'        => false,
			'eyebrow'    => '01 — Juegos',
			'title'      => 'En qué estamos trabajando',
			'zigzag'     => true,
			'limit'      => -1,
			'games'      => null, // null = leer los juegos del panel.
		),

		'estudio'  => array(
			'section_id' => 'estudio',
			'alt'        => true,
			'eyebrow'    => '02 — Estudio',
			'title'      => 'Un grupo de amigos haciendo los juegos que nos gustaría jugar',
			'text'       => 'Mandoca Studio nació como un grupo de amigos cercanos. Queremos hacer juegos divertidos que nos representen como personas y que lleven dentro mucho de lo que amamos, para que otros también lo disfruten.',
			'stats'      => array(
				array(
					'number' => '6',
					'label'  => 'integrantes',
				),
				array(
					'number' => '2',
					'label'  => 'proyectos activos',
				),
				array(
					'number' => '2026',
					'label'  => 'año de fundación',
				),
			),
		),

		'equipo'   => array(
			'section_id'   => 'equipo',
			'alt'          => false,
			'eyebrow'      => '03 — Equipo',
			'title'        => 'Quiénes somos',
			'lead'         => 'Seis personas, seis oficios. Filtra por área para ver quién hace qué.',
			'show_filters' => true,
			'all_label'    => 'Todos',
			'filter_label' => 'Filtrar equipo por área',
			'members'      => null, // null = leer los integrantes del panel.
			'areas'        => null,
		),

		'contacto' => array(
			'section_id'      => 'contacto',
			'alt'             => true,
			'eyebrow'         => '04 — Comunidad',
			'title'           => 'Únete a nuestra comunidad',
			'text'            => 'Recibe avances, devlogs y fechas de prueba antes que nadie.',
			'label'           => 'Correo electrónico',
			'placeholder'     => 'tu@correo.com',
			'button'          => 'Suscribirme',
			'msg_empty'       => 'Escribe tu correo para suscribirte.',
			'msg_invalid'     => 'Ese correo no parece válido. Revisa que tenga @ y un dominio.',
			'msg_ok'          => '¡Listo! Te avisaremos en {email}.',
			'contact_eyebrow' => 'Contacto',
			'contact_title'   => '¿Quieres hablar con el equipo?',
			'contact_text'    => 'Para consultas generales, prensa o colaboraciones, escríbenos.',
			'email'           => 'Contact@MandocaStudio.com',
		),

		'pie'      => array(
			'brand'        => 'Mandoca.Studio',
			'show_socials' => true, // Las redes se editan en Apariencia > Personalizar.
			'copy'         => '© {year} Mandoca Studio · Proyecto académico',
		),
	);

	return isset( $defaults[ $section ] ) ? $defaults[ $section ] : array();
}
