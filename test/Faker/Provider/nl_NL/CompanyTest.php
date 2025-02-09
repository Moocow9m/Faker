<?php

namespace Faker\Test\Provider\nl_NL;

use Faker\Generator;
use Faker\Provider\nl_NL\Company;
use PHPUnit\Framework\TestCase;

final class CompanyTest extends TestCase
{
    private Generator $faker;

    public function testGenerateValidVatNumber()
    {
        $vatNo = $this->faker->vat();

        $this->assertEquals(14, strlen((string) $vatNo));
        $this->assertMatchesRegularExpression('/^NL[0-9]{9}B[0-9]{2}$/', $vatNo);
    }

    public function testGenerateValidBtwNumberAlias()
    {
        $btwNo = $this->faker->btw();

        $this->assertEquals(14, strlen((string) $btwNo));
        $this->assertMatchesRegularExpression('/^NL[0-9]{9}B[0-9]{2}$/', $btwNo);
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }
}
