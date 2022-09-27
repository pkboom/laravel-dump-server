# Laravel Dump Server

Inspired by [beyondcode/laravel-dump-server](https://github.com/beyondcode/laravel-dump-server)

## Installation

```bash
composer require pkboom/laravel-dump-server --dev
```

You can publish the config:

```bash
php artisan vendor:publish --provider="Pkboom\DumpServer\DumpServerServiceProvider" --tag="config"
```

## Usage

```bash
php artisan dump-server
```

## License

The MIT License (MIT). Please see [MIT license](http://opensource.org/licenses/MIT) for more information.
