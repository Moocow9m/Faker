<?php

namespace Faker\Test\Provider\fr_FR;

use Faker\Generator;
use Faker\Provider\fr_FR\Address;
use PHPUnit\Framework\TestCase;

final class AddressTest extends TestCase
{

    /**
     * @var Faker\Generator
     */
    private $faker;

    public function testSecondaryAddress()
    {
        $secondaryAdress = $this->faker->secondaryAddress();
        $this->assertNotEmpty($secondaryAdress);
        $this->assertIsString($secondaryAdress);
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Address($faker));
        $this->faker = $faker;
    }
}
