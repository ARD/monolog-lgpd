<?php
declare (strict_types = 1);
use ARD\Monolog\FilterSensitive\Filter;
use ARD\Monolog\FilterSensitive\FilterSensitiveProcessor;
use PHPUnit\Framework\TestCase;

final class CustomFilterTest extends TestCase
{
    public function testCustomFilterInMessage(): void
    {
        $processor = new FilterSensitiveProcessor();

        $processor->addCustomFilter(
            new class implements Filter
            {
                public static function pattern(): string
                {
                    return '/([0-9]{3})\.([0-9]{3})/';
                }

                public static function replace(): string
                {
                    return '$1.***';
                }
            }
        );

        $record = $processor(['message' => 'Log my ID 123.456']);

        $this->assertSame(['message' => 'Log my ID 123.***'], $record);
    }
}
