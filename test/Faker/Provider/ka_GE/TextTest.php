<?php

namespace Faker\Test\Provider\ka_GE;

use PHPUnit\Framework\TestCase;

final class TextTest extends TestCase
{
    private \ReflectionClass $textClass;

    function testItShouldAppendEndPunctToTheEndOfString()
    {
        $this->assertSame(
            'ჭეშმარიტია. ჩვენც ისე.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['ჭეშმარიტია. ჩვენც ისე '])
        );

        $this->assertSame(
            'ჭეშმარიტია. ჩვენც ისე.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['ჭეშმარიტია. ჩვენც ისე— '])
        );

        $this->assertSame(
            'ჭეშმარიტია. ჩვენც ისე.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['ჭეშმარიტია. ჩვენც ისე,  '])
        );

        $this->assertSame(
            'ჭეშმარიტია. ჩვენც ისე!.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['ჭეშმარიტია. ჩვენც ისე! '])
        );

        $this->assertSame(
            'ჭეშმარიტია. ჩვენც ისე.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['ჭეშმარიტია. ჩვენც ისე; '])
        );

        $this->assertSame(
            'ჭეშმარიტია. ჩვენც ისე.',
            $this->getMethod('appendEnd')->invokeArgs(null, ['ჭეშმარიტია. ჩვენც ისე: '])
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
