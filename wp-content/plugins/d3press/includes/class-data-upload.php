<?php
class Data_Upload {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
        add_action( 'admin_post_upload_csv', array( $this, 'handle_file_upload' ) );
    }

    public function add_menu_page() {
        add_menu_page(
            'Data Upload',
            'Data Upload',
            'manage_options',
            'data-upload',
            array( $this, 'render_upload_page' ),
            'dashicons-upload'
        );
    }

    public function render_upload_page() {
        ?>
        <div class="wrap">
            <h1>Upload CSV File</h1>
            <form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="upload_csv">
                <?php wp_nonce_field( 'upload_csv', 'upload_csv_nonce' ); ?>
                <input type="file" name="csv_file" required>
                <input type="submit" value="Upload" class="button button-primary">
            </form>
        </div>
        <?php
    }

    public function handle_file_upload() {
        if ( ! isset( $_POST['upload_csv_nonce'] ) || ! wp_verify_nonce( $_POST['upload_csv_nonce'], 'upload_csv' ) ) {
            wp_die( 'Nonce verification failed' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Insufficient permissions' );
        }

        if ( isset( $_FILES['csv_file'] ) && $_FILES['csv_file']['error'] == 0 ) {
            $uploaded = wp_handle_upload( $_FILES['csv_file'], array( 'test_form' => false ) );
            if ( isset( $uploaded['file'] ) ) {
                $file_content = file_get_contents( $uploaded['file'] );
                $csv_data = array_map( 'str_getcsv', explode( "\n", $file_content ) );
                update_option( 'adv_dv_csv_data', $csv_data );
                wp_redirect( admin_url( 'admin.php?page=data-upload&status=success' ) );
                exit;
            }
        }
        wp_redirect( admin_url( 'admin.php?page=data-upload&status=error' ) );
        exit;
    }
}
