<?php

namespace Faker\Test\Provider\ko_KR;

use PHPUnit\Framework\TestCase;

final class TextTest extends TestCase
{
    private $textClass;

    function testItShouldAppendEndPunctToTheEndOfString()
    {
        $this->assertSame(
            '최석(崔晳)으로부터 최후의 편지가.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['최석(崔晳)으로부터 최후의 편지가 '])
        );

        $this->assertSame(
            '최석(崔晳)으로부터 최후의 편지가.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['최석(崔晳)으로부터 최후의 편지가—'])
        );

        $this->assertSame(
            '최석(崔晳)으로부터 최후의 편지가.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['최석(崔晳)으로부터 최후의 편지가,'])
        );

        $this->assertSame(
            '최석(崔晳)으로부터 최후의 편지가!.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['최석(崔晳)으로부터 최후의 편지가! '])
        );

        $this->assertSame(
            '최석(崔晳)으로부터 최후의 편지가.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['최석(崔晳)으로부터 최후의 편지가: '])
        );

        $this->assertSame(
            '최석(崔晳)으로부터 최후의 편지가.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['최석(崔晳)으로부터 최후의 편지가; '])
        );
    }

    protected function getMethod($name)
    {
        $method = $this->textClass->getMethod($name);

        $method->setAccessible(true);

        return $method;
    }

    protected function setUp()
    {
        $this->textClass = new \ReflectionClass(\Faker\Provider\el_GR\Text::class);
    }
}
