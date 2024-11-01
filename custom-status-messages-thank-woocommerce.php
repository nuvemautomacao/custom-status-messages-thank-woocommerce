<?php
/**
 * Plugin Name: Custom Status Messages Thank WooCommerce
 * Plugin URI: https://nuvemautomacao.com.br/plugins/
 * Description: Customize text, icon, and colors of notification messages for each status on the WooCommerce thank you page.
 * Version: 1.0
 * Author: Nuvem Automação
 * Author URI: https://nuvemautomacao.com.br
 * Text Domain: custom-status-messages-thank-woocommerce
 * Domain Path: /i18n/languages/
 * Requires at least: 6.2
 * Requires PHP: 7.4
 *
 * @package Custom Status Messages Thank WooCommerce
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define('CSMTW_VERSION', '1.0');
define('CSMTW_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CSMTW_PLUGIN_URL', plugin_dir_url(__FILE__));

// Load core plugin files
require_once CSMTW_PLUGIN_DIR . 'includes/class-csmtw-loader.php';
require_once CSMTW_PLUGIN_DIR . 'includes/class-csmtw-assets.php';
require_once CSMTW_PLUGIN_DIR . 'includes/class-csmtw-thankyou.php';
require_once CSMTW_PLUGIN_DIR . 'includes/admin/class-csmtw-admin.php';

// Initialize the plugin
function csmtw_init() {
    // Initialize classes
    new CSMTW_Assets();
    new CSMTW_Thankyou();
    
    if (is_admin()) {
        new CSMTW_Admin();
    }
}
add_action('plugins_loaded', 'csmtw_init');