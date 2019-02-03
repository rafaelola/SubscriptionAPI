<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiPhoneValidator extends Controller
{
    /** LibPhoneNumber
     *
     * @param $code string
     *
     * @return int the country calling code for the region denoted by regionCode
     */
    public function getCountryCode($code) : int
    {
        return \libphonenumber\PhoneNumberUtil::getInstance()->getCountryCodeForRegion($code);
    }
    
    
    /**
     * @param $val string
     *
     * @return \stdClass
     * @throws \ReflectionException
     */
    public function getPhoneNumber_details($val): \stdClass
    {
        $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $resp = new \stdClass();
        $resp->country_code = '';
        $resp->country_name = '';
        $resp->number_carrier = '';
        $resp->number_formatted = '';
        $resp->number_type = '';
        $resp->valid = false;
        try {
            $number = $phoneNumberUtil->parse($val, null);
        } catch (\libphonenumber\NumberParseException $e) {
            return $resp;
        }
        if ($resp->valid = $phoneNumberUtil->isValidNumber($number)) {
            $resp->country_code = $phoneNumberUtil->getRegionCodeForNumber($number);
            $resp->country_name = \libphonenumber\geocoding\PhoneNumberOfflineGeocoder::getInstance()->getDescriptionForNumber($number,
                'en-GB');
            $resp->number_type = $this->_getPhoneNumberTypeName($phoneNumberUtil->getNumberType($number));
            $resp->number_carrier = \libphonenumber\PhoneNumberToCarrierMapper::getInstance()->getNameForValidNumber($number,
                'en-GB');
            $resp->number_formatted = $phoneNumberUtil->formatInOriginalFormat($number, 'GB');
        }
        
        return $resp;
        
    }
    
    /**
     * @param $num integer
     *
     * @return string
     * @throws \ReflectionException
     */
    private function _getPhoneNumberTypeName($num)
    {
        $oClass = new \ReflectionClass ('\libphonenumber\PhoneNumberType::class');
        $constants = $oClass->getConstants();
        foreach ($constants as $name => $value) {
            if ($value == $num) {
                return $name;
                break;
            }
        }
        
    }
}
