# Hyperf OPcache
PHP Opcache command for Hyperf

# description
> Transplantation in [laravel-opcache](https://github.com/appstract/laravel-opcache)
> Opcache configuration reference [OPcache configuration]()

# Requirements
This package requires hyperf 2.1 or newer.

# Installation
You can install the package via Composer:
```bash
composer require wilbur-yu/hyperf-opcache
```
If you need to change config values, you can publish the config file with:
```bash
php bin/hyperf.php vendor:publish wilbur-yu/hyperf-opcache
```

# usage
- config
```bash
php bin/hyperf.php opcache:config
```
- status
```bash
php bin/hyperf.php opcache:status
```
- clear
```bash
php bin/hyperf.php opcache:clear
```
- compile
```bash
php bin/hyperf.php opcache:compile {--force}
```

> Note: opcache.dups_fix must be enabled, or use the --force flag. If you run into "Cannot redeclare class" errors, enable opcache.dups_fix or add the class path to the exclude list.

# Contributing
Thanks to the [laravel-opcache](https://github.com/appstract) and their contributors

# License
The MIT License (MIT). Please see [License File](https://github.com/wilbur-yu/hyperf-opcache/blob/main/LICENSE.md) for more information.