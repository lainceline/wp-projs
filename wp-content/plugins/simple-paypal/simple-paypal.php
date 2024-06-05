<?php
/*
Plugin Name: Simple PayPal
Description: A plugin that provides e-commerce functionality with PayPal integration.
Version: 0.9
Author: Sarah Myers
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-post-type.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-paypal-api.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-cart.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-shortcode.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-cart-shortcode.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-store-settings.php';

// Initialize classes
new Product_Post_Type();
new PayPal_API();
new Cart();
new Product_Shortcode();
new Cart_Shortcode();
new Store_Settings();
