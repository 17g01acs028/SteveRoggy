<?php

if (! function_exists('id'))
{
    /**
     * Transforms ID value
     *
     * @param int|string $value
     * @param string     $config
     *
     * @return int|string
     */
    function id($value, $config = 'main')
    {
        if (is_numeric($value))
            return \App\Http\Middleware\ID::encode($value, $config);

        return \App\Http\Middleware\ID::decode($value, $config);
    }
}
