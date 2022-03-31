# How to use this repository

This repository is meant as a demo for CI/CD workflows and should not be used by cloning it. Here are few scenarios:

## Quality assurance

Copy [.github/workflows/test.yml](.github/workflows/test.yml) file to your repository, define the event to run (push, pull-request etc.). This will run Drupal related quality checks including running the project's tests.

The container is a wrapper around typical tools and you can also run these checks locally using the following commands:

```bash
composer require --dev drupal/coder drupal/core-dev overtrue/phplint phpspec/prophecy-phpunit

./vendor/bin/phplint --no-cache --no-progress --extensions=php,module,inc,install,test,theme, ./web/themes/custom/ ./web/modules/custom/
./vendor/bin/phpmd  ./web/modules/custom/ xml phpmd.xml
./vendor/bin/phpmd  ./web/themes/custom/ xml phpmd.xml
./vendor/bin/phpcs --standard=Drupal,DrupalPractice --extensions=php,module,inc,install,test,profile,theme,css,info,txt,md,yml ./web/modules/custom/ ./web/themes/custom/
```

1. See [phpmd.xml](phpmd.xml) in this repository.
2. Automatically fix coding issues

```bash
./vendor/bin/phpcbf --standard=Drupal,DrupalPractice web/modules/custom/ web/themes/custom/
```

## Deployments

Use [.github/workflows/deploy-test.yml](.github/workflows/deploy-test.yml) and [.github/workflows/deploy-prod.yml](.github/workflows/deploy-prod.yml) to enable deployments in your project.


## Bibliography

- https://www.drupal.org/docs/contributed-modules/code-review-module/installing-coder-sniffer
- https://www.drupal.org/docs/contributed-modules/code-review-module/php-codesniffer-command-line-usage
- https://www.drupal.org/drupalorg/docs/drupal-ci/using-coderphpcs-in-drupalci
