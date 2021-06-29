<?php
declare (strict_types = 1);

namespace ARD\Monolog\FilterSensitive;

class FilterCPF implements Filter
{
    public static function pattern(): string
    {
        return "/([0-9]{3})\.([0-9]{3})\.([0-9]{3})\-([0-9]{2})/";
    }
    public static function replace(): string
    {
        return '***.***.$3-$4';
    }
}
