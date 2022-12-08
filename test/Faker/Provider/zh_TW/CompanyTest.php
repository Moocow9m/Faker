<?php

namespace Faker\Test\Provider\zh_TW;

use Faker\Generator;
use Faker\Provider\zh_TW\Company;
use PHPUnit\Framework\TestCase;

final class CompanyTest extends TestCase
{
    private \Faker\Generator $faker;

    public function testVAT()
    {
        $this->assertEquals(8, floor(log10($this->faker->VAT) + 1));
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }
}
