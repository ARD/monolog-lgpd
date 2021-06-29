<?php
declare (strict_types = 1);
use ARD\Monolog\FilterSensitive\FilterSensitiveProcessor;
use PHPUnit\Framework\TestCase;

final class FilterIPTest extends TestCase
{
    public function testIPFilterInMessage(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor(['message' => 'IP 127.0.0.1']);

        $this->assertSame([
            'message' => 'IP 127.*.*.1',
        ], $record);
    }

    public function testIPFilterInContext(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor([
            'message' => 'Log',
            'context' => [
                'IP' => '192.168.0.1',
            ],
        ]);

        $this->assertSame([
            'message' => 'Log',
            'context' => [
                'IP' => '192.*.*.1',
            ],
        ], $record);
    }

    public function testIPFilterInContextAndMessage(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor([
            'message' => 'the user IP is 10.0.10.1',
            'context' => [
                'IP' => '10.0.10.1',
            ],
        ]);

        $this->assertSame([
            'message' => 'the user IP is 10.*.*.1',
            'context' => [
                'IP' => '10.*.*.1',
            ],
        ], $record);
    }
}
