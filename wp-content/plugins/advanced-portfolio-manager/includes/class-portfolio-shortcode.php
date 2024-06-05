<?php
class Portfolio_Shortcode {
    public function __construct() {
        add_shortcode( 'portfolio', array( $this, 'render_portfolio' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'portfolio-style', plugins_url( '../css/style.css', __FILE__ ) );
        wp_enqueue_script( 'portfolio-scripts', plugins_url( '../js/scripts.js', __FILE__ ), array('jquery'), null, true );
    }

    public function render_portfolio( $atts ) {
        $atts = shortcode_atts( array(
            'category' => '',
            'tags' => '',
            'orderby' => 'date',
            'order' => 'DESC',
        ), $atts, 'portfolio' );

        $query_args = array(
            'post_type' => 'portfolio',
            'posts_per_page' => -1,
            'orderby' => $atts['orderby'],
            'order' => $atts['order'],
        );

        if ( $atts['category'] ) {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => explode( ',', $atts['category'] ),
                ),
            );
        }

        if ( $atts['tags'] ) {
            $query_args['tag'] = $atts['tags'];
        }

        $query = new WP_Query( $query_args );

        ob_start();
        ?>
        <div class="portfolio-controls">
            <div class="portfolio-filter">
                <button data-filter="*" class="active">Show All</button>
                <button data-filter="category-1">Category 1</button>
                <button data-filter="category-2">Category 2</button>
                <!-- Add more buttons as needed -->
            </div>
            <div class="portfolio-sort">
                <label for="portfolio-sort">Sort By:</label>
                <select id="portfolio-sort">
                    <option value="date">Date</option>
                    <option value="title">Title</option>
                </select>
            </div>
        </div>
        <div class="portfolio-items">
        <?php
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $categories = get_the_terms( get_the_ID(), 'category' );
                $category_classes = '';
                if ( $categories && ! is_wp_error( $categories ) ) {
                    foreach ( $categories as $category ) {
                        $category_classes .= ' category-' . $category->slug;
                    }
                }
                ?>
                <div class="portfolio-item<?php echo $category_classes; ?>" data-date="<?php echo get_the_date( 'Y-m-d' ); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="portfolio-thumbnail">
                            <?php the_post_thumbnail(); ?>
                        </div>
                    <?php endif; ?>
                    <h2 class="portfolio-title"><?php the_title(); ?></h2>
                    <div class="portfolio-content"><?php the_content(); ?></div>
                </div>
                <?php
            }
            wp_reset_postdata();
        }
        ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
