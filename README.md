# Laravel-Translator

Laravel-translator scans your project `resources/view/` and `app/` folder to find `@lang(...)`, `lang(...)` and `__(...)`
functions, then it create keys based on first parameter value and insert into json translation files.

### Installation

You just have to require the package

```bash
composer require thiagocordeiro/laravel-translator
```

This package register the provider automatically,
[See laravel package discover](https://laravel.com/docs/5.5/packages#package-discovery).

After composer finish installing, you'll be able to update your project translation keys running the following command:

```bash
php artisan translator:update
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
      pt-br.json
      es.json
      fr.json
      ...
```

Keep working as you are used to, when laravel built-in translation funcion can't find given key,
it'll return itself, so if you create english keys, you don't need to create an english translation.

```php-template
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

```php
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
In **Laravel 9** the 'lang' directory is moved up one level so u need to change the output.

First publish config:
```bash
php artisan vendor:publish --provider="Translator\Framework\TranslatorServiceProvider"
```
And change output to:
```php
  'output' => base_path('lang'),
```

### Customization

You can change the default path of views to scan and the output of the json translation files.

First, publish the configuration file.

```bash
php artisan vendor:publish --provider="Translator\Framework\TranslatorServiceProvider"
```

On ``config/translator.php`` you can change the default values of `languages`, `default_language`, `use_keys_as_default_value`, `directories`, `functions`, `output` or if you have a different implementation to save/load translations, you can create your own`translation_repository`and replace on`container` config

```php
use Translator\Framework\LaravelConfigLoader;
use Translator\Infra\LaravelJsonTranslationRepository;

return [
    'languages' => ['pt-br', 'es'],
    'directories' => [
        app_path(),
        resource_path('views'),
    ],
    'functions' => ['lang', '__'],
    'output' => resource_path('lang'),
    'container' => [
        'config_loader' => LaravelConfigLoader::class,
        'translation_repository' => LaravelJsonTranslationRepository::class,
    ],
];
```

## Usage with Laravel Module
If you're using Laravel module package, activate some config below:

First publish config:
```bash
php artisan vendor:publish --provider="Translator\Framework\TranslatorServiceProvider"
```

Change some config variables to use with Laravel module:

`module`: `true` to enable or `false` to disable (default is `false`)

`modules_output`: (default is `false`)
+ `true` to set output file to `Resources/lang` of separate `module`
+ `false` to set to `resources/lang/modules`

`modules_dir`: if your Laravel is using different module dir name, change this variable (default is `Modules`)
```php
return [
    'languages' => ['en', 'pt-br', 'es'],
    'default_language' => 'en',
    'directories' => [
      app_path(),
      resource_path('views'),
    ],
    'output' => resource_path('lang'),
    'modules' => false,
    'modules_output' => false,
    'modules_dir' => base_path('Modules'),
    'extensions' => ['php'],
    'functions' => ['lang', '__'],
    'container' => [
      'config_loader' => LaravelConfigLoader::class,
      'translation_repository' => LaravelJsonTranslationRepository::class,
    ],
    'use_keys_as_default_value' => false,
  ];
```

## Using your keys as the default value

For the default language, most of the time you wish to use the key values as the default translation value. You can enable this by settingd the config option `use_keys_as_default_value` to `true`, and defining a `default_language` to your language. This is by default configured to `en`, but can be overruled by setting the `default_language` key in your config.

### Tips

- Laravel `trans(...)` function doesn't use json files for translation, so you'd better using `__(...)` or it's alias `lang(...)` on php files and `@lang(...)` or `{{ lang(...) }}` on blade files.
- Do not use variables on translation functions, the scanner just get the key if it's a string

### Todo

- View for translate phrases;
- Integration with some translation api (google or deepl) for automatic translations


### Supporting
If you feel like supporting changes then you can send donations to the address below.

Bitcoin Address: bc1qfyudlcxqnvqzxxgpvsfmadwudg4znk2z3asj9h
