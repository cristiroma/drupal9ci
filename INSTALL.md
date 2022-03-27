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
