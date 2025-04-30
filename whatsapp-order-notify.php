<?php
/**
 * Plugin Name: WhatsApp Order Notification
 * Plugin URI: https://github.com/mrxadik/WhatsApp-Order-Notification
 * Description: Sends WooCommerce order notifications to WhatsApp via CallMeBot API.
 * Version: 2.9
 * Author: MRXADIK
 * Author URI: https://github.com/mrxadik
 */

if (!defined('ABSPATH')) {
    exit; 
}


register_activation_hook(__FILE__, 'wcwhatsapp_set_default_template');

function wcwhatsapp_set_default_template() {
    if (get_option('wcwhatsapp_message_template') === false) {
        $default_template = "🛒 New Order #{order_id}\n👤 Customer: {customer_full_name}\n🏠 Billing Address: {billing_address}\n🚚 Shipping Address: {shipping_address}\n💵 Total: {total}৳\n🔗 View Order: {order_url}";
        update_option('wcwhatsapp_message_template', $default_template);
    }
}


add_action('admin_menu', 'wcwhatsapp_menu');

function wcwhatsapp_menu() {
    add_menu_page(
        'WhatsApp Order Notify',     
        'WhatsApp Notify',            
        'manage_options',             
        'WhatsAppOrderNotification',  
        'wcwhatsapp_settings_page',   
        'dashicons-whatsapp',         
        56                            
    );
}


add_action('admin_init', 'wcwhatsapp_settings');

function wcwhatsapp_settings() {
    register_setting('wcwhatsapp-settings-group', 'wcwhatsapp_phone');
    register_setting('wcwhatsapp-settings-group', 'wcwhatsapp_api_key');
    register_setting('wcwhatsapp-settings-group', 'wcwhatsapp_message_template');
}


function wcwhatsapp_settings_page() {
    ?>
    <div class="wrap">
        <h1>WhatsApp Order Notification Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('wcwhatsapp-settings-group'); ?>
            <?php do_settings_sections('wcwhatsapp-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">WhatsApp Phone Number</th>
                    <td><input type="text" name="wcwhatsapp_phone" value="<?php echo esc_attr(get_option('wcwhatsapp_phone')); ?>" placeholder="+8801XXXXXXXXX" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">CallMeBot API Key</th>
                    <td><input type="text" name="wcwhatsapp_api_key" value="<?php echo esc_attr(get_option('wcwhatsapp_api_key')); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Message Template</th>
                    <td>
                        <textarea name="wcwhatsapp_message_template" rows="8" cols="60"><?php echo esc_textarea(get_option('wcwhatsapp_message_template')); ?></textarea><br>
                        <p>Available Tags:</p>
                        <code>{customer_name}, {customer_full_name}, {order_id}, {total}, {order_url}, {billing_address}, {shipping_address}</code>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


add_action('woocommerce_thankyou', 'wcwhatsapp_send_notification', 10, 1);

function wcwhatsapp_send_notification($order_id) {
    if (!$order_id) return;

    $phone = get_option('wcwhatsapp_phone');
    $apikey = get_option('wcwhatsapp_api_key');
    $template = get_option('wcwhatsapp_message_template');

    if (empty($phone) || empty($apikey) || empty($template)) return;

    $order = wc_get_order($order_id);

    $full_name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();


    $billing_address = $order->get_billing_address_1();
    if ($order->get_billing_address_2()) {
        $billing_address .= ', ' . $order->get_billing_address_2();
    }
    $billing_address .= ', ' . $order->get_billing_city();
    $billing_address .= ', ' . $order->get_billing_state();
    $billing_address .= ', ' . $order->get_billing_postcode();
    $billing_address = trim($billing_address, ', ');
    
    
    $shipping_address = $order->get_shipping_address_1();
    if ($order->get_shipping_address_2()) {
        $shipping_address .= ', ' . $order->get_shipping_address_2();
    }
    $shipping_address .= ', ' . $order->get_shipping_city();
    $shipping_address .= ', ' . $order->get_shipping_state();
    $shipping_address .= ', ' . $order->get_shipping_postcode();
    $shipping_address = trim($shipping_address, ', ');

    $replacements = [
    '{customer_name}' => $order->get_billing_first_name(),
    '{customer_full_name}' => $full_name,
    '{order_id}' => $order_id,
    '{total}' => $order->get_total(),
    '{order_url}' => admin_url('post.php?post=' . $order_id . '&action=edit'), 
    '{billing_address}' => $billing_address ?: 'N/A',
    '{shipping_address}' => $shipping_address ?: 'N/A',
    ];


    $message = strtr($template, $replacements);
    $encoded_message = urlencode($message);

    $url = "https://api.callmebot.com/whatsapp.php?phone=$phone&text=$encoded_message&apikey=$apikey";

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        error_log('WhatsApp API error: ' . $response->get_error_message());
    } else {
        $code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        error_log("WhatsApp message sent. Status: $code, Response: $body");
    }
}
