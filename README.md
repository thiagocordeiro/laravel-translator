# Laravel-Translator

Laravel-translator scans your project `resources/view/` and `app/` folder to find `lang(...)` and `__(...)` functions, then it create keys based on first parameter value and insert into json translation files.

### Installation

You just have to require the package

```sh
$ composer require thiagocordeiro/laravel-translator
```

This package register the provider automatically,
[See laravel package discover](https://laravel.com/docs/5.5/packages#package-discovery).

After composer finish it's installation, you'll be able to update your project translation keys running the following command:
```sh
$ php artisan translator:update
```

if for any reason artisan can't find `translator:update` command, you can register the provider manually on your `config/app.php` file:

```php
return [
    ...
    'providers' => [
        ...
        Translator\Framework\TranslatorServiceProvider::class,
        ...
    ]
]
```

### Usage
First you have to create your json translation files:
```
app/
  resources/
    lang/
      pt.json
      es.json
      fr.json
```
Keep working as you are used to, when laravel built-in translation funcion can't find given key, it'll return itself, so if you create english keys, you don't need to create an english translation 
```html
blade:
<html>
    @lang('Hello World')
    {{ lang('Hello World') }}
    {{ __('Hello World') }}
</html>

controllers, models, etc.:
<?php
    __('Hello World');
    lang('Hello World');
```

also you can use params on translation keys
```
@lang('Welcome, :name', ['Arthur Dent'])
```

### Output
`translator:update` command will scan your code to identify new translation keys, then it'll update all json files on `app/resources/lang/` folder appending this keys.

```json
{
    "Hello World": "Hola Mundo",
    "Welcome, :name": "Bienvenido, :name",
    "Just scanned key": ""
}
```

### Customization
You can change the default path of views to scan and the output of the json translation files.

First, publish the configuration file.

```
php artisan vendor:publish --provider="Translator\Framework\TranslatorServiceProvider"
```

On ``config/laravel-translator.php`` you can change the default values of `views_directories` and `translations_output`

```
return [
    'views_directories' => [
        app_path(),
        resource_path('views'),
    ],
    'translations_output' => resource_path('lang'),
];
```

### Tips
 - Laravel `trans(...)` function doesn't use json files for translation, so you'd better using `__(...)` or it's alias `lang(...)` on php files and `@lang(...)` or `{{ lang(...) }}` on blade files.
 - Do not use variables on translation functions, the scanner just get the key if it's a string

### Todo
- Tests;
- Support older laravel versions;
- View for translate phrases;
