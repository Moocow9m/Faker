<?php

namespace Faker\Test\Provider\it_CH;

use Faker\Generator;
use Faker\Provider\it_CH\Company;
use Faker\Provider\it_CH\Internet;
use Faker\Provider\it_CH\Person;
use PHPUnit\Framework\TestCase;

final class InternetTest extends TestCase
{
    /**
     * @var Faker\Generator
     */
    private $faker;

    /**
     * @test
     */
    public function emailIsValid()
    {
        $email = $this->faker->email();
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Person($faker));
        $faker->addProvider(new Internet($faker));
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }
}
