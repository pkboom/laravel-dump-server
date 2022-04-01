# Laravel Tinker On VSCode

You can tinker with your application on vscode.

<img src="/images/demo2.png" width="800"  title="demo">

With query:

<img src="/images/demo1.png" width="800"  title="demo">

You can also output data to the console with `dd()` or `dump()`.

<img src="/images/demo3.png" width="800">

## Installation

```bash
composer require pkboom/laravel-dump-server --dev
```

## Usage

```bash
php artisan dump-server
```

You can show queries.

```bash
php artisan dump-server --query
```

You can dump data to dump server.

```bash
php artisan dump-server --dump
```

If you only want to dump data,

```bash
php artisan dump-server
```

## License

The MIT License (MIT). Please see [MIT license](http://opensource.org/licenses/MIT) for more information.
