<?php
class Portfolio_Settings {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function add_settings_page() {
        add_options_page(
            'Portfolio Settings',
            'Portfolio Settings',
            'manage_options',
            'portfolio-settings',
            array( $this, 'render_settings_page' )
        );
    }

    public function register_settings() {
        register_setting( 'portfolio_settings', 'portfolio_settings' );
        add_settings_section( 'portfolio_settings_section', 'General Settings', null, 'portfolio-settings' );
        add_settings_field( 'portfolio_items_per_page', 'Items per Page', array( $this, 'portfolio_items_per_page_callback' ), 'portfolio-settings', 'portfolio_settings_section' );
    }

    public function portfolio_items_per_page_callback() {
        $options = get_option( 'portfolio_settings' );
        ?>
        <input type="number" name="portfolio_settings[portfolio_items_per_page]" value="<?php echo esc_attr( $options['portfolio_items_per_page'] ?? 10 ); ?>" />
        <?php
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Portfolio Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'portfolio_settings' );
                do_settings_sections( 'portfolio-settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}
