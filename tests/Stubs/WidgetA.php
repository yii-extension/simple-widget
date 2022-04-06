<?php

declare(strict_types=1);

namespace Yii\Extension\Widget\Tests\Stubs;

use Yii\Extension\Widget\SimpleWidget;
use Yiisoft\Html\Html;

class WidgetA extends SimpleWidget
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
}
