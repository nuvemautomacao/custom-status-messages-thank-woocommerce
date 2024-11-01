<?php
/**
 * Admin settings class
 *
 * @package Custom Status Messages Thank WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

class CSMTW_Admin {
    /**
     * Initialize the class
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    /**
     * Add settings page
     */
    public function add_settings_page() {
        add_submenu_page(
            'woocommerce',
            __('Thank You Messages', 'custom-status-messages-thank-woocommerce'),
            __('Thank You Messages', 'custom-status-messages-thank-woocommerce'),
            'manage_woocommerce',
            'custom-status-messages',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting(
            'custom_status_settings_group',
            'custom_status_settings',
            array($this, 'sanitize_settings')
        );
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        include CSMTW_PLUGIN_DIR . 'includes/admin/views/settings-page.php';
    }

    /**
     * Sanitize settings
     *
     * @param array $input
     * @return array
     */
    public function sanitize_settings($input) {
        $sanitized = array();
        
        if (!is_array($input)) {
            return $sanitized;
        }

        foreach ($input as $status => $settings) {
            $sanitized[$status] = array(
                'message' => sanitize_text_field($settings['message']),
                'description' => wp_kses_post($settings['description']),
                'icon_content' => sanitize_text_field($settings['icon_content']),
                'background_color' => sanitize_hex_color($settings['background_color']),
                'text_color' => sanitize_hex_color($settings['text_color']),
                'font_size' => sanitize_text_field($settings['font_size'])
            );
        }

        return $sanitized;
    }
}