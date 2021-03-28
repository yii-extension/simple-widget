<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Widget\Tests\Stubs;

use Yii\Extension\Simple\Widget\AbstractWidget;

class ImmutableWidget extends AbstractWidget
{
    private string $id = 'original';

    protected function run(): string
    {
        return '<run-' . $this->id . '>';
    }

    public function id(string $value): self
    {
        $new = clone $this;
        $new->id = $value;

        return $new;
    }
}
