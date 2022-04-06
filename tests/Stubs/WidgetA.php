<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Widget\Tests\Stubs;

use Yii\Extension\Simple\Widget\AbstractWidget;
use Yiisoft\Html\Html;

class WidgetA extends AbstractWidget
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
