# Map attributes from array or external api to the model

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require mamadali/object-mapping "*"
```

or add

```
"mamadali/object-mapping": "*"
```

to the require section of your `composer.json` file.

Basic Usage
------------

implement your model from ObjectMappingInterface
and use HasMapModel Trait in your model

```php
<?php

use mamadali\ObjectMapping\Interfaces\ObjectMappingInterface;

class User extends \Illuminate\Database\Eloquent\Model implements ObjectMappingInterface
{
    use \mamadali\ObjectMapping\Traits\HasMapModel;

}
```
add mapAttributes method to your model and map your attribute
```php
<?php

use mamadali\ObjectMapping\Interfaces\ObjectMappingInterface;

class User extends \Illuminate\Database\Eloquent\Model implements ObjectMappingInterface
{
    use \mamadali\ObjectMapping\Traits\HasMapModel;

    public function mapAttributes() : array
    {
        return [
            'title' => 'firstName',
            'number' => 'phoneNumber',
        ];
    }
}
```
to map attribute from array
```php
$data = [
    'title' => 'test title',
    'number' => '0123456789'
];

$user = new User();
$user->mapData($data);

echo $user->firstName; // get "test title"
echo $user->phoneNumber; // get "0123456789"
```

Advanced Usage
------------
get data from url and map in model
```php
// If we assume endpoint url response as json or xml and data is the same as the example above
$user = new User();
$user->mapDataFromUrl('<your endpoint url>');

echo $user->firstName; // get "test title"
echo $user->phoneNumber; // get "0123456789"
```
you can set headers and method name for request
```php
// If we assume endpoint url response as json or xml and data is the same as the example above
$user = new App\Models\User();
$user->setHeaders(['content-type' => 'application/json']);
$user->setRequestMethod('POST');
$user->mapDataFromUrl('<your endpoint url>');

echo $user->firstName; // get "test title"
echo $user->phoneNumber; // get "0123456789"
```
