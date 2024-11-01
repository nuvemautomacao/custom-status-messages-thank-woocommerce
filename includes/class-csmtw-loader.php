<?php
/**
 * Plugin loader class
 *
 * @package Custom Status Messages Thank WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

class CSMTW_Loader {
    /**
     * Check if WooCommerce is active
     *
     * @return bool
     */
    public static function is_woocommerce_active() {
        return in_array(
            'woocommerce/woocommerce.php',
            apply_filters('active_plugins', get_option('active_plugins'))
        );
    }

    /**
     * Check plugin dependencies
     *
     * @return bool
     */
    public static function check_dependencies() {
        if (!self::is_woocommerce_active()) {
            add_action('admin_notices', array(__CLASS__, 'woocommerce_missing_notice'));
            return false;
        }
        return true;
    }

    /**
     * Display WooCommerce missing notice
     */
    public static function woocommerce_missing_notice() {
        ?>
        <div class="error">
            <p><?php _e('Custom Status Messages Thank WooCommerce requires WooCommerce to be installed and active.', 'custom-status-messages-thank-woocommerce'); ?></p>
        </div>
        <?php
    }
}