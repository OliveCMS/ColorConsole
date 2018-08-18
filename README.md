# ColorConsole

ColorConsole customized https://github.com/kevinlebrun/colors.php/ for Olive: `color.php` license: (The MIT License) Copyright (c) 2018 Kevin Le Brun lebrun.k@gmail.com

## Installation

Install the latest version with

```
$ composer require olive-cms/colorconsole
```

## Basic Usage

``` php
require_once 'vendor/autoload.php';
use Olive\Tools\ColorConsole;

ColorConsole::render(
  'Your Message',
  [
    'color' => 'magenta',
    'background' => 'white',
    'style' => ['bold', 'reverse'],
    'align' => 'center'
  ]
);
```

## Documentation

- [Usage Instructions](doc/01-usage.md)

## Requirements

- PHP 5.5+.

## License

olive-cms/colorconsole is licensed under the [MIT license](http://opensource.org/licenses/MIT).
