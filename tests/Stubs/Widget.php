<?php

declare(strict_types=1);

namespace Yii\Extension\Widget\Tests\Stubs;

use Yii\Extension\Widget\SimpleWidget;
use Yiisoft\Html\Html;

final class Widget extends SimpleWidget
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

    public function addAttribute(string $attribute, string $value): self
    {
        $new = clone $this;
        $new->attributes[$attribute] = $value;
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
