<?php
class Product_Post_Type {
    public function __construct() {
        add_action( 'init', array( $this, 'register_post_type' ) );
    }

    public function register_post_type() {
        $args = array(
            'label' => 'Products',
            'public' => true,
            'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
            'menu_icon' => 'dashicons-cart',
            'has_archive' => true,
        );
        register_post_type( 'product', $args );
    }
}
