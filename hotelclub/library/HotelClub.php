<?php
/**
 * HotelClub
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled with this
 * package in the file LICENSE. It is also available through the world-wide-web
 * at this URL: http://www.opensource.org/licenses/bsd-license.php
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world-wide-web, please send an email to license@hotelclub.com so
 * we can send you a copy immediately.
 *
 * @category   HotelClub
 * @package    HotelClub
 * @subpackage PHP
 * @copyright  Copyright (c) 2010 HotelClub Pty Ltd (http://www.hotelclub.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php    New BSD License
 * @version    SVN: $Id$
 */

/**
 * HotelClub class
 *
 * @category   HotelClub
 * @package    HotelClub
 * @copyright  Copyright (c) 2010 HotelClub Pty Ltd (http://www.hotelclub.com)
 * @license    http://www.opensource.org/licenses/bsd-license.php    New BSD License
 */
class HotelClub
{
    /**
     * Version.
     */
    const VERSION = 2.0;

    /**
     * XMLNS URL.
     */
    const XMLNS = 'https://xml.hotelclub.net/xmlws/services/v2/';

    /**
     * WSDL URL.
     *
     * @var string
     */
    protected $_wsdl = null;

    /**
     * Config.
     *
     * @var HotelClub_Config
     */
    public $config = array();

    /**
     * Call
     *
     * @param  string $name The name of the method being called.
     * @param  string $arguments The arguments to pass to the method.
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $name = ucfirst($name);
        $arguments[0]['Version'] = self::VERSION;
        switch ($name) {
            case 'HotelAvailabilityRequest':
            case 'HotelSearchRequest':
                $this->_wsdl = $this->config['protocol'] . '://xml.hotelclub.net/XMLWS_V2/XmlWsdl/V2.00/Availability.asmx?WSDL';
                break;
            case 'CityListRequest':
            case 'CountryListRequest':
            case 'HotelImageRequest':
            case 'HotelInfoRequest':
            case 'HotelListRequest':
            case 'HotelSuburbListRequest':
            case 'MonthlyFavouriteCityListRequest':
            case 'TopCityListRequest':
                $this->_wsdl = $this->config['protocol'] . '://xml.hotelclub.net/XMLWS_V2/XmlWsdl/V2.00/Content.asmx?WSDL';
                break;
            case 'BookingStatusRequest':
            case 'HotelBookingRequest':
            case 'HotelRateRuleRequest':
                $this->_wsdl = $this->config['protocol'] . '://xml.hotelclub.net/XMLWS_V2/XmlWsdl/V2.00/Reservation.asmx?WSDL';
                break;
        }
        try {
            $soapClient = $this->_getSoapClient();
            $soapHeader = $this->_getSoapHeader();
            $response = $soapClient->__soapCall($name, $arguments, null, $soapHeader);
            return $response;
        }
        catch (Exception $e) {
            echo $e->faultstring;
            return false;
        }
    }

    /**
     * Construct
     *
     * @return void
     */
    public function __construct()
    {
        require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';
        $this->config = $config;
    }

    /**
     * Get Client IP
     *
     * @return string
     */
    protected function _getClientIp()
    {
        $clientIp = null;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $clientIp = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if (strlen($_SERVER['REMOTE_ADDR']) > 7) {
            $clientIp = $_SERVER['REMOTE_ADDR'];
        }
        return $clientIp;
    }

    /**
     * Get Soap Client
     *
     * @return SoapClient
     */
    protected function _getSoapClient()
    {
        return new SoapClient($this->_wsdl, array('features' => SOAP_SINGLE_ELEMENT_ARRAYS, 'uri' => self::XMLNS));
    }

    /**
     * Get Soap Header
     *
     * @return SoapHeader
     */
    protected function _getSoapHeader()
    {
        $clientIp = $this->_getClientIp();
        $header['AffiliateID'] = new SoapVar($this->config['AffiliateID'], XSD_INT, null, null, null, self::XMLNS);
        $header['Password'] = new SoapVar($this->config['Password'], XSD_STRING, null, null, null, self::XMLNS);
        if (!is_null($clientIp)) {
            $header['ClientIP'] = new SoapVar($clientIp, XSD_STRING, null, null, null, self::XMLNS);
        }
        return new SoapHeader(self::XMLNS, 'AuthenticationInfo', new SoapVar($header, SOAP_ENC_OBJECT));
    }
}