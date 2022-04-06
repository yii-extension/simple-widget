<p align="center">
    <a href="https://github.com/yii-extension" target="_blank">
        <img src="https://lh3.googleusercontent.com/ehSTPnXqrkk0M3U-UPCjC0fty9K6lgykK2WOUA2nUHp8gIkRjeTN8z8SABlkvcvR-9PIrboxIvPGujPgWebLQeHHgX7yLUoxFSduiZrTog6WoZLiAvqcTR1QTPVRmns2tYjACpp7EQ=w2400" height="100px">
    </a>
    <h1 align="center">Simple widget for YiiFramework</h1>
    <br>
</p>

[![Total Downloads](https://poser.pugx.org/yii-extension/simple-widget/downloads.png)](https://packagist.org/packages/yii-extension/simple-widget)
[![Build Status](https://github.com/yii-extension/simple-widget/workflows/build/badge.svg)](https://github.com/yii-extension/simple-widget/actions?query=workflow%3Abuild)
[![codecov](https://codecov.io/gh/yii-extension/simple-widget/branch/master/graph/badge.svg?token=gaUysTvoUu)](https://codecov.io/gh/yii-extension/simple-widget)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyii-extension%2Fsimple-widget%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/yii-extension/simple-widget/master)
[![static analysis](https://github.com/yii-extension/simple-widget/workflows/static%20analysis/badge.svg)](https://github.com/yii-extension/simple-widget/actions?query=workflow%3A%22static+analysis%22)
[![type-coverage](https://shepherd.dev/github/yii-extension/simple-widget/coverage.svg)](https://shepherd.dev/github/yii-extension/simple-widget)


## Installation

```shell
composer require simple-widget
```

## Usage

Create a new widget without dependencies:

```php
<?php

declare(strict_types=1);

namespace App\Widget;

use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\Html;

final class Widget extends AbstractWidget
{
    protected function run(): string
    {
        return '<' . trim(html::renderTagAttributes($this->attributes)) . '>';
    }

    public function id(string $value): self
    {
        $new = clone $this;
        $new->attributes['id'] = $value;
        return $new;
    }

    protected function beforeRun(): bool
    {
        if (isset($this->attributes['id']) && $this->attributes['id'] === 'beforerun') {
            return false;
        }

        return parent::beforeRun();
    }

    protected function afterRun(string $result): string
    {
        $result = parent::afterRun($result);

        if (isset($this->attributes['id']) && $this->attributes['id'] === 'afterrun') {
            $result = '<div>' . $result . '</div>';
        }

        return $result;
    }
}
```

Using widget in view:
```php
<?php

declare(strict_types=1);
?>

Widget::create()->id('id-test')->attributes(['class' => 'text-danger'])->render();
```

Code generated:
```html
<id="id-test" class="text-danger">
```

Using widget in view with config factory:
```php
<?php

declare(strict_types=1);
?>

Widget::create(['attributes()' => [['class' => 'test-class']], 'id()' => ['id-tests']])->render();
```

Code generated:
```html
<id="id-tests" class="test-class">
```

Load config from file: `config.php`
```php
return [
    'attributes()' => ['class' => 'test-class'],
    'id()' => 'id-tests',
];
```

Using widget in view with load config field:
```php
<?php

declare(strict_types=1);
?>

Widget::create()->loadConfigFile(__DIR__ . '/config/config.php')->render();
```

Code generated:
```html
<id="id-tests" class="test-class">
```

Create a new widget with dependencies:

```php
<?php

declare(strict_types=1);

namespace App\Widget;

use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\Html;

final class Widget extends AbstractWidget
{
    public function __construct(private HTML $html)
    {
    }

    protected function run(): string
    {
        return '<' . trim($this->html->renderTagAttributes($this->attributes)) . '>';
    }

    public function id(string $value): self
    {
        $new = clone $this;
        $new->attributes['id'] = $value;
        return $new;
    }
}
```

Using widget in view with depedencie injection:
```php
<?php

declare(strict_types=1);

use App\Widget;

Widget::create(['attributes()' => [['class' => 'test-class']]], [new Html()])->id('w0')->render();
```

Code generated:
```html
<id="w0" class="test-class">
```

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework. To run it:

```shell
./vendor/bin/roave-infection-static-analysis-plugin -j2 --ignore-msi-with-no-mutations --only-covered
```

## Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/docs). To run static analysis:

```shell
./vendor/bin/psalm
```

### Support the project

[![Open Collective](https://img.shields.io/badge/Open%20Collective-sponsor-7eadf1?logo=open%20collective&logoColor=7eadf1&labelColor=555555)](https://opencollective.com/yiisoft)

## License

The simple-widget for Yii Packages is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

Maintained by [Yii Extension](https://github.com/yii-extension).
