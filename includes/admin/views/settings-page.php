<?php
/**
 * Admin settings page template
 *
 * @package Custom Status Messages Thank WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php _e('Custom Thank You Messages Settings', 'custom-status-messages-thank-woocommerce'); ?></h1>
    
    <form method="post" action="options.php">
        <?php
        settings_fields('custom_status_settings_group');
        $settings = get_option('custom_status_settings', array());
        $order_statuses = wc_get_order_statuses();
        ?>

        <table class="form-table">
            <?php foreach ($order_statuses as $status => $label) : 
                $status_key = str_replace('wc-', '', $status);
                $status_settings = isset($settings[$status_key]) ? $settings[$status_key] : array();
            ?>
                <tr>
                    <th scope="row" colspan="2">
                        <h2><?php echo esc_html($label); ?></h2>
                    </th>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Message', 'custom-status-messages-thank-woocommerce'); ?></th>
                    <td>
                        <input type="text" 
                               name="custom_status_settings[<?php echo esc_attr($status_key); ?>][message]" 
                               value="<?php echo esc_attr($status_settings['message'] ?? ''); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Description', 'custom-status-messages-thank-woocommerce'); ?></th>
                    <td>
                        <?php
                        wp_editor(
                            $status_settings['description'] ?? '',
                            'description_' . $status_key,
                            array(
                                'textarea_name' => "custom_status_settings[{$status_key}][description]",
                                'textarea_rows' => 5,
                                'media_buttons' => false,
                                'teeny' => true
                            )
                        );
                        ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Icon Class', 'custom-status-messages-thank-woocommerce'); ?></th>
                    <td>
                        <input type="text" 
                               name="custom_status_settings[<?php echo esc_attr($status_key); ?>][icon_content]" 
                               value="<?php echo esc_attr($status_settings['icon_content'] ?? ''); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Colors', 'custom-status-messages-thank-woocommerce'); ?></th>
                    <td>
                        <label><?php _e('Background:', 'custom-status-messages-thank-woocommerce'); ?></label>
                        <input type="color" 
                               name="custom_status_settings[<?php echo esc_attr($status_key); ?>][background_color]" 
                               value="<?php echo esc_attr($status_settings['background_color'] ?? '#ffffff'); ?>">
                        
                        <label><?php _e('Text:', 'custom-status-messages-thank-woocommerce'); ?></label>
                        <input type="color" 
                               name="custom_status_settings[<?php echo esc_attr($status_key); ?>][text_color]" 
                               value="<?php echo esc_attr($status_settings['text_color'] ?? '#000000'); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Font Size', 'custom-status-messages-thank-woocommerce'); ?></th>
                    <td>
                        <input type="text" 
                               name="custom_status_settings[<?php echo esc_attr($status_key); ?>][font_size]" 
                               value="<?php echo esc_attr($status_settings['font_size'] ?? '16px'); ?>" 
                               class="small-text">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php submit_button(); ?>
    </form>
</div>