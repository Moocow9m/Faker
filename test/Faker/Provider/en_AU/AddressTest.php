<?php

namespace Faker\Provider\en_AU;

use Faker\Generator;
use PHPUnit\Framework\TestCase;

final class AddressTest extends TestCase
{

    /**
     * @var Faker\Generator
     */
    private $faker;

    public function testCityPrefix()
    {
        $cityPrefix = $this->faker->cityPrefix();
        $this->assertNotEmpty($cityPrefix);
        $this->assertIsString($cityPrefix);
        $this->assertRegExp('/[A-Z][a-z]+/', $cityPrefix);
    }

    public function testStreetSuffix()
    {
        $streetSuffix = $this->faker->streetSuffix();
        $this->assertNotEmpty($streetSuffix);
        $this->assertIsString($streetSuffix);
        $this->assertRegExp('/[A-Z][a-z]+/', $streetSuffix);
    }

    public function testState()
    {
        $state = $this->faker->state();
        $this->assertNotEmpty($state);
        $this->assertIsString($state);
        $this->assertRegExp('/[A-Z][a-z]+/', $state);
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Address($faker));
        $this->faker = $faker;
    }
}

?>
