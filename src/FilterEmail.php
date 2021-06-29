<?php
declare (strict_types = 1);

namespace ARD\Monolog\FilterSensitive;

class FilterEmail implements Filter
{
    /**
     * Credit: https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
     *
     * @return string
     */
    public static function pattern(): string
    {
        return "/([a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*)@((?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)/";
    }
    public static function replace(): string
    {
        return '****@$2';
    }
}
