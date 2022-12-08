<?php

namespace Faker;

/**
 * This generator returns a default value for all called properties
 * and methods. It works with Faker\Generator\Base->optional().
 */
class DefaultGenerator
{
    public function __construct(protected $default = null)
    {
    }

    /**
     * @param string $attribute
     *
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->default;
    }

    /**
     * @param string $method
     * @param array $attributes
     *
     * @return mixed
     */
    public function __call($method, $attributes)
    {
        return $this->default;
    }
}
