<?php

namespace Faker\Test\Provider\en_US;

use Faker\Generator;
use Faker\Provider\en_US\Company;
use PHPUnit\Framework\TestCase;

final class CompanyTest extends TestCase
{
    private Generator $faker;

    /**
     * @link https://stackoverflow.com/questions/4242433/regex-for-ein-number-and-ssn-number-format-in-jquery/35471665#35471665
     */
    public function testEin()
    {
        $number = $this->faker->ein;

        // should be in the format ##-#######, with a valid prefix
        $this->assertMatchesRegularExpression('/^(0[1-6]||1[0-6]|2[0-7]|[35]\d|[468][0-8]|7[1-7]|9[0-58-9])-\d{7}$/', $number);
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }
}
