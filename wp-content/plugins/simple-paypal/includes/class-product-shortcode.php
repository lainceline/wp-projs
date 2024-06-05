<?php
class Product_Shortcode {
    public function __construct() {
        add_shortcode( 'products', array( $this, 'render_products' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'store-style', plugins_url( '../css/style.css', __FILE__ ) );
        wp_enqueue_script( 'store-scripts', plugins_url( '../js/scripts.js', __FILE__ ), array( 'jquery' ), null, true );
    }

    public function render_products( $atts ) {
        $query_args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        );

        $query = new WP_Query( $query_args );

        ob_start();
        if ( $query->have_posts() ) {
            echo '<div class="products">';
            while ( $query->have_posts() ) {
                $query->the_post();
                $price = get_post_meta( get_the_ID(), 'price', true );
                ?>
                <div class="product" data-id="<?php echo get_the_ID(); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="product-thumbnail">
                            <?php the_post_thumbnail(); ?>
                        </div>
                    <?php endif; ?>
                    <h2 class="product-title"><?php the_title(); ?></h2>
                    <div class="product-price"><?php echo esc_html( $price ); ?></div>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <?php
            }
            echo '</div>';
            wp_reset_postdata();
        }
        return ob_get_clean();
    }
}
