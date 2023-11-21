<?php
// Make sure we don't expose any info if called directly
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/* @wordpress-plugin
 * Plugin Name:       OneClick Chat to Order
 * Plugin URI:        https://onlinestorekit.com/oneclick-chat-to-order/
 * Description:       Make it easy for your customers to order via WhatsApp chat through a single button click with detailing information about a product including custom message. OneClick Chat to Order button can be displayed on a single product page and as a floating button. GDPR-ready!
 * Version:           1.0.5
 * Author:            Walter Pinem
 * Author URI:        https://walterpinem.me/projects/
 * Developer:         Walter Pinem | Seni Berpikir
 * Developer URI:     https://www.seniberpikir.com/
 * Text Domain:       oneclick-wa-order
 * Domain Path:       /languages
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 *
 * Requires at least: 5.0
 * Tested up to: 6.4.1
 *
 * WC requires at least: 7.2.2
 * WC tested up to: 8.2.2
 *
 * Copyright: © 2019 - 2023 Walter Pinem.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('OCWAORDER_PLUGIN_DIR')) {
    define('OCWAORDER_PLUGIN_DIR', plugin_dir_url(__FILE__));
    define('OCWAORDER_PLUGIN_VERSION', get_file_data(__FILE__, array('Version' => 'Version'), false)['Version']);
}
add_action('plugins_loaded', 'OCWAORDER_plugin_init', 0);

// Set Global WA Base URL
// @since 1.0.5
$GLOBALS['wa_base'] = 'api';

/**
 * Adds an action to declare compatibility with High Performance Order Storage (HPOS)
 * before WooCommerce initialization.
 *
 * @since 1.0.5
 *
 * @param string   $hook_name  The name of the action to which the callback function is hooked.
 * @param callable $callback   The callback function to be executed when the action is run.
 * @param int      $priority   Optional. The order in which the callback functions are executed. Default is 10.
 * @param int      $args_count Optional. The number of arguments the callback accepts. Default is 1.
 *
 * @return void
 */
add_action(
    'before_woocommerce_init',
    function () {
        // Check if the FeaturesUtil class exists in the \Automattic\WooCommerce\Utilities namespace.
        if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
            // Declare compatibility with custom order tables using the FeaturesUtil class.
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
        }
    }
);

// Plugin Start
function OCWAORDER_plugin_init()
{
    // Start calling main css
    function OCWAORDER_include_plugin_css()
    {
        wp_register_style('wa_order_style',  plugin_dir_url(__FILE__) . 'assets/css/main-style.css');
        wp_enqueue_style('wa_order_style');
    }
    add_action('wp_enqueue_scripts', 'OCWAORDER_include_plugin_css');

    // Start calling main frontend js
    function OCWAORDER_include_plugin_main_js()
    {
        wp_register_script('wa_order_main_front_js',  plugin_dir_url(__FILE__) . 'assets/js/wa-single-button.js');
    }
    add_action('wp_enqueue_scripts', 'OCWAORDER_include_plugin_main_js');

    // Start calling admin css
    function OCWAORDER_include_admin_css()
    {
        wp_register_style('wa_order_style_admin',  plugin_dir_url(__FILE__) . 'assets/css/admin-style.css');
        wp_register_style('wa_order_selet2_style',  plugin_dir_url(__FILE__) . 'assets/css/select2.min.css');
        wp_enqueue_style('wa_order_style_admin');
    }
    add_action('admin_enqueue_scripts', 'OCWAORDER_include_admin_css');

    function OCWAORDER_include_admin_js()
    {
        wp_register_script('wa_order_js_admin',  plugin_dir_url(__FILE__) . 'assets/js/admin-main.js');
        wp_register_script('wa_order_js_select2',  plugin_dir_url(__FILE__) . 'assets/js/select2.min.js');
        wp_register_script('wp-color-picker-alpha', plugins_url('assets/js/wp-color-picker-alpha.min.js',  __FILE__), array('wp-color-picker'), '3.0.3', true);
        wp_register_script('wp-color-picker-init', plugins_url('assets/js/wp-color-picker-init.js',  __FILE__), array('wp-color-picker-alpha'), '3.0.0', true);
    }
    add_action('admin_enqueue_scripts', 'OCWAORDER_include_admin_js');

    // Start calling main files
    require_once dirname(__FILE__) . '/admin/wa-admin-page.php';
    require_once dirname(__FILE__) . '/includes/wa-button.php';
    require_once dirname(__FILE__) . '/includes/wa-gdpr.php';
    require_once dirname(__FILE__) . '/includes/wa-metabox.php';
    require_once dirname(__FILE__) . '/includes/multiple-numbers.php';

    // Make sure WooCommerce is active
    function OCWAORDER_check_woocommece_active()
    {
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            echo "<div class='error'><p><strong>WA Order</strong> requires <strong>WooCommerce plugin.</strong>Please install and activate it.</p></div>";
        }
    }
    add_action('admin_notices', 'OCWAORDER_check_woocommece_active');

    // Localize this plugin
    function OCWAORDER_languages_init()
    {
        $plugin_dir = basename(dirname(__FILE__));
        load_plugin_textdomain('oneclick-wa-order', false, $plugin_dir . '/languages');
    }
    add_action('plugins_loaded', 'OCWAORDER_languages_init');
}

// Add setting link plugin page
function OCWAORDER_settings_link($links_array, $plugin_file_name)
{
    if (strpos($plugin_file_name, basename(__FILE__))) {
        array_unshift($links_array, '<a href="admin.php?page=wa-order">Settings</a>');
    }
    return $links_array;
}
add_filter('plugin_action_links', 'OCWAORDER_settings_link', 10, 2);

// Add Donate Link
function wa_order_donate_link_plugin($links)
{
    $links = array_merge($links, array(
        '<a href="https://www.paypal.me/WalterPinem" target="_blank">' . __('Buy Me a Coffee ☕', 'oneclick-wa-order') . '</a>'
    ));
    return $links;
}
add_action('plugin_action_links_' . plugin_basename(__FILE__), 'wa_order_donate_link_plugin');

// Disable Auto Draft for WA Number CPT
add_action('admin_enqueue_scripts', 'wa_order_disable_auto_drafts');
function wa_order_disable_auto_drafts()
{
    if ('wa-order-numbers' == get_post_type())
        wp_dequeue_script('autosave');
}

// Selected WhatsApp number that's previously defined
// Since version 1.0.5
function wa_order_get_phone_number($post_id)
{
    // Get WA Number from Plugin Setting
    $wanumberpage = get_option('wa_order_selected_wa_number_single_product');
    $args = array(
        'name'        => $wanumberpage,
        'post_type'   => 'wa-order-numbers',
        'post_status' => 'publish',
        'numberposts' => 1
    );
    $posts = get_posts($args);
    $pid = (!empty($posts)) ? $posts[0]->ID : 0;
    $phone_number = get_post_meta($pid, 'wa_order_phone_number_input', true);
    // Check if a number is assigned to the product
    $single_number_check = get_post_meta($post_id, '_wa_order_phone_number_check', true);
    if ($single_number_check === 'yes') {
        // WA Number from Product Metabox
        $wanumber_meta = get_post_meta($post_id, '_wa_order_phone_number', true);
        $args_meta = array(
            'title'       => $wanumber_meta,
            'post_type'   => 'wa-order-numbers',
            'post_status' => 'publish',
            'numberposts' => 1
        );
        $posts_meta = get_posts($args_meta);
        if (!empty($posts_meta)) {
            $phone_number = get_post_meta($posts_meta[0]->ID, 'wa_order_phone_number_input', true);
        }
    }

    return $phone_number;
}
