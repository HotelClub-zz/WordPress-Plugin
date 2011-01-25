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
 * @package    HotelList Form
 * @subpackage PHP
 * @copyright  Copyright (c) 2010 HotelClub Pty Ltd (http://www.hotelclub.com)
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt    GNU GENERAL PUBLIC LICENSE
 * @version    SVN: $Id$
 */
?>
<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'hotelclub'); ?>:</label>
    <input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('country_id'); ?>"><?php _e('Country', 'hotelclub'); ?>:</label>
    <select class="widefat hotelclub_country_id" id="<?php echo $this->get_field_id('country_id'); ?>" name="<?php echo $this->get_field_name('country_id'); ?>">
        <?php foreach ($countries as $country): ?>
            <option value="<?php echo $country->id; ?>"<?php echo ($country_id == $country->id) ? ' selected="selected"' : ''; ?>><?php echo htmlspecialchars($country->name); ?></option>
        <?php endforeach; ?>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('city_id'); ?>"><?php _e('City', 'hotelclub'); ?>:</label>
    <select class="widefat hotelclub_city_id" id="<?php echo $this->get_field_id('city_id'); ?>" name="<?php echo $this->get_field_name('city_id'); ?>">
        <?php foreach ($cities as $city): ?>
            <option value="<?php echo $city->id; ?>"<?php echo ($city_id == $city->id) ? ' selected="selected"' : ''; ?>><?php echo htmlspecialchars($city->name); ?></option>
        <?php endforeach; ?>
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Number of hotels to show', 'hotelclub'); ?>:</label>
    <select id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <option value="<?php echo $i; ?>"<?php echo ($limit == $i) ? ' selected="selected"' : ''; ?>><?php echo $i; ?></option>
        <?php endfor; ?>
    </select>
</p>