<?php

declare(strict_types=1);

namespace Yii\Extension\Widget\Tests\Stubs;

use Yii\Extension\Widget\SimpleWidget;
use Yiisoft\Html\Html;

final class Widget extends SimpleWidget
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
