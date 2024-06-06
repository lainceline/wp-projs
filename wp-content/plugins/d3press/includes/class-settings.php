<?php
class Settings {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function add_settings_page() {
        add_options_page(
            'Data Visualization Settings',
            'Data Visualization Settings',
            'manage_options',
            'adv-dv-settings',
            array( $this, 'render_settings_page' )
        );
    }

    public function register_settings() {
        register_setting( 'adv_dv_settings', 'adv_dv_settings' );
        add_settings_section( 'adv_dv_settings_section', 'General Settings', null, 'adv-dv-settings' );
        add_settings_field( 'chart_type', 'Default Chart Type', array( $this, 'chart_type_callback' ), 'adv-dv-settings', 'adv_dv_settings_section' );
    }

    public function chart_type_callback() {
        $options = get_option( 'adv_dv_settings' );
        ?>
        <select name="adv_dv_settings[chart_type]">
            <option value="bar" <?php selected( $options['chart_type'], 'bar' ); ?>>Bar</option>
            <option value="line" <?php selected( $options['chart_type'], 'line' ); ?>>Line</option>
            <option value="pie" <?php selected( $options['chart_type'], 'pie' ); ?>>Pie</option>
        </select>
        <?php
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Data Visualization Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'adv_dv_settings' );
                do_settings_sections( 'adv-dv-settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}
