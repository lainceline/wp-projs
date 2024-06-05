<?php
class Cart {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'wp_ajax_add_to_cart', array( $this, 'add_to_cart' ) );
        add_action( 'wp_ajax_nopriv_add_to_cart', array( $this, 'add_to_cart' ) );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( 'cart-scripts', plugins_url( '../js/scripts.js', __FILE__ ), array( 'jquery' ), null, true );
        wp_localize_script( 'cart-scripts', 'ajax_object', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        ));
    }

    public function add_to_cart() {
        $product_id = intval( $_POST['product_id'] );
        $quantity = intval( $_POST['quantity'] );

        $cart = isset( $_SESSION['cart'] ) ? $_SESSION['cart'] : array();
        if ( isset( $cart[ $product_id ] ) ) {
            $cart[ $product_id ] += $quantity;
        } else {
            $cart[ $product_id ] = $quantity;
        }

        $_SESSION['cart'] = $cart;
        wp_send_json_success( array( 'cart' => $cart ) );
    }
}
