<?php

namespace Faker\Test\Provider\es_ES;

use Faker\Generator;
use Faker\Provider\es_ES\PhoneNumber;

final class PhoneNumberTest extends \PHPUnit\Framework\TestCase
{
    public function testMobileNumber()
    {
        self::assertNotEquals('', $this->faker->mobileNumber());
    }

    public function testTollFreeNumber()
    {
        self::assertEquals(11, strlen((string) $this->faker->tollFreeNumber()));
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new PhoneNumber($faker));
        $this->faker = $faker;
    }
}
