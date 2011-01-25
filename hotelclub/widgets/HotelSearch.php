<?php
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
 * @package    HotelClub_Widget_HotelSearch
 * @subpackage PHP
 * @copyright  Copyright (c) 2010 HotelClub Pty Ltd (http://www.hotelclub.com)
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt    GNU GENERAL PUBLIC LICENSE
 * @version    SVN: $Id$
 */
class HotelClub_Widget_HotelSearch extends WP_Widget
{
    /**
     * Constructor
     *
     * @return void
     */
    function HotelClub_Widget_HotelSearch()
    {
        parent::WP_Widget(false, __('HotelClub Hotel Search', 'hotelclub'), array('description' => __('Display a hotel search form', 'hotelclub')));
    }

    /**
     * Widget
     *
     * @param  array $args Array of arguments.
     * @param  array $instance Array of widget instance options.
     * @return void
     */
    function widget($args, $instance)
    {
        $affiliateId = get_option('hotelclub_affiliate_id');
        $password = get_option('hotelclub_affiliate_password');

        if (!$affiliateId || !$password) {
            return;
        }

        global $wpdb;

        extract($args);

        $title = apply_filters('widget_title', $instance['title']);

        // Countries
        $country_id = get_option('hotelclub_country_id');
        $table = $wpdb->prefix . 'hotelclub_countries';
        $countries = $wpdb->get_results("SELECT `id`, `name` FROM `{$table}`");

        // Cities
        $city_id = get_option('hotelclub_city_id');
        $table = $wpdb->prefix . 'hotelclub_cities';
        $cities = $wpdb->get_results("SELECT * FROM `{$table}` WHERE `country_id` = {$country_id}");

        include WP_PLUGIN_DIR . '/hotelclub/themes/' . get_option('hotelclub_theme') . '/HotelSearch.php';
    }

    /**
     * Update
     *
     * @param  array $new_instance Array of new widget instance options.
     * @param  array $old_instance Array of old widget instance options.
     * @return array
     */
    function update($new_instance, $old_instance)
    {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /**
     * Form
     *
     * @param  array $instance Array of widget instance options.
     * @return void
     */
    function form($instance)
    {
        $title = (isset($instance['title'])) ? esc_attr($instance['title']) : '';
        include WP_PLUGIN_DIR . '/hotelclub/forms/HotelSearch.php';
    }
}