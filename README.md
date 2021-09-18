<p align="center">
    <img src="docs/codeception-logo.png" height="100">
    <h1 align="center">Database Populator for Codeception DB Module</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/vjik/codeception-db-populator/v/stable.png)](https://packagist.org/packages/vjik/codeception-db-populator)
[![Total Downloads](https://poser.pugx.org/vjik/codeception-db-populator/downloads.png)](https://packagist.org/packages/vjik/codeception-db-populator)
[![Build status](https://github.com/vjik/codeception-db-populator/workflows/build/badge.svg)](https://github.com/vjik/codeception-db-populator/actions?query=workflow%3Abuild)
[![static analysis](https://github.com/vjik/codeception-db-populator/workflows/static%20analysis/badge.svg)](https://github.com/vjik/codeception-db-populator/actions?query=workflow%3A%22static+analysis%22)
[![License](https://poser.pugx.org/vjik/codeception-db-populator/license)](/LICENSE)

[Codeception](https://codeception.com/) DB module addon for handy populate database.

## Requirements

- PHP 7.4 or higher.
- `PDO` PHP extension.
- Codeception 4.1 or higher.
- Codeception Module DB 1.1 or higher.

## Installation

The package could be installed with [composer](https://getcomposer.org/download/):

```shell
composer require vjik/codeception-db-populator --dev --prefer-dist
```

## General usage

Enable in suite module `Db` and `DatabasePopulatorAddon`:

```yml
modules:
  enabled:
    - Db:
        dsn: 'mysql:host=%DB_HOST%;dbname=%DB_NAME%'
        user: '%DB_USERNAME%'
        password: '%DB_PASSWORD%'
    - Vjik\Codeception\DatabasePopulator\Module:
        dumpsPath: 'tests/_data/dumps'
        rowsPath: 'tests/_data/rows'
```

Create dumps and row sets.

Row set format:

Put files with dumps and row sets to dumps/rows paths:

```
tests/
  _data/
    dumps/
      user-management.sql
      blog.sql
      catalog.sql
    rows/
      users.php
      users-with-photos.php
      blog-categories.php
      posts-with-categories.php
```

## Configuration

- `preloadDump` — dump(s) for preload before run suite.
- `preloadRows` — row set(s) for preload before run suite.
- `dumpsPath` (required) — relative path to directory with dumps (for example, `tests/_dump`).
- `rowsPath` (required) — relative path to directory with row sets (for example, `tests/_rows`).

## Testing

### Unit and integration testing

The package is tested with [Codeception](https://codeception.com/). For tests need MySQL database with configuration:

- host: `127.0.0.1`
- name: `db_test`
- user: `root`
- password: `root`

To run tests:

```shell
./vendor/bin/codecept run
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

## License

The Database Populator for Codeception DB Module is free software. It is released under the terms of the BSD License. Please see [`LICENSE`](./LICENSE.md) for more information.
