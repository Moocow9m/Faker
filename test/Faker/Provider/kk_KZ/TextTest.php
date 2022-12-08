<?php

namespace Faker\Test\Provider\kk_KZ;

use PHPUnit\Framework\TestCase;

final class TextTest extends TestCase
{
    private \ReflectionClass $textClass;

    function testItShouldAppendEndPunctToTheEndOfString()
    {
        $this->assertSame(
            'Арыстан баб кесенесі - көне Отырар.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Арыстан баб кесенесі - көне Отырар '])
        );

        $this->assertSame(
            'Арыстан баб кесенесі - көне Отырар.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Арыстан баб кесенесі - көне Отырар— '])
        );

        $this->assertSame(
            'Арыстан баб кесенесі - көне Отырар.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Арыстан баб кесенесі - көне Отырар,  '])
        );

        $this->assertSame(
            'Арыстан баб кесенесі - көне Отырар!.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Арыстан баб кесенесі - көне Отырар! '])
        );

        $this->assertSame(
            'Арыстан баб кесенесі - көне Отырар.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Арыстан баб кесенесі - көне Отырар: '])
        );

        $this->assertSame(
            'Арыстан баб кесенесі - көне Отырар.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['Арыстан баб кесенесі - көне Отырар; '])
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
        $this->textClass = new \ReflectionClass(\Faker\Provider\kk_KZ\Text::class);
    }
}
