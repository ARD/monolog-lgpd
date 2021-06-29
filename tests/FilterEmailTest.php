<?php
declare (strict_types = 1);
use ARD\Monolog\FilterSensitive\FilterSensitiveProcessor;
use PHPUnit\Framework\TestCase;

final class FilterEmailTest extends TestCase
{
    public function testEmailFilterInMessage(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor(['message' => 'email user@domain.tk']);

        $this->assertSame([
            'message' => 'email ****@domain.tk',
        ], $record);
    }

    public function testEmailFilterInContext(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor([
            'message' => 'Log',
            'context' => [
                'email' => 'user@domain-xpto.br',
            ],
        ]);

        $this->assertSame([
            'message' => 'Log',
            'context' => [
                'email' => '****@domain-xpto.br',
            ],
        ], $record);
    }

    public function testEmailFilterInContextAndMessage(): void
    {
        $processor = new FilterSensitiveProcessor();
        $record = $processor([
            'message' => 'the user email is user@domain.com',
            'context' => [
                'email' => 'user@domain.com',
            ],
        ]);

        $this->assertSame([
            'message' => 'the user email is ****@domain.com',
            'context' => [
                'email' => '****@domain.com',
            ],
        ], $record);
    }
}
