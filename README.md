Attendly-php
============

PHP library to access the Attendly api

See http://docs.attendly.net for the documentation.


Tests
=====

Note that the tests are setup to work on a development server of Attendly.. so
are not very interesting for public use.

To run the tests use:
    phpunit --color --bootstrap src/Attendly.php tests

To run the tests with coverage:
   phpunit --color --bootstrap src/Attendly.php --coverage-html coverage tests
