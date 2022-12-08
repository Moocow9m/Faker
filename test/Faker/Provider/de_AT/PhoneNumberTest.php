<?php

namespace Faker\Test\Provider\de_AT;

use Faker\Generator;
use Faker\Provider\de_AT\PhoneNumber;
use PHPUnit\Framework\TestCase;

final class PhoneNumberTest extends TestCase
{

    private \Faker\Generator $faker;

    public function testPhoneNumberFormat()
    {
        $number = $this->faker->phoneNumber;
        $this->assertRegExp('/^06\d{2} \d{7}|\+43 \d{4} \d{4}(-\d{2})?$/', $number);
    }

    protected function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new PhoneNumber($faker));
        $this->faker = $faker;
    }
}
