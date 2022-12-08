<?php

namespace Faker\Test\Provider\ru_RU;

use Faker\Generator;
use Faker\Provider\ru_RU\Person;
use PHPUnit\Framework\TestCase;

final class PersonTest extends TestCase
{
    private Generator $faker;

    public function testLastNameFemale()
    {
        $this->assertEquals("а", substr((string) $this->faker->lastName('female'), -2, 2));
    }

    public function testLastNameMale()
    {
        $this->assertNotEquals("а", substr((string) $this->faker->lastName('male'), -2, 2));
    }

    public function testLastNameRandom()
    {
        $this->assertNotNull($this->faker->lastName());
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $this->faker = $faker;
    }
}
