<?php

namespace Infrastructure\Actions;

use Illuminate\Support\Fluent;
use Mockery\CompositeExpectation;
use Mockery\Expectation;
use Mockery\ExpectationInterface;
use Mockery\HigherOrderMessage;
use Mockery\MockInterface;

/**
 * @method static CompositeExpectation spy(string $method)
 * @method static CompositeExpectation shouldReceive(string $method)
 * @method static void assertCalled()
 * @method static void assertCalledWith(array $arguments = [])
 * @method static void assertNotCalled()
 * @method static void assertCalledTimes(int $times)
 * @method static void assertCalledWithClosure(\Closure $arguments = [])
 */
abstract class Action
{
    protected static $fakeWhenTesting = false;

    protected static $fakeResult = null;

    protected static array $instances = [];

    public static function run(...$arguments): mixed
    {
        if (app()->runningUnitTests() && static::$fakeWhenTesting) {
            self::fake();
        }

        return self::make(static::class)->handle(...$arguments);
    }

    public static function runIf($boolean, ...$arguments)
    {
        return $boolean ? static::run(...$arguments) : new Fluent();
    }

    public static function runUnless($boolean, ...$arguments)
    {
        return static::runIf(! $boolean, ...$arguments);
    }

    //    abstract public function handle(...$arguments): mixed;

    public static function make(string $action)
    {
        return self::$instances[$action] ??= app($action);
    }

    public static function shouldReturn(mixed $value): HigherOrderMessage|Expectation|ExpectationInterface
    {
        return self::fake($value);
    }

    public static function shouldRunWith(...$arguments): HigherOrderMessage|Expectation|ExpectationInterface
    {
        return self::mock(static::class)->shouldReceive('handle')->with(...$arguments)->andReturn(self::$fakeResult);
    }

    public static function shouldRunOnce(): HigherOrderMessage|Expectation|ExpectationInterface
    {
        return self::shouldRunTimes(1);
    }

    public static function shouldNeverRun(): HigherOrderMessage|Expectation|ExpectationInterface
    {
        return self::shouldRunTimes(0);
    }

    public static function shouldRunTimes(int $times = 1): HigherOrderMessage|Expectation|ExpectationInterface
    {
        return self::mock(static::class)->shouldReceive('handle')->times($times)->andReturn(self::$fakeResult);
    }

    public static function fake(mixed $result = null): Expectation|ExpectationInterface|HigherOrderMessage
    {
        return self::mock(static::class)->shouldReceive('handle')->andReturn($result ?? static::$fakeResult);
    }

    public static function mock(string $action)
    {
        if (empty(self::$instances[$action]) || ! (self::$instances[$action] instanceof MockInterface)) {
            self::$instances[$action] = new FakeAction(static::class);
        }

        return self::$instances[$action];
    }

    /**
     * @throws \Exception
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (in_array($name, ['spy', 'fake', 'partialMock', 'shouldReceive', 'assertCalled', 'assertCalledWith', 'assertNotCalled', 'assertCalledTimes', 'assertCalledWithClosure'])) {
            return self::mock(static::class)->$name(...$arguments);
        }

        throw new \Exception("Method [$name] does not exist.");
    }
}
