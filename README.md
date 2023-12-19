# Laravel Repository
Exposes a base repository class that allows interactions with custom models.

## Installation
```bash
composer require creode/laravel-repository
```

## Usage
To use this package, you just need to extend the base repository abstract class and override the getModel() method to return the model class you wish to use.

```php
use Creode\LaravelRepository\BaseRepository;

class MyRepository extends BaseRepository
{
    /**
     * Returns the model class to use for this repository.
     *
     * @return string
     */
    protected function getModel()
    {
        return MyModel::class;
    }
}
```

This repository can then be called in any other class. For more details about the repository pattern see this article on the benefits of it: https://www.twilio.com/blog/repository-pattern-in-laravel-application
