<?php

namespace App\Http\Middleware;

use Vinkla\Hashids\Facades\Hashids;

class ID
{
    /**
     * Encodes an ID value to its hash value
     *
     * @param int    $value
     * @param string $config
     *
     * @return string
     */
    public static function encode($value, $config = 'main')
    {
        return Hashids::connection($config)
            ->encode($value);
    }

    /**
     * Decodes an ID value to the numeric string value
     *
     * @param string $value
     * @param string $config
     *
     * @return int
     */
    public static function decode($value, $config = 'main')
    {
        $id = Hashids::connection($config)
            ->decode($value);

        return isset($id[0]) ? $id[0] : 0;
    }
}
