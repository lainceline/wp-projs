<?php
class PayPal_API {
    private $client_id;
    private $client_secret;
    private $api_url = 'https://api.sandbox.paypal.com'; // Change to live URL for production

    public function __construct() {
        $this->client_id = get_option( 'paypal_client_id' );
        $this->client_secret = get_option( 'paypal_client_secret' );
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function create_payment( $amount, $currency, $return_url, $cancel_url ) {
        $url = $this->api_url . '/v1/payments/payment';
        $body = json_encode(array(
            'intent' => 'sale',
            'payer' => array(
                'payment_method' => 'paypal',
            ),
            'transactions' => array(array(
                'amount' => array(
                    'total' => $amount,
                    'currency' => $currency,
                ),
            )),
            'redirect_urls' => array(
                'return_url' => $return_url,
                'cancel_url' => $cancel_url,
            ),
        ));
        $response = wp_remote_post( $url, array(
            'body' => $body,
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode( $this->client_id . ':' . $this->client_secret ),
                'Content-Type' => 'application/json',
            ),
        ));
        return json_decode( wp_remote_retrieve_body( $response ), true );
    }

    public function add_settings_page() {
        add_options_page(
            'PayPal API Settings',
            'PayPal API Settings',
            'manage_options',
            'paypal-api-settings',
            array( $this, 'render_settings_page' )
        );
    }

    public function register_settings() {
        register_setting( 'paypal_api_settings', 'paypal_client_id' );
        register_setting( 'paypal_api_settings', 'paypal_client_secret' );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>PayPal API Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'paypal_api_settings' ); ?>
                <?php do_settings_sections( 'paypal_api_settings' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">PayPal Client ID</th>
                        <td><input type="text" name="paypal_client_id" value="<?php echo esc_attr( get_option( 'paypal_client_id' ) ); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">PayPal Client Secret</th>
                        <td><input type="text" name="paypal_client_secret" value="<?php echo esc_attr( get_option( 'paypal_client_secret' ) ); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
