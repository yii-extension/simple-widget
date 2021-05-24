<?php

declare(strict_types=1);

namespace Yii\Extension\Simple\Widget;

use ReflectionClass;
use ReflectionException;
use RuntimeException;

use function get_class;

/**
 * Widget generates a string content based on some logic and input data.
 *
 * These are typically used in templates to conceal complex HTML rendering logic.
 *
 * This is the base class that is meant to be inherited when implementing your own widgets.
 */
abstract class AbstractWidget
{
    /**
     * The widgets that are currently opened and not yet closed.
     *
     * This property is maintained by {@see begin()} and {@see end()} methods.
     *
     * @var array
     */
    private static array $stack;

    /**
     * Used to open a wrapping widget (the one with begin/end).
     *
     * When implementing this method, don't forget to call parent::begin().
     *
     * @return string Opening part of widget markup.
     */
    public function begin(): string
    {
        self::$stack[] = $this;

        return '';
    }

    /**
     * Renders widget content.
     *
     * This method is used by {@see render()} and is meant to be overridden when implementing concrete widget.
     */
    abstract protected function run(): string;

    /**
     * Checks that the widget was opened with {@see begin()}. If so, runs it and returns content generated.
     *
     * @throws RuntimeException
     */
    final public static function end(): string
    {
        if (empty(self::$stack)) {
            throw new RuntimeException(
                'Unexpected ' . static::class . '::end() call. A matching begin() is not found.'
            );
        }

        /** @var static $widget */
        $widget = array_pop(self::$stack);

        if (get_class($widget) !== static::class) {
            throw new RuntimeException('Expecting end() of ' . get_class($widget) . ', found ' . static::class . '.');
        }

        return $widget->render();
    }

    /**
     * Creates a widget instance.
     *
     * @param array<int,mixed> $constructorArguments Widget constructor arguments.
     *
     * @throws ReflectionException
     *
     * @return static widget instance
     */
    final public static function widget(array $constructorArguments = []): self
    {
        $widget = new ReflectionClass(static::class);
        $widget = $widget->newInstanceArgs($constructorArguments);

        return $widget;
    }

    /**
     * Executes the widget.
     *
     * @return string The result of widget execution to be outputted.
     */
    final public function render(): string
    {
        if (!$this->beforeRun()) {
            return '';
        }

        $result = $this->run();

        return $this->afterRun($result);
    }

    /**
     * This method is invoked right before the widget is executed.
     *
     * The return value of the method will determine whether the widget should continue to run.
     *
     * When overriding this method, make sure you call the parent implementation like the following:
     *
     * ```php
     * protected function beforeRun()
     * {
     *     if (!parent::beforeRun()) {
     *         return false;
     *     }
     *
     *     // your custom code here
     *
     *     return true; // or false to not run the widget
     * }
     * ```
     *
     * @return bool whether the widget should continue to be executed.
     */
    protected function beforeRun(): bool
    {
        return true;
    }

    /**
     * This method is invoked right after a widget is executed.
     *
     * The return value of the method will be used as the widget return value.
     *
     * If you override this method, your code should look like the following:
     *
     * ```php
     * protected function afterRun($result)
     * {
     *     $result = parent::afterRun($result);
     *
     *     // your custom code here
     *
     *     return $result;
     * }
     * ```
     *
     * @param string $result the widget return result.
     *
     * @return string the processed widget result.
     */
    protected function afterRun(string $result): string
    {
        return $result;
    }

    /**
     * Allows not to call `->render()` explicitly:
     *
     * ```php
     * <?= MyWidget::widget()->name('test') ?>
     * ```
     */
    final public function __toString(): string
    {
        return $this->render();
    }
}
