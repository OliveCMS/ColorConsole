# Using ColorConsole

- [Installation](#installation)
  1. [Basic Usage](#basic-usage)
- [Items](#items)
  1. [Style](#style)
  2. [Color](#color)
  3. [Background](#background)
  3. [Align](#align)

## Installation

olive-cms/colorconsole is available on Packagist ([olive-cms/colorconsole](http://packagist.org/packages/olive-cms/colorconsole)) and as such installable via [Composer](http://getcomposer.org/).

```bash
composer require olive-cms/colorconsole
```

If you do not use Composer, you can grab the code from GitHub, and use any PSR-0 compatible autoloader (e.g. the [Symfony2 ClassLoader component](https://github.com/symfony/ClassLoader)) to load Monolog classes.


### Basic Usage

``` php
require_once 'vendor/autoload.php';
use Olive\Tools\ColorConsole;

echo ColorConsole::render(
  'Your Message',
  [
    'color' => 'magenta',
    'background' => 'white',
    'style' => ['bold', 'reverse'],
    'align' => 'center'
  ]
);
```

## Items

### Style

Notice: italic and blink may not work depending of your terminal

available styles:

* reset
* bold
* dark
* italic
* underline
* blink
* reverse
* concealed

### Color

available text Colors:

* default
* black
* red
* green
* yellow
* blue
* magenta
* cyan
* light_gray
* dark_gray
* light_red
* light_green
* light_yellow
* light_blue
* light_magenta
* light_cyan
* white

### Background

available text backgrounds:

* default
* black
* red
* green
* yellow
* blue
* magenta
* cyan
* light_gray
* dark_gray
* light_red
* light_green
* light_yellow
* light_blue
* light_magenta
* light_cyan
* white

### Align

available Align:

* center
