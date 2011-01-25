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
 * @package    Options Form
 * @subpackage PHP
 * @copyright  Copyright (c) 2010 HotelClub Pty Ltd (http://www.hotelclub.com)
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt    GNU GENERAL PUBLIC LICENSE
 * @version    SVN: $Id$
 */

global $hotelclub_default_options;
global $wpdb;

?>
<div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div>
    <h2><?php _e('HotelClub Settings', 'hotelclub'); ?></h2>
    <form method="post" action="options.php">
        <?php wp_nonce_field('update-options'); ?>
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="<?php echo implode(',', array_keys($hotelclub_default_options)); ?>" />
        <h3><?php _e('Affiliate Details', 'hotelclub'); ?></h3>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="hotelclub_affiliate_id"><?php _e('Affiliate ID', 'hotelclub'); ?></label></th>
                <td>
                    <input id="hotelclub_affiliate_id" name="hotelclub_affiliate_id" type="text" value="<?php echo get_option('hotelclub_affiliate_id'); ?>" class="medium-text" />
                    <span class="description"><?php _e('Enter your HotelClub Affiliate ID', 'hotelclub'); ?></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="hotelclub_affiliate_password"><?php _e('Affiliate Password', 'hotelclub'); ?></label></th>
                <td>
                    <input id="hotelclub_affiliate_password" name="hotelclub_affiliate_password" type="password" value="<?php echo get_option('hotelclub_affiliate_password'); ?>" class="medium-text" />
                    <span class="description"><?php _e('Enter your HotelClub Affiliate Password', 'hotelclub'); ?></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">&nbsp;</th>
                <td><p><?php _e('Not a HotelClub Affiliate?', 'hotelclub'); ?> <a href="http://affiliates.hotelclub.com/WordPress/signup" target="_blank"><?php _e('Join now for FREE!', 'hotelclub'); ?></a></p></td>
            </tr>
        </table>
        <h3><?php _e('General Settings', 'hotelclub'); ?></h3>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="hotelclub_country_id"><?php _e('Country', 'hotelclub'); ?></label></th>
                <td>
                    <?php $country_id = get_option('hotelclub_country_id'); ?>
                    <?php $table = $wpdb->prefix . 'hotelclub_countries'; ?>
                    <?php $countries = $wpdb->get_results("SELECT * FROM `{$table}`"); ?>
                    <select id="hotelclub_country_id" class="hotelclub_country_id" name="hotelclub_country_id">
                        <?php foreach ($countries as $country): ?>
                            <option value="<?php echo $country->id; ?>"<?php echo ($country->id == $country_id) ? ' selected="selected"' : ''; ?>><?php echo $country->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="description"><?php _e('Choose your default country', 'hotelclub'); ?></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="hotelclub_city_id"><?php _e('City', 'hotelclub'); ?></label></th>
                <td>
                    <?php $city_id = get_option('hotelclub_city_id'); ?>
                    <?php $table = $wpdb->prefix . 'hotelclub_cities'; ?>
                    <?php $cities = $wpdb->get_results("SELECT * FROM `{$table}` WHERE `country_id` = {$country_id}"); ?>
                    <select id="hotelclub_city_id" class="hotelclub_city_id" name="hotelclub_city_id">
                        <?php foreach ($cities as $city): ?>
                            <option value="<?php echo $city->id; ?>"<?php echo ($city->id == $city_id) ? ' selected="selected"' : ''; ?>><?php echo $city->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="description"><?php _e('Choose your default city', 'hotelclub'); ?></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="hotelclub_language_code"><?php _e('Language', 'hotelclub'); ?></label></th>
                <td>
                    <?php $option = get_option('hotelclub_language_code'); ?>
                    <select id="hotelclub_language_code" name="hotelclub_language_code">
                        <option value="EN"<?php echo ($option == 'EN') ? ' selected="selected"' : ''; ?>>English</option>
                        <option value="DE"<?php echo ($option == 'DE') ? ' selected="selected"' : ''; ?>>Deutsch</option>
                        <option value="ES"<?php echo ($option == 'ES') ? ' selected="selected"' : ''; ?>>Español</option>
                        <option value="FR"<?php echo ($option == 'FR') ? ' selected="selected"' : ''; ?>>Français</option>
                        <option value="IT"<?php echo ($option == 'IT') ? ' selected="selected"' : ''; ?>>Italiano</option>
                        <option value="PL"<?php echo ($option == 'PL') ? ' selected="selected"' : ''; ?>>Polska</option>
                        <option value="PT"<?php echo ($option == 'PT') ? ' selected="selected"' : ''; ?>>Português</option>
                        <option value="SV"<?php echo ($option == 'SV') ? ' selected="selected"' : ''; ?>>Svenska</option>
                        <option value="RU"<?php echo ($option == 'RU') ? ' selected="selected"' : ''; ?>>Россию</option>
                        <option value="NL"<?php echo ($option == 'NL') ? ' selected="selected"' : ''; ?>>Nederlandse</option>
                        <option value="JP"<?php echo ($option == 'JP') ? ' selected="selected"' : ''; ?>>日本</option>
                        <option value="KR"<?php echo ($option == 'KR') ? ' selected="selected"' : ''; ?>>한국어</option>
                        <option value="TH"<?php echo ($option == 'TH') ? ' selected="selected"' : ''; ?>>ไทย</option>
                        <option value="CS"<?php echo ($option == 'CS') ? ' selected="selected"' : ''; ?>>简体中文</option>
                        <option value="CN"<?php echo ($option == 'CN') ? ' selected="selected"' : ''; ?>>繁體中文</option>
                    </select>
                    <span class="description"><?php _e('Choose your default language', 'hotelclub'); ?></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="hotelclub_currency_code"><?php _e('Currency', 'hotelclub'); ?></label></th>
                <td>
                    <?php $option = get_option('hotelclub_currency_code'); ?>
                    <select id="hotelclub_currency_code" name="hotelclub_currency_code">
                        <option value="AUD"<?php echo ($option == 'AUD') ? ' selected="selected"' : ''; ?>>$(AUD)</option>
                        <option value="CAD"<?php echo ($option == 'CAD') ? ' selected="selected"' : ''; ?>>$(CAD)</option>
                        <option value="CHF"<?php echo ($option == 'CHF') ? ' selected="selected"' : ''; ?>>SFr(CHF)</option>
                        <option value="DKK"<?php echo ($option == 'DKK') ? ' selected="selected"' : ''; ?>>kr(DKK)</option>
                        <option value="EUR"<?php echo ($option == 'EUR') ? ' selected="selected"' : ''; ?>>€(EUR)</option>
                        <option value="GBP"<?php echo ($option == 'GBP') ? ' selected="selected"' : ''; ?>>£(GBP)</option>
                        <option value="HKD"<?php echo ($option == 'HKD') ? ' selected="selected"' : ''; ?>>$(HKD)</option>
                        <option value="JPY"<?php echo ($option == 'JPY') ? ' selected="selected"' : ''; ?>>¥(JPY)</option>
                        <option value="KRW"<?php echo ($option == 'KRW') ? ' selected="selected"' : ''; ?>>₩(KRW)</option>
                        <option value="MYR"<?php echo ($option == 'MYR') ? ' selected="selected"' : ''; ?>>M$(MYR)</option>
                        <option value="NOK"<?php echo ($option == 'NOK') ? ' selected="selected"' : ''; ?>>kr(NOK)</option>
                        <option value="NZD"<?php echo ($option == 'NZD') ? ' selected="selected"' : ''; ?>>$(NZD)</option>
                        <option value="PHP"<?php echo ($option == 'PHP') ? ' selected="selected"' : ''; ?>>₱(PHP)</option>
                        <option value="SEK"<?php echo ($option == 'SEK') ? ' selected="selected"' : ''; ?>>kr(SEK)</option>
                        <option value="SGD"<?php echo ($option == 'SGD') ? ' selected="selected"' : ''; ?>>$(SGD)</option>
                        <option value="THB"<?php echo ($option == 'THB') ? ' selected="selected"' : ''; ?>>฿(THB)</option>
                        <option value="TWD"<?php echo ($option == 'TWD') ? ' selected="selected"' : ''; ?>>元(TWD)</option>
                        <option value="USD"<?php echo ($option == 'USD') ? ' selected="selected"' : ''; ?>>$(USD)</option>
                        <option value="ZAR"<?php echo ($option == 'ZAR') ? ' selected="selected"' : ''; ?>>R(ZAR)</option>
                    </select>
                    <span class="description"><?php _e('Choose your default currency', 'hotelclub'); ?></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="hotelclub_domain"><?php _e('HotelClub Site Address (URL)', 'hotelclub'); ?></label></th>
                <td>
                    <?php $option = get_option('hotelclub_domain'); ?>
                    <select id="hotelclub_domain" name="hotelclub_domain">
                        <option value="http://www.hotelclub.com/"<?php echo ($option == 'http://www.hotelclub.com/') ? ' selected="selected"' : ''; ?>>HotelClub.com</option>
                        <option value="http://www.hotelclub.de/"<?php echo ($option == 'http://www.hotelclub.de/') ? ' selected="selected"' : ''; ?>>HotelClub.de</option>
                        <option value="http://www.hotelclub.es/"<?php echo ($option == 'http://www.hotelclub.es/') ? ' selected="selected"' : ''; ?>>HotelClub.es</option>
                        <option value="http://www.hotelclub.fr/"<?php echo ($option == 'http://www.hotelclub.fr/') ? ' selected="selected"' : ''; ?>>HotelClub.fr</option>
                        <option value="http://www.hotelclub.it/"<?php echo ($option == 'http://www.hotelclub.it/') ? ' selected="selected"' : ''; ?>>HotelClub.it</option>
                        <option value="http://www.hotelclub.co.jp/"<?php echo ($option == 'http://www.hotelclub.co.jp/') ? ' selected="selected"' : ''; ?>>HotelClub.co.jp</option>
                        <option value="http://www.hotelclub.co.kr/"<?php echo ($option == 'http://www.hotelclub.co.kr/') ? ' selected="selected"' : ''; ?>>HotelClub.co.kr</option>
                        <option value="http://www.hotelclub.cn/"<?php echo ($option == 'http://www.hotelclub.cn/') ? ' selected="selected"' : ''; ?>>HotelClub.cn</option>
                        <option value="http://www.hotelclub.com.tw/"<?php echo ($option == 'http://www.hotelclub.com.tw/') ? ' selected="selected"' : ''; ?>>HotelClub.com.tw</option>
                    </select>
                    <span class="description"><?php _e('Choose your default HotelClub site address', 'hotelclub'); ?></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="hotelclub_protocol"><?php _e('Connection Protocol', 'hotelclub'); ?></label></th>
                <td>
                    <?php $option = get_option('hotelclub_protocol'); ?>
                    <select id="hotelclub_protocol" name="hotelclub_protocol">
                        <option value="http"<?php echo ($option == 'http') ? ' selected="selected"' : ''; ?>>HTTP (<?php _e('Less secure but faster', 'hotelclub'); ?>)</option>
                        <option value="https"<?php echo ($option == 'https') ? ' selected="selected"' : ''; ?>>HTTPS (<?php _e('More secure but slower', 'hotelclub'); ?>)</option>
                    </select>
                    <span class="description"><?php _e('Use <code>HTTP</code> if you are having problems with <code>HTTPS</code>', 'hotelclub'); ?></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="hotelclub_theme"><?php _e('Theme', 'hotelclub'); ?></label></th>
                <td>
                    <?php $option = get_option('hotelclub_theme'); ?>
                    <select id="hotelclub_theme" name="hotelclub_theme">
                        <?php $themes = scandir(WP_PLUGIN_DIR . '/hotelclub/themes'); ?>
                        <?php foreach ($themes as $theme): ?>
                            <?php if ($theme !== '.' && $theme !== '..'): ?>
                                <option value="<?php echo $theme; ?>"<?php echo ($option == $theme) ? ' selected="selected"' : ''; ?>><?php echo $theme; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <span class="description"><?php _e('You can create your own theme in <code>wp-content/plugins/hotelclub/themes</code>', 'hotelclub'); ?></span>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="hotelclub_cache_duration"><?php _e('Cache', 'hotelclub'); ?></label></th>
                <td>
                    <?php $option = get_option('hotelclub_cache_duration'); ?>
                    <select id="hotelclub_cache_duration" name="hotelclub_cache_duration">
                        <option value="3600"<?php echo ($option == 3600) ? ' selected="selected"' : ''; ?>><?php _e('1 hour', 'hotelclub'); ?></option>
                        <option value="86400"<?php echo ($option == 86400) ? ' selected="selected"' : ''; ?>><?php _e('1 day', 'hotelclub'); ?></option>
                        <option value="604800"<?php echo ($option == 604800) ? ' selected="selected"' : ''; ?>><?php _e('1 week', 'hotelclub'); ?></option>
                        <option value="2592000"<?php echo ($option == 2592000) ? ' selected="selected"' : ''; ?>><?php _e('1 month', 'hotelclub'); ?></option>
                    </select>
                    <span class="description"><?php _e('How long should data be cached?', 'hotelclub'); ?></span>
                    <a href="options-general.php?page=hotelclub&amp;action=clear_cache" class="button-primary"><?php _e('Clear Cache'); ?></a>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
        </p>
    </form>
</div>