<?php

namespace Faker\Test\Provider\ng_NG;

use Faker\Generator;
use Faker\Provider\en_NG\Internet;
use Faker\Provider\en_NG\Person;
use PHPUnit\Framework\TestCase;

final class InternetTest extends TestCase
{

    private \Faker\Generator $faker;

    public function testEmailIsValid()
    {
        $email = $this->faker->email();
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
        $this->assertNotEmpty($email);
        $this->assertInternalType('string', $email);
    }

    protected function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Internet($faker));
        $this->faker = $faker;
    }
}
