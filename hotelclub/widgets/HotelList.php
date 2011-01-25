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
 * @package    HotelClub_Widget_HotelList
 * @subpackage PHP
 * @copyright  Copyright (c) 2010 HotelClub Pty Ltd (http://www.hotelclub.com)
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt    GNU GENERAL PUBLIC LICENSE
 * @version    SVN: $Id$
 */
class HotelClub_Widget_HotelList extends WP_Widget
{
    /**
     * Constructor
     *
     * @return void
     */
    function HotelClub_Widget_HotelList()
    {
        parent::WP_Widget(false, __('HotelClub Hotel List', 'hotelclub'), array('description' => __('Display a list of hotels complete with thumbnail images and star ratings', 'hotelclub')));
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
        extract($args);

        $data = null;

        $affiliateId = get_option('hotelclub_affiliate_id');
        $password = get_option('hotelclub_affiliate_password');

        if (!$affiliateId || !$password) {
            return;
        }

        $title = apply_filters('widget_title', $instance['title']);
        $limit = (int) $instance['limit'];

        $conditions = array(
            'LanguageCode' => get_option('hotelclub_language_code'),
            'CurrencyCode' => get_option('hotelclub_currency_code'),
            'SearchCriterias' => array(
                'SearchCriteria' => array(
                    'Location' => array(
                        'City' => array(
                            'ID' => $instance['city_id']
                        )
                    )
                )
            ),
            'RequestorPreference' => array(
                'AdditionalRequest' => array(
                    'Element' => array(
                        'Name' => 'PageURL',
                        'Value' => 'true'
                    )
                )
            )
        );

        if ($cache = hotelclub_cache_read($conditions)) {
            $data = $cache;
        } else {
            $hotelClub = new HotelClub();
            $hotelClub->config['AffiliateID'] = $affiliateId;
            $hotelClub->config['Password'] = $password;
            $hotelClub->config['protocol'] = get_option('hotelclub_protocol');
            $data = $hotelClub->HotelListRequest($conditions);
            if (isset($data->Hotels[0]->Hotel)) {
                hotelclub_cache_write($conditions, $data);
            } else {
                $data = null;
            }
        }

        if (!$data) {
            return;
        }

        include WP_PLUGIN_DIR . '/hotelclub/themes/' . get_option('hotelclub_theme') . '/HotelList.php';
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
        $instance['country_id'] = strip_tags($new_instance['country_id']);
        $instance['city_id'] = strip_tags($new_instance['city_id']);
        $instance['limit'] = strip_tags($new_instance['limit']);
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
        $country_id = (isset($instance['country_id'])) ? esc_attr($instance['country_id']) : '';
        $city_id = (isset($instance['city_id'])) ? esc_attr($instance['city_id']) : '';
        $limit = (isset($instance['limit'])) ? esc_attr($instance['limit']) : 3;

        if ($country_id == '') {
            $country_id = get_option('hotelclub_country_id');
        }

        if ($city_id == '') {
            $city_id = get_option('hotelclub_city_id');
        }

        global $wpdb;
        $table = $wpdb->prefix . 'hotelclub_countries';
        $countries = $wpdb->get_results("SELECT `id`, `name` FROM `{$table}`");
        $table = $wpdb->prefix . 'hotelclub_cities';
        $cities = $wpdb->get_results("SELECT * FROM `{$table}` WHERE `country_id` = {$country_id}");

        include WP_PLUGIN_DIR . '/hotelclub/forms/HotelList.php';
    }
}