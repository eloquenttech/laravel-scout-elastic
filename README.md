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
    ],
...
```

## Usage
You wil now be able to use Laravel scout as described in the [official documentation](https://laravel.com/docs/5.7/scout).

### Elasticsearch indexes
While indexing your models, this package will automatically create a new index for your model if one doesnt already
exist. By default the name of the index will be a pluralised version of the models classname. However, you can override
this by implementing a `searchableAs()` method on your model:
```php
    public function searchableAs()
    {
        return 'customer_index';
    }
```

By default, indexes are created without any additional settings. However to fine tune elasticsearch you can add the 
following function to your searchable models to add mappings for each of your searchable properties.
```php
public function searchableProperties()
{
    return [
        'type' => ['type' => 'keyword'],
        'firstname' => ['type' => 'text'],
        'surname' => ['type' => 'text'],
        'email' => ['type' => 'text'],
        'dob' => ['type' => 'date', 'format' => 'yyyy-MM-dd'],
        'company_name' => ['type' => 'text'],
        'phone_number' => ['type' => 'text'],
    ];
}
```
These define your searchable mappings that will be used when creating the index. For more info fine tuning these values
see [the elastic documentation.](https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping.html).

If you need to define further mapping details for your indexes, you will need to create the index manually before
importing any models. These settings will not be overwritten.

> NOTE: Any fields that you wish to filter, or sort on will need to be defined as one of the following in your
> indexes' mapping: `keyword`, `integer`, `date`, `boolean`.

### Additional where clause operators
By default, laravel scout only allows you to use the basic `=` operator in where clauses on your scout queries. 
However, this package extends on this by allowing you to use the following additional operators: `<, <=, >, >=`. 
In order to use these operators you will need to manually edit the scout builders `wheres` property, for example:
```php
$builder = Customers::search('John');
$builder->wheres[] = ['dob', '<', '2000-01-01'];
$builder->wheres[] = ['dob', '>=', '1970-01-01'];
```
This query will fetch all customers named 'John' that were born between 1970 and 2000.

> NOTE: When defining date ranges, you will need to ensure that the dates are provided in the same format
> that has been defined for that field in the `searchableProperties()` method.

## License
The MIT License (MIT).
