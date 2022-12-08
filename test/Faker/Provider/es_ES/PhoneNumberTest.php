<?php

namespace Faker\Test\Provider\es_ES;

use Faker\Generator;
use Faker\Provider\es_ES\PhoneNumber;

final class PhoneNumberTest extends \PHPUnit_Framework_TestCase
{
    public function testMobileNumber()
    {
        self::assertNotEquals('', $this->faker->mobileNumber());
    }

    public function testTollFreeNumber()
    {
        self::assertEquals(11, strlen($this->faker->tollFreeNumber()));
    }

    protected function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new PhoneNumber($faker));
        $this->faker = $faker;
    }
}
