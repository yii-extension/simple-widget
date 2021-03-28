<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Widget\Tests\Stubs;

use Yii\Extension\Simple\Widget\AbstractWidget;

class TestWidget extends AbstractWidget
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

    protected function beforeRun(): bool
    {
        if ($this->id === 'beforerun') {
            return false;
        }

        return parent::beforeRun();
    }

    protected function afterRun(string $result): string
    {
        $result = parent::afterRun($result);

        if ($this->id === 'afterrun') {
            $result = '<div>' . $result . '</div>';
        }

        return $result;
    }
}
