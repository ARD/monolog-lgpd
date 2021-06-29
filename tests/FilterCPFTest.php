<?php
declare (strict_types = 1);
use ARD\Monolog\FilterSensitive\FilterSensitiveProcessor;
use PHPUnit\Framework\TestCase;

final class FilterCPFTest extends TestCase
{
    public function testCpfFilterInMessage(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor(['message' => 'cpf 111.222.333-00']);

        $this->assertSame([
            'message' => 'cpf ***.***.333-00',
        ], $record);
    }

    public function testCpfFilterInContext(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor([
            'message' => 'Log',
            'context' => [
                'cpf' => '111.111.111-11',
            ],
        ]);

        $this->assertSame([
            'message' => 'Log',
            'context' => [
                'cpf' => '***.***.111-11',
            ],
        ], $record);
    }

    public function testCpfFilterInContextAndMessage(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor([
            'message' => 'the user CPF is 111.111.111-11',
            'context' => [
                'cpf' => '111.111.111-11',
            ],
        ]);

        $this->assertSame([
            'message' => 'the user CPF is ***.***.111-11',
            'context' => [
                'cpf' => '***.***.111-11',
            ],
        ], $record);
    }
}
