<?php
/**
 * Asset management class
 *
 * @package Custom Status Messages Thank WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

class CSMTW_Assets {
    /**
     * Initialize the class
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'), 99);
    }

    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets() {
        if (is_wc_endpoint_url('order-received')) {
            wp_enqueue_style(
                'custom-thankyou-styles',
                CSMTW_PLUGIN_URL . 'assets/css/styles.css',
                array(),
                CSMTW_VERSION,
                'all'
            );
        }
    }
}