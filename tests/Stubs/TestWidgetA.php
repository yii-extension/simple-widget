<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Widget\Tests\Stubs;

use Yii\Extension\Simple\Widget\AbstractWidget;

class TestWidgetA extends AbstractWidget
{
    private string $id;

    protected function run(): string
    {
        return '<run-' . $this->id . '>';
    }

    public function id(string $value): self
    {
        $this->id = $value;

        return $this;
    }
}
