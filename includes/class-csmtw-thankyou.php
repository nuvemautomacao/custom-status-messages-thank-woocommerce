<?php
/**
 * Thank you page customization class
 *
 * @package Custom Status Messages Thank WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

class CSMTW_Thankyou {
    /**
     * Initialize the class
     */
    public function __construct() {
        add_action('wp_footer', array($this, 'customize_thankyou_message'));
    }

    /**
     * Get order status settings
     *
     * @param string $status
     * @return array|false
     */
    private function get_status_settings($status) {
        $settings = get_option('custom_status_settings');
        return isset($settings[$status]) ? $settings[$status] : false;
    }

    /**
     * Customize thank you message
     */
    public function customize_thankyou_message() {
        if (!is_wc_endpoint_url('order-received')) {
            return;
        }

        $order_id = absint($GLOBALS['wp']->query_vars['order-received']);
        if (!$order_id) {
            return;
        }

        $order = wc_get_order($order_id);
        if (!$order) {
            return;
        }

        $status = $order->get_status();
        $status_settings = $this->get_status_settings($status);
        
        if (!$status_settings) {
            return;
        }

        $this->enqueue_custom_script($status_settings, $status);
    }

    /**
     * Enqueue custom JavaScript
     *
     * @param array $settings
     * @param string $status
     */
    private function enqueue_custom_script($settings, $status) {
        $script = $this->get_custom_script($settings, $status);
        wc_enqueue_js($script);
    }

    /**
     * Get custom JavaScript
     *
     * @param array $settings
     * @param string $status
     * @return string
     */
    private function get_custom_script($settings, $status) {
        return sprintf(
            'jQuery(document).ready(function($) {
                var statusData = %s;
                var $message = $(".woocommerce-thankyou-order-received");
                
                if (statusData) {
                    var iconContent = $("<i>").addClass("custom-icon").addClass(statusData.icon_content);
                    var messageContent = $("<div>")
                        .append(iconContent)
                        .append("<br><b>" + statusData.message + "</b><br>")
                        .append(statusData.description);

                    $message.html(messageContent);
                    $message.addClass("%s");
                    $message.css({
                        "background-color": statusData.background_color,
                        "color": statusData.text_color,
                        "font-size": statusData.font_size
                    });
                }
            });',
            wp_json_encode($settings),
            esc_attr($status)
        );
    }
}