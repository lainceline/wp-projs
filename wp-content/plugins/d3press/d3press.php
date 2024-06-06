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
new ADV_Settings();
