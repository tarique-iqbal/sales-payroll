# Sales Payroll Test
A small command-line utility to help a fictional company determine the dates on which they need to pay salaries to their Sales Department. The company handles their Sales payroll in the following way:
- Sales staff get a regular fixed base monthly salary, plus a monthly bonus
- The base salaries are paid on the last day of the month, unless that day is a Saturday or a Sunday (weekend). In that case, salaries are paid before the weekend. For this application, public holidays are not taken into account.
- On the 15th of every month bonuses are paid for the previous month, unless that day is a weekend. In that case, they are paid the first Wednesday after the 15th.

The output would be a CSV file, containing the payment dates for the next twelve months. The CSV file would contain three columns: Month Name, Salary Payment Date for that month, and Bonus Payment Date. The file name would be provided as an argument from cli command.

## Prerequisites

```
composer
php (>=8.2)
```

## Note
The application will now work if [register_argc_argv](http://php.net/manual/en/ini.core.php#ini.register-argc-argv) is disabled.

## Installation and Run the script

- All the `code` required to get started

- Clone this repo to your local machine using
```shell
$ git clone https://github.com/tarique-iqbal/sales-payroll.git
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

- Output file location

`/path/to/data/directory`

## Running the tests

- Follow the Installation instructions.

Adapt `phpunit.xml` PHP Constant according to your setup environment.

```shell
$ cd /path/to/base/directory
$ composer update
$ ./vendor/bin/phpunit tests
```

Test-cases, test unit and integration tests.