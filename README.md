# berrier

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Install

Via Composer

``` bash
$ composer require wislem/berrier
```

## Main Setup steps

#### Step 1
Add
``` php
Wislem\Berrier\BerrierServiceProvider::class
```
to your ```config/app.php``` file

#### Step 2
Publish various files needed
```php artisan vendor:publish```

#### Step 4
Run ```composer dump-autoload```

#### Step 5
Delete default migrations of Laravel 5 inside ```database/migrations```
Run ```php artisan migrate```
Run ```php artisan db:seed```

#### Step 6
In your User model, delete this line
```php
use Illuminate\Foundation\Auth\User as Authenticatable;
```
and change
```php
class User extends Authenticatable 
```
to
```php
class User extends \Wislem\Berrier\Models\User
```

#### Step 7
Log in ```http://your.path/admin``` using
Email: admin@example.com
Password: admin

#### Step 8
Edit the locales inside ```config/translatable.php``` to look like this
``` php
    'locales' => [
        'en',
        'el',
        'de',
    ],
```
since Berrier has these locales upon setup.
Make sure to check the published ```config/berrier.php``` file for more options.

## Enjoy!

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email peter.lazaridis@gmail.com instead of using the issue tracker.

## Credits

- [Peter Lazaridis][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/wislem/berrier.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/wislem/berrier/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/wislem/berrier.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/wislem/berrier.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/wislem/berrier.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/wislem/berrier
[link-travis]: https://travis-ci.org/wislem/berrier
[link-scrutinizer]: https://scrutinizer-ci.com/g/wislem/berrier/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/wislem/berrier
[link-downloads]: https://packagist.org/packages/wislem/berrier
[link-author]: https://github.com/wislem
[link-contributors]: ../../contributors
