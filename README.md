<p align="center">
    <img src="codeception-logo.png" height="100">
    <h1 align="center">Database Populator for Codeception DB Module</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/vjik/codeception-db-populator/v)](https://packagist.org/packages/vjik/codeception-db-populator)
[![Total Downloads](https://poser.pugx.org/vjik/codeception-db-populator/downloads)](https://packagist.org/packages/vjik/codeception-db-populator)
[![MySQL build](https://github.com/vjik/codeception-db-populator/actions/workflows/build-mysql.yml/badge.svg)](https://github.com/vjik/codeception-db-populator/actions/workflows/build-mysql.yml)
[![PgSQL build](https://github.com/vjik/codeception-db-populator/actions/workflows/build-pgsql.yml/badge.svg)](https://github.com/vjik/codeception-db-populator/actions/workflows/build-pgsql.yml)
[![static analysis](https://github.com/vjik/codeception-db-populator/actions/workflows/static.yml/badge.svg)](https://github.com/vjik/codeception-db-populator/actions/workflows/static.yml)
[![License](https://poser.pugx.org/vjik/codeception-db-populator/license)](/LICENSE)

[Codeception](https://codeception.com/) DB module addon that helps you to tune database populations. 
So for a test you could load only needed tables or rows. As a result it dramatically reduces the total execution time.

## Requirements

- PHP 8.0 or higher.
- Codeception 5.0 or higher.
- Codeception Module DB 3.0 or higher.

## Installation

The package could be installed with [composer](https://getcomposer.org/download/):

```shell
composer require vjik/codeception-db-populator --dev
```
## General usage

Enable module `Db` and `DatabasePopulator` addon in the suite:

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

Create SQL dumps that contains a record of the table structure and/or the data for use in tests.
Put dumps into path, specified in options (for example, `tests/_data/dumps`).

Create row sets for populate database tables. Row sets is PHP file that return array in format `table => rows`.
For example:

```php
<?php
return [
    'author' => [
        [
            'id' => 1,
            'name' => 'Ivan',
        ],
        [
            'id' => 2,
            'name' => 'Petr',
        ],
    ],
    'post' => [
        [
            'id' => 1,
            'author_id' => 2,
            'name' => 'First post',
        ],
        [
            'id' => 2,
            'author_id' => 2,
            'name' => 'My history',
        ],
    ],
];
```

You can get structure, similar to this:

```
tests/
  _data/
    dumps/
      user-management.sql
      blog.sql
      catalog.sql
    rows/
      users.php
      authors.php
      blog-categories.php
      posts-with-categories.php
```

Load dumps and row sets in your tests:

```php
final class BlogTest extends Unit
{
    public function testCreatePost(): void
    {
        $this->tester->loadDump('blog');
        $this->tester->loadRows('authors');
        ...
    }
}
```

## Actions

### `loadDump()`

Load the specified dump(s) to database. Before loading the dump, the database is cleaned.

```php
$I->loadDump('blog'); // load one dump
$I->loadDump('blog', 'catalog'); // load several dumps
```

### `loadRows()`

Load the specified row set(s) to database.

```php
$I->loadRows('posts'); // load one set
$I->loadRows('users', 'comments'); // load several sets
```

## Configuration


- `dumpsPath` (required) — relative path to directory with dumps (for example, `tests/_dump`).
- `rowsPath` (required) — relative path to directory with row sets (for example, `tests/_rows`).
- `preloadDump` — dump(s) for preload before run suite.
- `preloadRows` — row set(s) for preload before run suite.

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
