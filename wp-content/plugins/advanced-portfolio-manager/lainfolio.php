if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-post-type.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-github-api.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-shortcode.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-portfolio-settings.php';

// Initialize classes
new Portfolio_Post_Type();
new GitHub_API();
new Portfolio_Shortcode();
new Portfolio_Settings();