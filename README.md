# Database Populator for Codeception DB module 

[![Latest Stable Version](https://poser.pugx.org/vjik/codeception-db-populator/v/stable.png)](https://packagist.org/packages/vjik/codeception-db-populator)
[![Total Downloads](https://poser.pugx.org/vjik/codeception-db-populator/downloads.png)](https://packagist.org/packages/vjik/codeception-db-populator)
[![Build status](https://github.com/vjik/codeception-db-populator/workflows/build/badge.svg)](https://github.com/vjik/codeception-db-populator/actions?query=workflow%3Abuild)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fvjik%2Fcodeception-db-populator%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/vjik/codeception-db-populator/master)
[![static analysis](https://github.com/vjik/codeception-db-populator/workflows/static%20analysis/badge.svg)](https://github.com/vjik/codeception-db-populator/actions?query=workflow%3A%22static+analysis%22)

The package ...

## Requirements

- PHP 7.4 or higher.

## Installation

The package could be installed with [composer](https://getcomposer.org/download/):

```shell
composer require vjik/codeception-db-populator --dev --prefer-dist
```

## General usage

## Testing

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework with
[Infection Static Analysis Plugin](https://github.com/Roave/infection-static-analysis-plugin). To run it:

```shell
./vendor/bin/roave-infection-static-analysis-plugin
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

## License

The codeception-db-populator is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.
