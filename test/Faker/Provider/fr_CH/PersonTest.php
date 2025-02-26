<?php

namespace Faker\Test\Provider\fr_CH;

use Faker\Calculator\Ean;
use Faker\Generator;
use Faker\Provider\fr_CH\Person;
use PHPUnit\Framework\TestCase;

final class PersonTest extends TestCase
{
    private Generator $faker;

    public function testAvs13Number()
    {
        $avs = $this->faker->avs13;
        $this->assertMatchesRegularExpression('/^756\.([0-9]{4})\.([0-9]{4})\.([0-9]{2})$/', $avs);
        $this->assertTrue(Ean::isValid(str_replace('.', '', (string) $avs)));
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $this->faker = $faker;
    }
}
