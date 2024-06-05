<?php
class Cart_Shortcode {
    public function __construct() {
        add_shortcode( 'cart', array( $this, 'render_cart' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'store-style', plugins_url( '../css/style.css', __FILE__ ) );
        wp_enqueue_script( 'store-scripts', plugins_url( '../js/scripts.js', __FILE__ ), array( 'jquery' ), null, true );
    }

    public function render_cart() {
        ob_start();
        ?>
        <div class="cart">
            <h2>Your Cart</h2>
            <div class="cart-items"></div>
            <button class="checkout">Checkout with PayPal</button>
        </div>
        <?php
        return ob_get_clean();
    }
}
