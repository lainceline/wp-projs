<?php
/*
Plugin Name: d3press
Description: A plugin to upload data and display it in a chart
Version: 1.0
Author: Sarah Myers
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once plugin_dir_path( __FILE__ ) . 'includes/class-data-upload.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-chart-display.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-settings.php';

// Initialize classes
new Data_Upload();
new Chart_Display();
new Settings();

// Enqueue React scripts
add_action( 'wp_enqueue_scripts', 'adv_dv_enqueue_scripts' );
function adv_dv_enqueue_scripts() {
    wp_enqueue_style( 'adv-dv-style', plugins_url( 'css/style.css', __FILE__ ) );
    wp_enqueue_script( 'react', 'https://unpkg.com/react@17/umd/react.production.min.js', array(), '17', true );
    wp_enqueue_script( 'react-dom', 'https://unpkg.com/react-dom@17/umd/react-dom.production.min.js', array(), '17', true );
    wp_enqueue_script( 'adv-dv-scripts', plugins_url( 'js/scripts.js', __FILE__ ), array( 'react', 'react-dom' ), null, true );
    wp_enqueue_script( 'adv-dv-index', plugins_url( 'js/index.js', __FILE__ ), array( 'adv-dv-scripts' ), null, true );
    wp_localize_script( 'adv-dv-index', 'adv_dv_data', array(
        'csv_data' => get_option( 'adv_dv_csv_data' ),
    ));
}
