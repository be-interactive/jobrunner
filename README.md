# Run a Laravel scheduled job manually.
Run any command in your Laravel application

## Support us

[<img src="resources/images/jobrunner-logo.jpg" width="416px" />](https://be-interactive.nl)

We invest a lot of resources into creating [best in class open source packages](https://be-interactive.nl/open-source). You can support us by [buying one of our paid products](https://be-interactive.nl/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://be-interactive.nl/contact).

## Installation

You can install the package via composer:

```bash
composer require be-interactive/jobrunner
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="jobrunner-config"
```

This is the default contents of the published config file:

```php
return [
    'folders' => [
        'App\Console\Commands' => __DIR__.'/../app/Console/Commands',
    ],
];
```

## Usage

```bash
php artisan jobrunner
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jeroen Evers](https://github.com/punneke)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
