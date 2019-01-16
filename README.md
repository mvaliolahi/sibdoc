## SibDoc

[![Latest Stable Version](https://poser.pugx.org/mvaliolahi/sibdoc/v/stable)](https://packagist.org/packages/mvaliolahi/sibdoc)
[![Total Downloads](https://poser.pugx.org/mvaliolahi/sibdoc/downloads)](https://packagist.org/packages/mvaliolahi/sibdoc)
[![Build Status](https://travis-ci.org/mvaliolahi/sibdoc.svg?branch=master)](https://travis-ci.org/mvaliolahi/sibdoc)
[![PHP-Eye](https://php-eye.com/badge/mvaliolahi/sibdoc/tested.svg?style=flat)](https://php-eye.com/package/mvaliolahi/sibdoc)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan) 
<!-- [![StyleCI](https://github.styleci.io/repos/165880013/shield?style=flat)](https://github.styleci.io/repos/165880013) -->
<!-- [![codecov](https://codecov.io/gh/mvaliolahi/sibdoc/branch/master/graph/badge.svg)](https://codecov.io/gh/mvaliolahi/sibdoc) --> 

Generate API Document Using Pure PHP.

<p align="center"><img src="https://mvaliolahi.github.io/assets/images/sibdoc01.jpg"></p>

#### Install

```bash
composer require mvaliolahi/sibdoc
```

#### 1. Instantiate SibDoc.
To generate document for your awesome API create an instance of SibDoc:

```php
$api =  new SibDoc([
    'url'         => 'http://127.0.0.1:8000',
    'title'       => 'Our Awesome API',
    'description' => 'Generate API Document Using Lovely PHP.',
]);
```

- Tip: There is another optional argument called `'background_color => '#0099cc'` to specify Document background color.


#### 2. Define Endpoints

```php
   
$api->post('transactions/{id}', function (Request $request) {

    //  Define Request.
    $request->title('Show transaction.');
    $request->version("v1"); // Optional

    $request->parameters([
        'token' => 'required',
        'transaction_id' => 'required',
    ]);

    // Define Response.
    $success = (new Response())
        ->title('Success')
        ->code(200)
        ->body([
            'id'         => 'numeric',
            'status'     => 'PAID | UNPAID',
            'created_at' =>  'timestamp', 
        ]);        
        
    // Assings Reaponses to the Request.
    $request->response($success);
    
});

```

Tips:
- Request can have more than one response, just define another Response object and assign it to `$request`.
- $request->response('Success', $success); is another way to assign response to request and define alias for response.
- Request and Response they both have `description()` method, this method is optional.
- You can define Header for both Request and Response Objects using `headers()` method for example:  
    
    `$request->headers([])`.
    
  or define a general header for those using `$api->requestHeaders([])` or `$api->responseHeaders([])` method.

<p align="center"><img src="https://mvaliolahi.github.io/assets/images/sibdoc02.jpg"></p>

Available methods: 
    
- get
- post
- put
- patch
- delete
- head
- connect
- options
- trace

###### Define Group

```php
      
$api->group('app', function(SibDoc $api) {
    
    $api->delete('posts/{id}', function (Request $request) {
        // Define request and response.
    });
        
});

```
   
#### Define Model
```php
$api->model('user', [
    'id'     => 'numeric',
    'name'   => 'string',
    'family' => 'string',
    'avatar' => 'url',
]);
```   

##### Use model as part of response body

```php
$api->get('users', function (Request $request) {

    $request->title('Get all users');
    $request->version(1.2);
    $request->description('...');
    $request->parameters(['token' => 'required']);
    
    $success = (new Response())
        ->title('Success')
        ->description('...')
        ->code(200)
        ->body([
            'data'  => [ $api->model('user') ] // when second argument is null it will act as getter.
        ]);    
        
    $fail = (new Response())
        ->title('Fail')
        ->description('...')
        ->code(404)
        ->body([
            'data'  => []
        ]); 
        
    $request->response($success);    
    $request->response($fail);    
                   
});
```

#### 3. Generate Html

By default SibDoc can generate a file called `document.html` for you.

```php

$api->saveTo('/home/meysam/');

```

Tips: 
- first argument specify export path, after call `saveTo()` method with related parameters, it will generate a file called `document.html` in that path.
- second argument refer to built-in Generator for create html file.
- you can define your custom generator to create you desire format, for example `markdown` or maybe `json` file. i will demonstrate to you right below!

##### Create Custom Generator
first of all you need a regular class and you should extends it from `DocumentGenerator` abstract class.

```php
/**
 * Class FakeGenerator
 * @package Tests\Generators
 */
class FakeGenerator extends DocumentGenerator
{
    /**
     * @param $path
     * @return mixed
     */
    public function format($path)
    {
        return 'fake generator!';
    }
}
```

There are several method after extends your class that you can use to generate your custom format.

- groups()
    * gives you all defined groups. when group name is not string that's mean its not a group, means its a single endpoint.
    
- endpoints() 
    * gives you an array contains all endpoints and group, each group can have several endpoint.
- models()
- backgroundColor() 

    * gives you the `background_color` value from what you pass as SibDoc instance argument.
    
it up to you how use them and how is your final format.


at the end you should pass your generator as argument to SibDoc:

```php
$api = new SibDoc([
    'url'         => 'http://127.0.0.1:8000',
    'title'       => 'SibDoc Document Generator',
    'description' => 'Generate Api Document Using Pure PHP.',
    'generator'   => [
        'fake_generator' => FakeGenerator::class
    ],
]);

// define you groups and endpoints

$api->saveTo('/home/user/', 'fake_generator');

```


