# monolog-lgpd

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/e332d0790b9244abb13a440fc5e3e298)](https://app.codacy.com/gh/ARD/monolog-lgpd?utm_source=github.com&utm_medium=referral&utm_content=ARD/monolog-lgpd&utm_campaign=Badge_Grade_Settings)

a simple monolog processor for filtering sensitive data

## installation
```
composer require ard/monolog-lgpd
```

## example 1 - with email filter
```php
use ARD\Monolog\FilterSensitive\FilterSensitiveProcessor;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('./log.log', Logger::WARNING));

$processor = new FilterSensitiveProcessor();

$log->pushProcessor($processor);

// add records to the log
$log->warning('The user email is user@domain.com'); //The user email is ****@domain.com
```

## example 2 - with all filters
```php
use ARD\Monolog\FilterSensitive\FilterSensitiveProcessor;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('./log.log', Logger::WARNING));

$processor = new FilterSensitiveProcessor();

$log->pushProcessor($processor);

// add records to the log
$log->warning('The user email is user@domain.com',[
'cpf' => '111.111.111-11',
'cnpj' => '11.111.111/0001-00',
'ip' => '10.0.0.10'
]); 
```

## example 3 - with custom filter
```php
use ARD\Monolog\FilterSensitive\Filter;
use ARD\Monolog\FilterSensitive\FilterSensitiveProcessor;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('./log.log', Logger::WARNING));

$processor = new FilterSensitiveProcessor();

$processor->addCustomFilter(
    new class implements Filter
    {
        public static function pattern(): string
        {
            return '/(^[0-9]{3})\.([0-9]{3})$/';
        }

        public static function replace(): string
        {
            return '$1.***';
        }
    }
);

$log->pushProcessor($processor);

// add records to the log
$log->warning('The user id 123.456'); 
```

## example 4 - remove filter
```php
use ARD\Monolog\FilterSensitive\FilterIP;
use ARD\Monolog\FilterSensitive\FilterSensitiveProcessor;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('./log.log', Logger::WARNING));

$processor = new FilterSensitiveProcessor();

$processor->removeFilter(FilterIP::class);

$log->pushProcessor($processor);

// add records to the log
$log->warning('User email@domain.com and IP 127.0.0.1'); 
```
