# Requests stubs

Stubs network requests by describing them and the expected responses (data, status, delay...).
It can be useful for testing code behaviors in different real network situations and it make it
simple. 

## Getting Started

Write a requests-stubs.yaml file configuring requests you want the server respond to and associated responses.
Then you can tests your requests on the specified port (localhost:9000 in the example) by running php public/index.php.
.

## Running the tests

```
vendor/bin/behat
```

## Built With

* [AMPHP Http server](https://amphp.org/http-server/) - An async http server in PHP
* [Symfony Config](https://symfony.com/doc/current/components/config.html) - A powerfull configuration component

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](/tags). 

## Authors

* **Rémy Théroux** - *Initial work* - [remy-theroux](https://github.com/remy-theroux)

See also the list of [contributors](https://github.com/remy-theroux/requests-stubs/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
