<?php

namespace Faker\Provider\ro_RO;

class PhoneNumber extends \Faker\Provider\PhoneNumber
{
    protected static $normalFormats = ['landline' => [
        '021#######',
        // Bucharest
        '023#######',
        '024#######',
        '025#######',
        '026#######',
        '027#######',
        // non-geographic
        '031#######',
        // Bucharest
        '033#######',
        '034#######',
        '035#######',
        '036#######',
        '037#######',
    ], 'mobile' => ['07########']];

    protected static $specialFormats = ['toll-free' => [
        '0800######',
        '0801######',
        // shared-cost numbers
        '0802######',
        // personal numbering
        '0806######',
        // virtual cards
        '0807######',
        // pre-paid cards
        '0870######',
    ], 'premium-rate' => [
        '0900######',
        '0903######',
        // financial information
        '0906######',
    ]];

    public static function tollFreePhoneNumber()
    {
        $number = static::numerify(static::randomElement(static::$specialFormats['toll-free']));

        return $number;
    }

    public static function premiumRatePhoneNumber()
    {
        $number = static::numerify(static::randomElement(static::$specialFormats['premium-rate']));

        return $number;
    }

    /**
     * @link http://en.wikipedia.org/wiki/Telephone_numbers_in_Romania#Last_years
     */
    public function phoneNumber()
    {
        $type = static::randomElement(array_keys(static::$normalFormats));

        return static::numerify(static::randomElement(static::$normalFormats[$type]));
    }
}
