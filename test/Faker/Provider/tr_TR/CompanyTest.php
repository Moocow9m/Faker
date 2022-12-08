<?php

namespace Faker\Test\Provider\tr_TR;

use Faker\Generator;
use Faker\Provider\tr_TR\Company;
use PHPUnit\Framework\TestCase;

final class CompanyTest extends TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function testCompany()
    {
        $company = $this->faker->companyField;
        $this->assertNotNull($company);
    }

    protected function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }
}
