<?php
declare (strict_types = 1);
use ARD\Monolog\FilterSensitive\Filter;
use ARD\Monolog\FilterSensitive\FilterEmail;
use ARD\Monolog\FilterSensitive\FilterIP;
use ARD\Monolog\FilterSensitive\FilterSensitiveProcessor;
use PHPUnit\Framework\TestCase;

final class FilterSensitiveProcessorTest extends TestCase
{
    public function testAllFilters(): void
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

        $record = [
            'message' => 'Logging user info with ID 123.456',
            'context' => [
                'CPF' => '111.111.111-11',
                'CNPJ' => '11.111.111/0001-00',
                'email' => 'user@domain.com',
                'IP' => '10.0.0.10'
            ]
        ];

        $filtered = $processor($record);

        $expected = [
            'message' => 'Logging user info with ID 123.***',
            'context' => [
                'CPF' => '***.***.111-11',
                'CNPJ' => '**.***.111/0001-00',
                'email' => '****@domain.com',
                'IP' => '10.*.*.10'
            ]
        ];

        $this->assertSame($expected, $filtered);
    }

    public function testRemoveEmailFilter() {
        $processor = new FilterSensitiveProcessor();
        $processor->removeFilter(FilterEmail::class);

        $record = [
            'message' => 'Logging user info',
            'context' => [
                'CPF' => '111.111.111-11',
                'CNPJ' => '11.111.111/0001-00',
                'email' => 'user@domain.com',
                'IP' => '10.0.0.10'
            ]
        ];

        $filtered = $processor($record);

        $expected = [
            'message' => 'Logging user info',
            'context' => [
                'CPF' => '***.***.111-11',
                'CNPJ' => '**.***.111/0001-00',
                'email' => 'user@domain.com',
                'IP' => '10.*.*.10'
            ]
        ];

        $this->assertSame($expected, $filtered);
    }

    public function testRemoveEmailAndIPFilter() {
        $processor = new FilterSensitiveProcessor();
        $processor->removeFilter(FilterEmail::class, FilterIP::class);

        $record = [
            'message' => 'Logging user info',
            'context' => [
                'CPF' => '111.111.111-11',
                'CNPJ' => '11.111.111/0001-00',
                'email' => 'user@domain.com',
                'IP' => '10.0.0.10'
            ]
        ];

        $filtered = $processor($record);

        $expected = [
            'message' => 'Logging user info',
            'context' => [
                'CPF' => '***.***.111-11',
                'CNPJ' => '**.***.111/0001-00',
                'email' => 'user@domain.com',
                'IP' => '10.0.0.10'
            ]
        ];

        $this->assertSame($expected, $filtered);
    }
}
