# WhatsApp Order Notification

## Description
The **WhatsApp Order Notification** plugin for WordPress is designed to help WooCommerce store owners stay informed about their orders. This plugin sends real-time order notifications to the admin's WhatsApp using the CallMeBot API. With this plugin, admins can easily monitor and manage their orders without missing any updates.

---

## Features
- 🚀 Sends WooCommerce order notifications directly to the admin's WhatsApp.
- ✨ Fully customizable message templates for personalized notifications.
- 📋 Simple configuration via the WordPress admin panel.
- 🔗 Includes dynamic placeholders for order details such as customer info, total amount, and order link.
- ✅ Easy-to-integrate and lightweight.

---

## Installation
1. **Download**: Clone or download the plugin repository.
2. **Upload**: Place the plugin folder into the `wp-content/plugins/` directory of your WordPress installation.
3. **Activate**: Navigate to **Plugins > Installed Plugins** in your WordPress admin dashboard and activate the plugin.

---

## Configuration
1. Go to the **WhatsApp Notify** menu in your WordPress Admin Dashboard.
2. Fill in the required fields:
   - **WhatsApp Phone Number**: The number where notifications will be sent (e.g., `+8801XXXXXXXXX`).
   - **CallMeBot API Key**: Obtain this key from CallMeBot (see the setup instructions below).
   - **Message Template**: Customize the notification message to suit your needs.

### Available Placeholders:
- `{customer_name}`: First name of the customer.
- `{customer_full_name}`: Full name of the customer.
- `{order_id}`: WooCommerce order ID.
- `{total}`: Total order amount.
- `{order_url}`: Admin URL to view the order details.
- `{billing_address}`: Customer's billing address.
- `{shipping_address}`: Customer's shipping address.

---

## Example Message Template
```
🛒 New Order #{order_id}
👤 Customer: {customer_full_name}
🏠 Billing Address: {billing_address}
🚚 Shipping Address: {shipping_address}
💵 Total: {total}৳
🔗 View Order: {order_url}
```

---

## CallMeBot API Setup
To use the plugin, you need to set up the CallMeBot API:

1. Save the phone number **+34 694 29 84 96** in your phone contacts (name it anything you like).
2. Open WhatsApp and send the following message to the saved contact:
   ```
   I allow callmebot to send me messages
   ```
3. Wait for a response from the bot. You should receive a message saying:
   ```
   API Activated for your phone number. Your APIKEY is [Your API Key]
   ```
   - If you don't receive the message within 2 minutes, try again after 24 hours.
4. Copy the provided API Key and paste it into the **CallMeBot API Key** field in the plugin settings.

---

## Usage
1. Install and configure the plugin as described above.
2. When a customer places an order, the plugin automatically sends a WhatsApp notification to the admin with the order details.

---

## Troubleshooting
### WhatsApp Notifications Not Being Sent?
- Check the following:
  - The **WhatsApp Phone Number** and **CallMeBot API Key** are correctly configured.
  - Ensure the message template contains valid placeholders.
- Review the WordPress error logs (`wp-content/debug.log`) for any API-related issues.

---

## Requirements
- WordPress 5.0 or higher.
- WooCommerce 3.0 or higher.
- PHP 7.2 or higher.

---

## Changelog
### Version 2.9
- Initial release of the WhatsApp Order Notification plugin.

---

## Credits
- **Author**: MRXADIK
- **Author URI**: [GitHub](https://github.com/mrxadik)

---

## License
This plugin is licensed under the [GPL v2 or later](https://www.gnu.org/licenses/gpl-2.0.html). You are free to use, modify, and distribute this plugin under the same license.

---

## Support
For any issues or suggestions, feel free to open an issue on the [GitHub repository](https://github.com/mrxadik).
