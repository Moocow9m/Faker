<?php

namespace Faker\Guesser;

use Faker\Provider\Base;

class Name
{
    protected $generator;

    /**
     * @param \Faker\Generator $generator
     */
    public function __construct(\Faker\Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param string $name
     * @param int|null $size Length of field, if known
     * @return callable
     */
    public function guessFormat($name, $size = null)
    {
        $name = Base::toLower($name);
        $generator = $this->generator;
        if (preg_match('/^is[_A-Z]/', $name)) {
            return fn() => $generator->boolean;
        }
        if (preg_match('/(_a|A)t$/', $name)) {
            return fn() => $generator->dateTime;
        }
        switch (str_replace('_', '', $name)) {
            case 'firstname':
                return fn() => $generator->firstName;
            case 'lastname':
                return fn() => $generator->lastName;
            case 'username':
            case 'login':
                return fn() => $generator->userName;
            case 'email':
            case 'emailaddress':
                return fn() => $generator->email;
            case 'phonenumber':
            case 'phone':
            case 'telephone':
            case 'telnumber':
                return fn() => $generator->phoneNumber;
            case 'address':
                return fn() => $generator->address;
            case 'city':
            case 'town':
                return fn() => $generator->city;
            case 'streetaddress':
                return fn() => $generator->streetAddress;
            case 'postcode':
            case 'zipcode':
                return fn() => $generator->postcode;
            case 'state':
                return fn() => $generator->state;
            case 'county':
                if ($this->generator->locale == 'en_US') {
                    return fn() => sprintf('%s County', $generator->city);
                }

                return fn() => $generator->state;
            case 'country':
                switch ($size) {
                    case 2:
                        return fn() => $generator->countryCode;
                    case 3:
                        return fn() => $generator->countryISOAlpha3;
                    case 5:
                    case 6:
                        return fn() => $generator->locale;
                    default:
                        return fn() => $generator->country;
                }
                break;
            case 'locale':
                return fn() => $generator->locale;
            case 'currency':
            case 'currencycode':
                return fn() => $generator->currencyCode;
            case 'url':
            case 'website':
                return fn() => $generator->url;
            case 'company':
            case 'companyname':
            case 'employer':
                return fn() => $generator->company;
            case 'title':
                if ($size !== null && $size <= 10) {
                    return fn() => $generator->title;
                }

                return fn() => $generator->sentence;
            case 'body':
            case 'summary':
            case 'article':
            case 'description':
                return fn() => $generator->text;
        }
    }
}
