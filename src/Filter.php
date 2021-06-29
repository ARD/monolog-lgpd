<?php
declare (strict_types = 1);

namespace ARD\Monolog\FilterSensitive;

interface Filter
{
    public static function pattern(): string;
    public static function replace(): string;
}
