<?php

namespace Faker\Test\Provider\es_ES;

use Faker\Generator;
use Faker\Provider\es_ES\Text;
use PHPUnit\Framework\TestCase;

final class TextTest extends TestCase
{
    private Generator $faker;

    public function testText()
    {
        $this->assertNotSame('', $this->faker->realtext(200, 2));
    }

    protected function setUp(): void
    {
        $faker = new Generator();
        $faker->addProvider(new Text($faker));
        $this->faker = $faker;
    }
}
