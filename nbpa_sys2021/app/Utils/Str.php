<?php

/**
 * Utility class of string.
 *
 * @version SVN: $Id: Str.php 113 2015-05-20 08:23:04Z morita $
 */
namespace Utils;

class Str
{
    /**
     * Convert to CamelCase string.
     *
     * @param string $str
     * @param bool   $ucfirst
     *
     * @return string
     */
    public static function camelize($str, $ucfirst = true)
    {
        $elements    = explode('_', $str);
        $capitalized = [];
        if (!$ucfirst) {
            $capitalized[] = array_shift($elements);
        }
        while (!empty($elements)) {
            $capitalized[] = ucfirst(array_shift($elements));
        }

        return implode('', $capitalized);
    }
}
