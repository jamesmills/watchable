# Laravel Watchable

[![Packagist](https://img.shields.io/packagist/v/jamesmills/watchable.svg?style=flat-square)](https://packagist.org/packages/jamesmills/watchable)
[![Travis](https://img.shields.io/travis/jamesmills/watchable.svg?style=flat-square)](https://travis-ci.org/jamesmills/watchable)
[![Buy us a tree](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-lightgreen?style=for-the-badge)](https://offset.earth/treeware?gift-trees)

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

## Sample Usage and Boilerplate

I wrote a blog post to give you some boilerplate code that you can use in your application to wrap around the Laravel Watchable package. 

https://jamesmills.co.uk/2017/10/22/laravel-watchable-package

## How to use

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

You can optionally send the ```$user_id``` if you don't want to use the built in ```auth()->user()->id``` functionality.

```php
$book = Book::first();
$book->watch($user_id);
$book->unwatch($user_id); 
$book->toggleWatch($user_id); 
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

## Treeware

You're free to use this package, but if it makes it to your production environment you are required to buy the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to <a href="https://www.bbc.co.uk/news/science-environment-48870920">plant trees</a>. If you contribute to my forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees at for my forest here [offset.earth/treeware](https://offset.earth/treeware?gift-trees)

Read more about Treeware at [treeware.earth](http://treeware.earth?utm_referrer=github_licence_link)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
