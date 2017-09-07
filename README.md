# Laravel-Translator

Laravel-translator scans your project `resources/view/` and `app/` folder to find `lang(...)` and `__(...)` functions, then it create keys based on first parameter value and insert into json translation files.

### Installation

Since this project is on alpha version, it's still not available through packagist, but you can easely install via composer adding it's repository.

```php
"require": { ... },
"require-dev": { ... },
"repositories": [
    {
        "type": "git",
        "url": "https://github.com/thiagocordeiro/laravel-translator.git"
    }
],
```

then you just have to require the package

```sh
$ composer require thiagocordeiro/laravel-translator
```

now that you have this package installed, you just need to register the translator service provider (`Translator\TranslatorServiceProvider::class`).

Open your `config/app.php` and include the it on providers section:

```php
return [
    ...
    'providers' => [
        ...
        Translator\TranslatorServiceProvider::class,
        ...
    ]
]
```

thats it, now you just have to run artisan command
```sh
$ php artisan translator:update
```

### Usage
You just have to work as you are used to, when laravel built-in translation funcion can't find given key, it'll return the key, so if you create english keys, you don't need to create an english translation 
```html
blade:
    @lang('Hello World')
    {{ lang('Hello World') }}
    {{ __('Hello World') }}

php files:
    __('Foo Bar');
    lang('Foo Bar');
```

### Tips
 - Laravel `trans(...)` function doesn't use json files for translation, so you'd better using `__(...)` or it's alias `lang(...)` on php files and `@lang(...)` or `{{ lang(...) }}` on blade files.
 - Do not use variables on translation functions, the scanner just get the key if it's a string
