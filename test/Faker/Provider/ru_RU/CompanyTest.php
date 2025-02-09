<?php

namespace Faker\Test\Provider\ru_RU;

use Faker\Generator;
use Faker\Provider\ru_RU\Company;
use PHPUnit\Framework\TestCase;

final class CompanyTest extends TestCase
{
    private Generator $faker;

    public function testINN()
    {
        $this->assertMatchesRegularExpression('/^[0-9]{10}$/', $this->faker->inn);
        $this->assertEquals("77", substr((string) $this->faker->inn("77"), 0, 2));
        $this->assertEquals("02", substr((string) $this->faker->inn(2), 0, 2));
    }

    public function testKPP()
    {
        $this->assertMatchesRegularExpression('/^[0-9]{9}$/', $this->faker->kpp);
        $this->assertEquals("01001", substr((string) $this->faker->kpp, -5, 5));
        $inn = $this->faker->inn;
        $this->assertEquals(substr((string) $inn, 0, 4), substr((string) $this->faker->kpp($inn), 0, 4));
    }

    public function testCatchPhrase()
    {
        $phrase = $this->faker->catchPhrase;
        $this->assertNotNull($phrase);
        $this->assertGreaterThanOrEqual(
            3,
            count(explode(' ', $this->faker->catchPhrase)),
            "'$phrase' - should be contain 3 word"
        );
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }
}
