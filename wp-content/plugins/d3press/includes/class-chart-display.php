<?php
class Chart_Display {
    public function __construct() {
        add_shortcode( 'adv_chart', array( $this, 'render_chart' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'adv-dv-style', plugins_url( '../css/style.css', __FILE__ ) );
        wp_enqueue_script( 'react', 'https://unpkg.com/react@17/umd/react.production.min.js', array(), null, true );
        wp_enqueue_script( 'react-dom', 'https://unpkg.com/react-dom@17/umd/react-dom.production.min.js', array(), null, true );
        wp_enqueue_script( 'd3-js', 'https://d3js.org/d3.v6.min.js', array(), null, true );
        wp_enqueue_script( 'adv-dv-scripts', plugins_url( '../js/scripts.js', __FILE__ ), array( 'react', 'react-dom', 'd3-js' ), null, true );
        wp_enqueue_script( 'adv-dv-app', plugins_url( '../js/app.jsx', __FILE__ ), array( 'react', 'react-dom', 'd3-js' ), null, true );
        wp_localize_script( 'adv-dv-scripts', 'adv_dv_data', array(
            'csv_data' => get_option( 'adv_dv_csv_data' ),
        ));
    }

    public function render_chart( $atts ) {
        $atts = shortcode_atts( array(
            'type' => 'bar', // default chart type
        ), $atts, 'adv_chart' );

        ob_start();
        ?>
        <div id="chart" data-type="<?php echo esc_attr( $atts['type'] ); ?>"></div>
        <?php
        return ob_get_clean();
    }
}
