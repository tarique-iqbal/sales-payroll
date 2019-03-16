# Sales Payroll Test

### Prerequisites

```
composer
php (>=7.2)
```

### Installation and Run the script

- All the `code` required to get started

- Clone this repo to your local machine using
```shell
$ git clone https://github.com/tarique-iqbal/php-code-sample.git
```

- Need write permission to following `directories` through the PHP script

`/path/to/log/directory`

`/path/to/data/directory`

- Install the script

```shell
$ cd /path/to/base/directory
$ composer install --no-dev
```

- Run the script

```shell
$ php index.php --file=data.csv
or
$ php index.php -f=data.csv
or
$ php index.php data.csv
```

## Running the tests

- Follow the Install instructions.

Adapt `phpunit.xml` PHP Constant according to your setup environment.

```shell
$ cd /path/to/base/directory
$ composer update
$ ./vendor/bin/phpunit tests
```

Test-cases, test unit and integration tests.