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
 * @package    Default Theme Functions
 * @subpackage PHP
 * @copyright  Copyright (c) 2010 HotelClub Pty Ltd (http://www.hotelclub.com)
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt    GNU GENERAL PUBLIC LICENSE
 * @version    SVN: $Id$
 */
if (!is_admin()) {
    // Get theme
    $hotelclub_theme = get_option('hotelclub_theme');
    // Theme styles
    $hotelclub_style_url = WP_PLUGIN_URL . '/hotelclub/themes/' . $hotelclub_theme . '/style.css';
    $hotelclub_style_file = WP_PLUGIN_DIR . '/hotelclub/themes/' . $hotelclub_theme . '/style.css';
    if (file_exists($hotelclub_style_file)) {
        wp_register_style('jqueryui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/smoothness/jquery-ui.css', false, 1);
        wp_register_style('hotelclub', $hotelclub_style_url, false, 1);
        wp_enqueue_style('jqueryui');
        wp_enqueue_style('hotelclub');
    }
    // Theme scripts
    $hotelclub_script_url = WP_PLUGIN_URL . '/hotelclub/themes/' . $hotelclub_theme . '/script.js';
    $hotelclub_script_file = WP_PLUGIN_DIR . '/hotelclub/themes/' . $hotelclub_theme . '/script.js';
    if (file_exists($hotelclub_script_file)) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', false, 1);
        wp_register_script('jqueryui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js', array('jquery'), 1);
        wp_register_script('hotelclub', $hotelclub_script_url, array('jquery'), 1);
        wp_enqueue_script('jquery');
        wp_enqueue_script('jqueryui');
        wp_enqueue_script('hotelclub');
    }
}