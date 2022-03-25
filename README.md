# Local development

## Installing site from config without SQL dump

You can install the website without using an existing SQL dump using the following steps:

1. Create a new file `web/sites/default/settings.local.php` populated with the database connection information

```php
  $databases['default']['default'] = array (
    'database' => 'drupal',
    'username' => 'root',
    'password' => 'root',
    'prefix' => '',
    'host' => 'localhost',
    'port' => '',
    'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
    'driver' => 'mysql',
);

```

2. Install the website using Drush


```bash
./vendor/bin/drush site:install --existing-config -y
```


# Quality assurance


```
https://www.drupal.org/docs/contributed-modules/code-review-module/installing-coder-sniffer
```

```bash
./vendor/bin/phpcs --standard=Drupal,DrupalPractice --extensions=php,module,inc,install,test,profile,theme,css,info,txt,md,yml web/modules/custom/ web/themes/custom/
```


# Testing

## How to see which tests to run?

1. List suites

```bash
./vendor/bin/phpunit web/modules/contrib/ --list-suites

Available test suite(s):
 - unit
 - kernel
 - functional
 - nonfunctional
```

2. List groups

```bash
./vendor/bin/phpunit web/modules/contrib/pathauto/ --list-groups
Available test group(s):
 - pathauto
```


## How to run tests?

All tests below assume there's an `phpunit.xml` file in the project directory. You can copy `example.phpunit.xml` (derived from Drupal's core provided file) to `phpunit.xml`.

Bibliography:

- https://www.drupal.org/docs/automated-testing/phpunit-in-drupal/running-phpunit-tests


1. Run a specific suite

```bash
./vendor/bin/phpunit web/modules/contrib/pathauto/ --testsuite=unit


PHPUnit 9.5.19 #StandWithUkraine
.................SSSSS..........................                  48 / 48 (100%)

Time: 02:13.893, Memory: 18.00 MB
```

2. Run a specific test group

```bash
./vendor/bin/phpunit web/modules/contrib/pathauto/ --group=pathauto

.................SSSSS..........................                  48 / 48 (100%)

Time: 02:13.211, Memory: 16.00 MB
```

3. Run all tests from a specific module

```bash
./vendor/bin/phpunit web/modules/contrib/pathauto/

Testing /home/cristiroma/Work/drupal9ci/web/modules/contrib/pathauto
.................SSSSS..........................                  48 / 48 (100%)

Time: 02:13.968, Memory: 18.00 MB
```

4. Run a specific test class

```bash
./vendor/bin/phpunit web/modules/contrib/pathauto/tests/src/Unit/VerboseMessengerTest.php

Testing Drupal\Tests\pathauto\Unit\VerboseMessengerTest
..                                                                  2 / 2 (100%)

Time: 00:00.019, Memory: 10.00 MB

OK (2 tests, 4 assertions)
```

5. Run a specific test from class

```bash
./vendor/bin/phpunit web/modules/contrib/pathauto/tests/src/Unit/VerboseMessengerTest.php --filter=testAddMessage

Testing Drupal\Tests\pathauto\Unit\VerboseMessengerTest
.                                                                   1 / 1 (100%)

Time: 00:00.020, Memory: 12.00 MB

OK (1 test, 2 assertions)
```
