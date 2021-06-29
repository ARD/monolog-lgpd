<?php
declare (strict_types = 1);

namespace ARD\Monolog\FilterSensitive;

class FilterIP implements Filter
{
    /**
     * Credit: http://www.regular-expressions.info/ip.html
     */
    public static function pattern(): string
    {
        return "/(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/";
    }

    public static function replace(): string
    {
        return '$1.*.*.$4';
    }
}