<?php
/*
Plugin Name: HotelClub
Plugin URI: http://www.hotelclub.com/
Description: HotelClub provides a variety of widgets to search and display hotels and is available in fourteen languages including Chinese (Simplified & Traditional), English, French, German, Italian, Japanese, Korean, Portuguese, Spanish, Swedish, Polish, Thai, Russian and Dutch. HotelClub is a world leading global accommodation website offering hotel and accommodation bookings for up to 12 months in advance with over 69,000 accommodation choices in over 7,300 cities worldwide throughout 138 countries.
Version: 1.0
Author: HotelClub Pty. Ltd.
Author URI: http://www.hotelclub.com/
License: GPL3
*/

/**
 * HotelClub
 * Copyright (C) 2010  HotelClub
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category   HotelClub
 * @package    HotelClub
 * @subpackage PHP
 * @copyright  Copyright (c) 2010 HotelClub Pty Ltd (http://www.hotelclub.com)
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt    GNU GENERAL PUBLIC LICENSE
 * @version    SVN: $Id$
 */

/**
 * @see HotelClub_Widget_HotelSearch
 */
if (isset($_GET['hotelclub_search'])) {
    $params = array(
        'id' => get_option('hotelclub_affiliate_id'),
        'lc' => get_option('hotelclub_language_code'),
        'cr' => get_option('hotelclub_currency_code'),
        'ru' => 'SearchResults.asp?id=' . $_GET['hotelclub_city_id'] . '&Checkin=' . $_GET['hotelclub_checkin'] . '&Checkout=' . $_GET['hotelclub_checkout']
    );
    $url = get_option('hotelclub_domain') . 'enter.asp?' . http_build_query($params);
    header('Location: ' . $url);
    exit;
}

/**
 * @see HotelClub
 */
require_once WP_PLUGIN_DIR . '/hotelclub/library/HotelClub.php';

/**
 * @see HotelClub_Widget_HotelList
 */
require_once WP_PLUGIN_DIR . '/hotelclub/widgets/HotelList.php';

/**
 * @see HotelClub_Widget_HotelSearch
 */
require_once WP_PLUGIN_DIR . '/hotelclub/widgets/HotelSearch.php';

/**
 * @see HotelClub_Widget_MonthlyFavouriteCityList
 */
require_once WP_PLUGIN_DIR . '/hotelclub/widgets/MonthlyFavouriteCityList.php';

/**
 * @see HotelClub_Widget_TopCityList
 */
require_once WP_PLUGIN_DIR . '/hotelclub/widgets/TopCityList.php';

/**
 * HotelClub Default Options.
 *
 * @var array
 */
global $hotelclub_default_options;
$hotelclub_default_options = array(
    'hotelclub_affiliate_id' => '',
    'hotelclub_affiliate_password' => '',
    'hotelclub_cache_duration' => 2592000,
    'hotelclub_city_id' => 1,
    'hotelclub_country_id' => 3,
    'hotelclub_currency_code' => 'AUD',
    'hotelclub_domain' => 'http://www.hotelclub.com/',
    'hotelclub_language_code' => 'EN',
    'hotelclub_protocol' => 'https',
    'hotelclub_theme' => 'default'
);

/**
 * Plugin File.
 *
 * @var string
 */
$hotelclub_plugin_file = plugin_basename(__FILE__);

/**
 * HotelClub Version.
 *
 * @var float
 */
global $hotelclub_version;
$hotelclub_version = 1.0;

/**
 * HotelClub Widgets.
 *
 * @var array
 */
global $hotelclub_widgets;
$hotelclub_widgets = array(
    'HotelList',
    'MonthlyFavouriteCityList',
    'TopCityList'
);

/**
 * HotelClub Activation Hook
 *
 * @return void
 */
function hotelclub_activation_hook()
{
    global $hotelclub_default_options;
    global $wpdb;
    $dir = dirname(__FILE__);

    // Add options
    foreach ($hotelclub_default_options as $name => $value) {
        add_option($name, $value);
    }

    // Create countries table
    $table = $wpdb->prefix . 'hotelclub_countries';
    $wpdb->query("DROP TABLE IF EXISTS `{$table}`");
    $wpdb->query("CREATE TABLE IF NOT EXISTS `{$table}` (
                   `id` INT(10) UNSIGNED NOT NULL,
                   `name` VARCHAR(100) NOT NULL,
                   PRIMARY KEY (`id`),
                   KEY `name` (`name`)
                 ) DEFAULT CHARSET=utf8;"
    );

    // Populate countries table
    $countries = json_decode(file_get_contents($dir . '/data/countries.json'), true);
    foreach ($countries as $country) {
        $wpdb->insert($table, $country);
    }

    // Create cities table
    $table = $wpdb->prefix . 'hotelclub_cities';
    $wpdb->query("DROP TABLE IF EXISTS `{$table}`");
    $wpdb->query("CREATE TABLE IF NOT EXISTS `{$table}` (
                   `id` INT(10) UNSIGNED NOT NULL,
                   `name` VARCHAR(100) NOT NULL,
                   `country_id` INT(10) UNSIGNED NOT NULL,
                   PRIMARY KEY (`id`),
                   KEY `name` (`name`),
                   KEY `country` (`country_id`)
                 ) DEFAULT CHARSET=utf8;"
    );

    // Populate cities table
    $cities = json_decode(file_get_contents($dir . '/data/cities.json'), true);
    foreach ($cities as $city) {
        $wpdb->insert($table, $city);
    }
}

/**
 * HotelClub Admin Menu
 *
 * @return void
 */
function hotelclub_admin_menu()
{
    add_options_page(__('HotelClub Settings', 'hotelclub'), 'HotelClub', 'manage_options', 'hotelclub', 'hotelclub_options_page');
}

