# Laravel Scout Elasticsearch Driver
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package makes is the [Elasticsearch](https://www.elastic.co/products/elasticsearch) driver for Laravel Scout.

## Contents
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)

## Installation
You can install the package via composer:

``` bash
composer require eloquent/laravel-scout-elastic
```

Laravel will automatically register the packages service provider that is responsible for registering
the elastic driver with the scout engine.

### Setting up Elasticsearch configuration
You must have a Elasticsearch server up and running with the index you want to use created

If you need help with this please refer to the [Elasticsearch documentation](https://www.elastic.co/guide/en/elasticsearch/reference/current/index.html)

After you've published the Laravel Scout package configuration:

```php
    // config/scout.php
    // Set your driver to elasticsearch
    'driver' => env('SCOUT_DRIVER', 'elastic'),

...
    'elastic' => [
        'hosts' => [
            env('SCOUT_ELASTIC_HOST', 'http://localhost'),
        ],
        'min_score' => 2.5,
    ],
...
```

## Usage
You wil now be able to use Laravel scout as described in the [official documentation](https://laravel.com/docs/5.7/scout).

However to fine tune your elastic search further you can add the following function to your searchable models
```php
public function searchableProperties()
{
    return [
        'type' => ['type' => 'keyword'],
        'firstname' => ['type' => 'text'],
        'surname' => ['type' => 'text'],
        'email' => ['type' => 'text'],
        'company_name' => ['type' => 'text'],
        'phone_number' => ['type' => 'text'],
    ];
}
```
These define your searchable mappings that will be used when creating the index. For more info fine tuning these values
see [the elastic documentation.](https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping.html).

> NOTE: In order for the `where()` method to work this this driver,
> the field you are filtering must be defined as type `keyword`.

## License
The MIT License (MIT).
