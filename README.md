# Eloquent STI

Eloquent STI brings a Single Table Inheritance capabilities to Eloquent.

## Installation

```bash
composer require "webbingbrasil/eloquent-sti=1.0.0"
```

## Usage
Use the `CanBeInherited` trait in any entity to get STI capabilities in childs

```php
use WebbingBrasil\EloquentSTI\CanBeInherited;

class User extends Model
{
    use CanBeInherited;
}
```

Now just extend the parent model with any child models

```php
class Admin extends User
{
}

class Manager extends User
{
}
```

