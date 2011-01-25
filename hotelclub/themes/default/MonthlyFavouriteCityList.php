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
 * @package    MonthlyFavouriteCityList Template
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
<ul>
    <?php foreach ($data->City as $city): ?>
        <li><a href="<?php echo $data->BaseUrl; ?><?php echo $city->Url; ?>#ID=<?php echo get_option('hotelclub_affiliate_id'); ?>"><?php echo $city->Name; ?></a></li>
    <?php endforeach; ?>
</ul>
<?php echo $after_widget; ?>