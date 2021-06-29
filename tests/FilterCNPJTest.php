<?php
declare (strict_types = 1);
use ARD\Monolog\FilterSensitive\FilterSensitiveProcessor;
use PHPUnit\Framework\TestCase;

final class FilterCNPJTest extends TestCase
{
    public function testCnpjFilterInMessage(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor(['message' => 'CNPJ 00.111.222/0001-00']);

        $this->assertSame([
            'message' => 'CNPJ **.***.222/0001-00',
        ], $record);
    }

    public function testCnpjFilterInContext(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor([
            'message' => 'Log',
            'context' => [
                'CNPJ' => '00.111.222/0001-00',
            ],
        ]);

        $this->assertSame([
            'message' => 'Log',
            'context' => [
                'CNPJ' => '**.***.222/0001-00',
            ],
        ], $record);
    }

    public function testCnpjFilterInContextAndMessage(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor([
            'message' => 'The company CNPJ is 00.111.222/0001-00',
            'context' => [
                'CNPJ' => '00.111.222/0001-00',
            ],
        ]);

        $this->assertSame([
            'message' => 'The company CNPJ is **.***.222/0001-00',
            'context' => [
                'CNPJ' => '**.***.222/0001-00',
            ],
        ], $record);
    }
}
