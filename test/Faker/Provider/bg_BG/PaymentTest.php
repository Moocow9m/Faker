<?php

namespace Faker\Test\Provider\bg_BG;

use Faker\Generator;
use Faker\Provider\bg_BG\Payment;
use PHPUnit\Framework\TestCase;

final class PaymentTest extends TestCase
{

    private \Faker\Generator $faker;

    public function testVatIsValid()
    {
        $vat = $this->faker->vat();
        $unspacedVat = $this->faker->vat(false);
        $this->assertMatchesRegularExpression('/^(BG \d{9,10})$/', $vat);
        $this->assertMatchesRegularExpression('/^(BG\d{9,10})$/', $unspacedVat);
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Payment($faker));
        $this->faker = $faker;
    }
}
