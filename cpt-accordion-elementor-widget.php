<?php
/**
 * Plugin Name:       CPT Accordion Elementor Widget
 * Description:       This plugin allows you to select any url archive as a dynamic tag within the current system, returning its actual value directly to Elementor.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            24hwww
 * Author URI:        https://github.com/24hwww
 * License:           Public domain
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Seguridad
}

// Cargar el widget de Elementor
add_action( 'elementor/widgets/register', function( $widgets_manager ) {
    require_once __DIR__ . '/widgets/cpt-tab.php';
    $widgets_manager->register( new \Elementor_Cpt_Tab() );
});