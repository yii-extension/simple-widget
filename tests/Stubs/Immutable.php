<?php

declare(strict_types=1);

namespace Yii\Extension\Widget\Tests\Stubs;

use Yii\Extension\Widget\SimpleWidget;

final class Immutable extends SimpleWidget
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
