<?php

namespace Faker\Test\Provider;

use Faker\Calculator\Luhn;
use Faker\Generator;
use Faker\Provider\PhoneNumber;
use PHPUnit\Framework\TestCase;

final class PhoneNumberTest extends TestCase
{

    private \Faker\Generator $faker;

    public function testPhoneNumberFormat()
    {
        $number = $this->faker->e164PhoneNumber();
        $this->assertRegExp('/^\+[0-9]{11,}$/', $number);
    }

    public function testImeiReturnsValidNumber()
    {
        $imei = $this->faker->imei();
        $this->assertTrue(Luhn::isValid($imei));
    }

    protected function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new PhoneNumber($faker));
        $this->faker = $faker;
    }
}
