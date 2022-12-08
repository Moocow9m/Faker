<?php

namespace Faker\Test\Provider\it_CH;

use Faker\Calculator\Ean;
use Faker\Generator;
use Faker\Provider\it_CH\Person;
use PHPUnit\Framework\TestCase;

final class PersonTest extends TestCase
{
    private $faker;

    public function testAvs13Number()
    {
        $avs = $this->faker->avs13;
        $this->assertRegExp('/^756\.([0-9]{4})\.([0-9]{4})\.([0-9]{2})$/', $avs);
        $this->assertTrue(Ean::isValid(str_replace('.', '', $avs)));
    }

    protected function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $this->faker = $faker;
    }
}