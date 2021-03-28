<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Widget\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use RuntimeException;
use Yii\Extension\Simple\Widget\Tests\Stubs\ImmutableWidget;
use Yii\Extension\Simple\Widget\Tests\Stubs\TestWidget;
use Yii\Extension\Simple\Widget\Tests\Stubs\TestWidgetA;
use Yii\Extension\Simple\Widget\Tests\Stubs\TestWidgetB;

final class WidgetTest extends TestCase
{
    public function testWidget(): void
    {
        $output = TestWidget::widget()->id('w0')->render();
        $this->assertSame('<run-w0>', $output);
    }

    public function testToStringWidget(): void
    {
        $output = TestWidget::widget()->id('w0');
        $this->assertSame('<run-w0>', (string) $output);
    }

    public function testBeginEnd(): void
    {
        TestWidgetA::widget()->id('test')->begin();
        $output = TestWidgetA::end();
        $this->assertSame('<run-test>', $output);
    }

    public function testWidgetWithImmutableWidget(): void
    {
        $widget = ImmutableWidget::widget()->id('new');
        $output = $widget->render();
        $this->assertSame('<run-new>', $output);
    }

    public function testBeginEndWithImmutableWidget(): void
    {
        $widget = ImmutableWidget::widget()->id('new');
        $widget->begin();
        $output = $widget::end();
        $this->assertSame('<run-new>', $output);
    }

    public function testBeginEndStaticWithImmutableWidget(): void
    {
        ImmutableWidget::widget()->id('new')->begin();
        $output = ImmutableWidget::end();

        $this->assertSame('<run-new>', $output);
    }

    public function testStackTrackingWithImmutableWidget(): void
    {
        $widget = ImmutableWidget::widget();
        $this->expectException(RuntimeException::class);
        $widget::end();
    }

    /**
     * @depends testBeginEnd
     */
    public function testStackTracking(): void
    {
        $widget = TestWidget::widget();
        $this->expectException(RuntimeException::class);
        $widget::end();
    }

    /**
     * @depends testBeginEnd
     */
    public function testStackTrackingDisorder(): void
    {
        $this->expectException(RuntimeException::class);
        $a = TestWidgetA::widget();
        $b = TestWidgetB::widget();
        $a::end();
        $b::end();
    }

    /**
     * @depends testBeginEnd
     */
    public function testStackTrackingDiferentClass(): void
    {
        $this->expectException(RuntimeException::class);
        TestWidgetA::widget()->begin();
        TestWidgetB::end();
    }

    public function testBeforeRun(): void
    {
        TestWidget::widget()->id('beforerun')->begin();
        $output = TestWidget::end();
        $this->assertEmpty($output);
    }

    public function testAfterRun(): void
    {
        TestWidget::widget()->id('afterrun')->begin();
        $output = TestWidget::end();
        $this->assertSame('<div><run-afterrun></div>', $output);
    }
}
