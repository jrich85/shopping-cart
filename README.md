# Pittsburgh Penguins FSE Interview Coding Exercise - Shopping List

<img src="https://www-league.nhlstatic.com/images/logos/teams-current-primary-light/5.svg" width="200" style="margin:0 auto;"  alt="Pittsburgh Penguins Logo"/>

## Prerequisites

* php 8.2
* composer
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

Connect to the container and create the new database on your mysql server with the database tools of your choice:

```sql
CREATE DATABASE penguins_fse_interview_project; --application database
CREATE DATABASE penguins_fse_interview_project_test; --test database
GRANT ALL PRIVILEGES ON penguins_fse_interview_project_test.* TO 'sail'@'%'; -- so tests can be run by sail
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
