# Requests stubs [![Build Status](https://travis-ci.org/remy-theroux/requests-stubs.svg?branch=master)](https://travis-ci.org/remy-theroux/requests-stubs)

Stubs network requests by describing them and the expected responses (data, status, delay...).
It can be useful for testing code behaviors in different real network situations and it make it
simple. 

## Usage

Write a requests-stubs.yaml file configuring requests you want the server respond to and associated responses.
Then you can tests your requests on the specified port (localhost:9000 in the example) by running php public/index.php.

### Docker

Use it with docker, change the path of the volume where is your yaml configuration file. Replace listening port xxxx
 depending on port configured in your yaml file.

```shell script
docker run -v /local/path/to/yaml/file:/usr/src/app -p 9000:xxxx remy-theroux/requests-stubs
```

### Locally

Use it with php.

```shell script
php public/index.php
```

## Running the tests

Tests are written with Behat, we run an instance of the server and then run expected behavior with the requests-stubs
.yml file. To run test you have two methods:
- Run the server php public/index.php and then exec vendor/bin/behat
- Use composer test to run via docker (used for CI). If you change port in requests-stubs.yml, don't forget to change
 it in test.sh

```shell script
vendor/bin/behat
```

## Built With

* [AMPHP Http server](https://amphp.org/http-server/) - An async http server in PHP
* [Symfony Config](https://symfony.com/doc/current/components/config.html) - A powerfull configuration component
* [Behat](https://behat.org/en/latest/) - A behavior driven development framework

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](/tags). 

## Authors

* **Rémy Théroux** - *Initial work* - [remy-theroux](https://github.com/remy-theroux)

See also the list of [contributors](https://github.com/remy-theroux/requests-stubs/contributors) who participated in
 this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
