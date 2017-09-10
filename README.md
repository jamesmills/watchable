# Laravel Watchable

[![Packagist](https://img.shields.io/packagist/v/jamesmills/watchable.svg?style=flat-square)](https://packagist.org/packages/jamesmills/watchable)
[![Packagist](https://img.shields.io/packagist/l/jamesmills/watchable.svg?style=flat-square)]()
[![Travis](https://img.shields.io/travis/jamesmills/watchable.svg?style=flat-square)](https://travis-ci.org/jamesmills/watchable)

Enable users to watch various models in your application.
 - Designed to work with Laravel Eloquent models
 - Just add the trait to the model you would like to be watchable
 - Watches are unique for one model and one user
 - Events are fired on `watched` and `unwatched` methods
 - Built to work with Laravel Notifications

## Installation

Pull in the package using Composer

    composer require jamesmills/watchable

> **Note**: If you are using Laravel 5.5, the next step for provider are unnecessary. Laravel Watchable supports Laravel [Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery).

Include the service provider within `app/config/app.php`.

```php
'providers' => [
    ...
    JamesMills\Watchable\WatchableServiceProvider::class,
],
```

Publish and run the database migrations

```bash
php artisan vendor:publish --provider="JamesMills\Watchable\WatchableServiceProvider" --tag="migrations"
php artisan migrate
```

## Sample Usage

### Prepare your model to be watched

Simply add the `watchable` trait to your model

```php
use Illuminate\Database\Eloquent\Model;
use JamesMills\Watchable\Traits\Watchable;

class Book extends Model {
    use Watchable;
} 
```

### Available methods

Watch a model

```php
$book = Book::first();
$book->watch(); 
```

Unwatch a model

```php
$book = Book::first();
$book->unwatch(); 
```

Toggle the watching of a model

```php
$book = Book::first();
$book->toggleWatch(); 
```

Find out if the current user is watching the model

```php
@if ($book->isWatched())
    {{ You are watching this book }}
@else
    {{ You are NOT watching this book }}
@endif
```

Get a collection of the user who are watching a model

```php
$book = Book::first();
$book->collectWatchers(); 
```

### Use with Notifications

One of the main reasons I built this package was to scratch my own itch with an application I am building. I wanted to be able to send notifications to user who were watching a given model and I also wanted to allow users to be able to watch a number of different models.

```php
public function pause(Order $order)
{
    $this->performAction('paused', $order);
    Notification::send($order->collectWatchers(), new OrderPaused($order));
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
