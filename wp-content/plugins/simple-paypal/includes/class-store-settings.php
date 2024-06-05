<?php
class Store_Settings {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function add_settings_page() {
        add_options_page(
            'Store Settings',
            'Store Settings',
            'manage_options',
            'store-settings',
            array( $this, 'render_settings_page' )
        );
    }

    public function register_settings() {
        register_setting( 'store_settings', 'store_settings' );
        add_settings_section( 'store_settings_section', 'General Settings', null, 'store-settings' );
        add_settings_field( 'store_currency', 'Currency', array( $this, 'store_currency_callback' ), 'store-settings', 'store_settings_section' );
    }

    public function store_currency_callback() {
        $options = get_option( 'store_settings' );
        ?>
        <input type="text" name="store_settings[store_currency]" value="<?php echo esc_attr( $options['store_currency'] ?? 'USD' ); ?>" />
        <?php
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Store Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'store_settings' );
                do_settings_sections( 'store-settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}
