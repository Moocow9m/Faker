<?php

namespace Faker\Test\Provider\en_ZA;

use Faker\Generator;
use Faker\Provider\en_ZA\Company;
use PHPUnit\Framework\TestCase;

final class CompanyTest extends TestCase
{
    private Generator $faker;

    public function testGenerateValidCompanyNumber()
    {
        $companyRegNo = $this->faker->companyNumber();

        $this->assertEquals(14, strlen((string) $companyRegNo));
        $this->assertMatchesRegularExpression('#^\d{4}/\d{6}/\d{2}$#', $companyRegNo);
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }
}
