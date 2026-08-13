<?php
/**
 * Seed manifest for Pediment Website.
 *
 * Structure lives here; content lives in patterns/. Run `npm run seed:plan`
 * to see what a seed would change before running `npm run seed`.
 *
 * @package pediment-website
 */

return array(
	'version' => 1,
	'pages' => array(
		'home' => array( 'title' => 'Home', 'pattern' => 'pediment-website/home', 'front_page' => true ),
		'about' => array( 'title' => 'About', 'pattern' => 'pediment-website/about' ),
		'features' => array( 'title' => 'Features', 'pattern' => 'pediment-website/features' ),
		'contact' => array( 'title' => 'Contact', 'pattern' => 'pediment-website/contact' ),
	),
	'navs' => array(
		'primary' => array(
			'title' => 'Header Navigation',
			'items' => array(
				array( 'entry' => 'features' ),
				array( 'entry' => 'about' ),
				array( 'entry' => 'contact' ),
			),
		),
	),
);
