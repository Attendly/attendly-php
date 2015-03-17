Attendly-php
============

[ ![Codeship Status for Attendly/attendly-php](https://codeship.com/projects/12347ff0-ae76-0132-eff6-6a5d0765ab36/status?branch=master)](https://codeship.com/projects/68906)

[![Coverage Status](https://coveralls.io/repos/Attendly/attendly-php/badge.svg)](https://coveralls.io/r/Attendly/attendly-php)


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


