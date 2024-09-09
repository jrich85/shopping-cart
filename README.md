# FSE Coding Exercise - Shopping List

A shopping list app, with a Pittsburgh Penguins theme.

<img src="public/images/Pittsburgh-Penguins-logo.png" width="200" style="margin:0 auto;"  alt="Pittsburgh Penguins Logo"/>

## Prerequisites

The backend is php with a standard laravel install and a mysql database, and the frontend has been built with vue.js.
Current versions and tools of the underlying structure.

* php ^8.2
* composer 2.5.8
* npm ^9.8
* node ^18.16
* docker ^24.05

## Setup Steps

Navigate into the root of the directory in your terminal, and run the following commands to install the dependencies:

```shell
$ cp .env.example .env
$ composer install
$ npm install
```

_I've included the development values in `.env.example` that I used locally, for ease of use._

Build the backend, and start the docker containers in the background.

```shell
$ ./vendor/bin/sail up --build -d
```

Upon the first build, the database will be created for you. If you would like to run the tests with the test database,
connect to the container with your database tool with the credentials used in the `.env` file, and run the following SQL
commands:

```sql
CREATE DATABASE fse_shopping_cart_project_test; --test database
GRANT ALL PRIVILEGES ON fse_shopping_cart_project_test.* TO 'sail'@'%'; -- so tests can be run by sail
```

Run the migrations on the container, through the custom composer command*:

```shell
$ composer artisan migrate:fresh
```

_* Make sure your container is named the same as in `composer.json` in the scripts section._

Start the frontend up with the following command:

```shell
$ npm run dev
```

Now that you're all set, you can navigate to [http://localhost](http://localhost) to see the application.

## Unit Tests

The backend is largely covered by unit and feature tests run through phpunit.

To run the full test suite, you'll have to execute the tests on the container.
There is a handy composer command* to help you out if you don't want to take
the time to setup your ide to run them.

```shell
composer run tests
```

_* Make sure your container is named the same as in `composer.json` in the scripts section._
