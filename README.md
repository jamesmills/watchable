#Laravel Watchable

Enable users to watch various models in your applications

#### Composer Install

	composer require jamesmills/watchable

#### Install and then run the migrations

```php
'providers' => [
    ...
    JamesMills\Watchable\WatchableServiceProvider::class,
],
```

```bash
php artisan vendor:publish --provider="JamesMills\Watchable\WatchableServiceProvider" --tag="migrations"
php artisan migrate
```

#### Sample Usage

```php
// Find an article and watch it
$article = Article::first();
$article->watch(); 
```