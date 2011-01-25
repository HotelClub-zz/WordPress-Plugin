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
 * @package    HotelSearch Template
 * @subpackage PHP
 * @copyright  Copyright (c) 2010 HotelClub Pty Ltd (http://www.hotelclub.com)
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt    GNU GENERAL PUBLIC LICENSE
 * @version    SVN: $Id$
 */
?>
<?php echo $before_widget; ?>
<?php if ($title): ?>
    <?php echo $before_title; ?>
    <?php echo $title; ?>
    <?php echo $after_title; ?>
<?php endif; ?>
<form role="search" method="get" id="hotelclub_searchform" action="<?php echo get_home_url(); ?>">
    <div>
        <p>
            <label for="hotelclub_country_id"><?php _e('Country', 'hotelclub'); ?>:</label>
            <select class="hotelclub_country_id" id="hotelclub_country_id" name="hotelclub_country_id">
                <?php foreach ($countries as $country): ?>
                    <option value="<?php echo $country->id; ?>"<?php echo ($country_id == $country->id) ? ' selected="selected"' : ''; ?>><?php echo htmlspecialchars($country->name); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="hotelclub_city_id"><?php _e('City', 'hotelclub'); ?>:</label>
            <select class="hotelclub_city_id" id="hotelclub_city_id" name="hotelclub_city_id">
                <?php foreach ($cities as $city): ?>
                    <option value="<?php echo $city->id; ?>"<?php echo ($city_id == $city->id) ? ' selected="selected"' : ''; ?>><?php echo htmlspecialchars($city->name); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="hotelclub_checkin"><?php _e('Check in', 'hotelclub'); ?>:</label>
            <input type="text" id="hotelclub_checkin" class="datepicker" name="hotelclub_checkin" value="<?php echo date('Y-m-d', strtotime('+17 days')); ?>" />
        </p>
        <p>
            <label for="hotelclub_checkout"><?php _e('Check out', 'hotelclub'); ?>:</label>
            <input type="text" id="hotelclub_checkout" class="datepicker" name="hotelclub_checkout" value="<?php echo date('Y-m-d', strtotime('+19 days')); ?>" />
        </p>
        <p>
            <input type="submit" id="hotelclub_search" name="hotelclub_search" value="Search" />
        </p>
    </div>
</form>
<?php echo $after_widget; ?>