/**
 * HotelClub Admin Notices
 *
 * @return void
 */
function hotelclub_admin_notices()
{
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'clear_cache') {
            hotelclub_cache_clear();
            echo '<div class="updated"><p><strong>' . __('Cache cleared', 'hotelclub') . '.</strong></p></div>';
            return;
        }
    }
}

/**
 * HotelClub Cache Delete
 *
 * @return void
 */
function hotelclub_cache_clear()
{
    global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->options WHERE (option_name LIKE 'hotelclub_cache_%' AND option_name <> 'hotelclub_cache_duration')");
    return;
}

/**
 * HotelClub Cache Read
 *
 * @return mixed
 */
function hotelclub_cache_read($conditions)
{
    // Define cache hash
    $hash = sha1(serialize($conditions));

    // Define cache name
    $cacheName = 'hotelclub_cache_' . $hash;

    // Does the cache exist?
    if ($cacheValue = get_option($cacheName)) {

        // Define the cache expiry name
        $cacheExpName = 'hotelclub_cache_exp_' . $hash;

        // Does the cache expiry exist?
        if ($cacheExpValue = get_option($cacheExpName)) {

            // Has the cache expired?
            if ($cacheExpValue > time()) {
                return unserialize($cacheValue);
            }

        }

    }

    return false;
}

/**
 * HotelClub Cache Write
 *
 * @return void
 */
function hotelclub_cache_write($conditions, $data)
{
    $hash = sha1(serialize($conditions));
    $name = 'hotelclub_cache_' . $hash;
    update_option($name, serialize($data));
    $name = 'hotelclub_cache_exp_' . $hash;
    $value = time() + get_option('hotelclub_cache_duration');
    update_option($name, $value);
    return;
}

/**
 * HotelClub Deactivation Hook
 *
 * @return void
 */
function hotelclub_deactivation_hook()
{
    global $wpdb;

    // Delete options and clear cache
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '%hotelclub%'");

    // Drop countries table
    $table = $wpdb->prefix . 'hotelclub_countries';
    $wpdb->query("DROP TABLE IF EXISTS `{$table}`;");

    // Drop cities table
    $table = $wpdb->prefix . 'hotelclub_cities';
    $wpdb->query("DROP TABLE IF EXISTS `{$table}`;");
}

/**
 * HotelClub Enqueue Script
 *
 * @return void
 */
function hotelclub_enqueue_script()
{
    global $hotelclub_version;
    if (is_admin()) {
        wp_enqueue_script('hotelclub', plugins_url('/js/script.js', __FILE__), array('jquery'), $hotelclub_version);
    }
}

/**
 * HotelClub Get Cities
 *
 * @return void
 */
function hotelclub_get_cities()
{
    global $wpdb;
    $data = '';
    $table = $wpdb->prefix . 'hotelclub_cities';
    if ($cities = $wpdb->get_results("SELECT * FROM `{$table}` WHERE `country_id` = {$_GET['country_id']}")) {
        if (!empty($cities)) {
            foreach ($cities as $city) {
                $data .= '<option value="' . $city->id . '">' . $city->name . '</option>';
            }
        }
    }
    die($data);
}

/**
 * HotelClub Init
 *
 * @return void
 */
function hotelclub_init()
{
    load_plugin_textdomain('hotelclub', null, 'hotelclub/languages');
    $hotelclub_theme_functions_file = WP_PLUGIN_DIR . '/hotelclub/themes/' . get_option('hotelclub_theme') . '/functions.php';
    if (file_exists($hotelclub_theme_functions_file)) {
        require_once $hotelclub_theme_functions_file;
    }
}

/**
 * HotelClub JavaScript Variables
 *
 * @return void
 */
function hotelclub_javascript_variables()
{
    $ajaxurl = get_option('siteurl') . '/wp-admin/admin-ajax.php';
    $script = '<script type="text/javascript">' . "\n";
    $script .= 'var ajaxurl = \'' . $ajaxurl . '\';' . "\n";
    $script .= '</script>' . "\n";
    echo $script;
}

/**
 * HotelClub Options Page
 *
 * @return void
 */
function hotelclub_options_page()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'hotelclub'));
    }
    include 'forms/options.php';
}

/**
 * HotelClub Settings Link
 *
 * @param  array $links Array of links to modify.
 * @return array
 */
function hotelclub_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=hotelclub">' . __('Settings', 'hotelclub') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

/**
 * Register hooks
 */
register_activation_hook(__FILE__, 'hotelclub_activation_hook');
register_deactivation_hook(__FILE__, 'hotelclub_deactivation_hook');

/**
 * Add actions
 */
add_action('init', 'hotelclub_init');
add_action('admin_menu', 'hotelclub_admin_menu');
add_action('admin_notices', 'hotelclub_admin_notices');
add_action('wp_ajax_hotelclub_get_cities', 'hotelclub_get_cities');
add_action('wp_ajax_nopriv_hotelclub_get_cities', 'hotelclub_get_cities');
add_action('wp_head', 'hotelclub_javascript_variables');
add_action('wp_print_scripts', 'hotelclub_enqueue_script');
add_action('widgets_init', create_function('', 'return register_widget("HotelClub_Widget_HotelList");'));
add_action('widgets_init', create_function('', 'return register_widget("HotelClub_Widget_HotelSearch");'));
add_action('widgets_init', create_function('', 'return register_widget("HotelClub_Widget_MonthlyFavouriteCityList");'));
add_action('widgets_init', create_function('', 'return register_widget("HotelClub_Widget_TopCityList");'));

/**
 * Add filters
 */
add_filter("plugin_action_links_$hotelclub_plugin_file", 'hotelclub_settings_link');