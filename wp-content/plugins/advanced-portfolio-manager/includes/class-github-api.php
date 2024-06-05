<?php
class GitHub_API {
    private $api_url = 'https://api.github.com/users/';
    private $username;
    private $token;

    public function __construct() {
        $this->username = get_option( 'github_username' );
        $this->token = get_option( 'github_token' );
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function fetch_projects() {
        $url = $this->api_url . $this->username . '/repos';
        $response = wp_remote_get( $url, array(
            'headers' => array(
                'Authorization' => 'token ' . $this->token,
                'User-Agent' => 'WordPress/' . get_bloginfo( 'version' ),
            ),
        ) );
        if ( is_wp_error( $response ) ) {
            return [];
        }
        return json_decode( wp_remote_retrieve_body( $response ), true );
    }

    public function add_settings_page() {
        add_options_page(
            'GitHub API Settings',
            'GitHub API Settings',
            'manage_options',
            'github-api-settings',
            array( $this, 'render_settings_page' )
        );
    }

    public function register_settings() {
        register_setting( 'github_api_settings', 'github_username' );
        register_setting( 'github_api_settings', 'github_token' );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>GitHub API Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'github_api_settings' ); ?>
                <?php do_settings_sections( 'github_api_settings' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">GitHub Username</th>
                        <td><input type="text" name="github_username" value="<?php echo esc_attr( get_option( 'github_username' ) ); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">GitHub Token</th>
                        <td><input type="text" name="github_token" value="<?php echo esc_attr( get_option( 'github_token' ) ); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
