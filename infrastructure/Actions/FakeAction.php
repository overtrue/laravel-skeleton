<?php

namespace Infrastructure\Actions;

use Closure;
use Illuminate\Support\Fluent;
use Mockery;
use Mockery\Expectation;
use Mockery\ExpectationInterface;
use Mockery\HigherOrderMessage;
use Mockery\Mock;
use Mockery\MockInterface;
use PHPUnit\Framework\Assert as PHPUnit;

class FakeAction
{
    protected static array $actions = [];
    protected static array $actionTimes = [];
    protected static array $instances = [];

    public function __construct(protected string $action)
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(...$arguments): mixed
    {
        self::$actions[$this->action] = $arguments;
        self::$actionTimes[$this->action] = (self::$actionTimes[$this->action] ?? 0) + 1;

        if (isset(self::$instances[$this->action])) {
            return self::$instances[$this->action]->handle(...$arguments);
        }

        return new Fluent();
    }

    public function spy(): MockInterface
    {
        return self::$instances[$this->action] = Mockery::spy($this->action);
    }

    public function fake(): Mockery\LegacyMockInterface|\Closure|MockInterface
    {
        self::$instances[$this->action] = Mockery::mock($this->action, function ($mock) {
            $mock->shouldAllowMockingProtectedMethods();
        });

        self::$instances[$this->action]->shouldReceive('handle')->andReturnNull();

        return self::$instances[$this->action];
    }

    public function partialMock(): Mock
    {
        self::$instances[$this->action] = Mockery::mock($this->action, function ($mock) {
            $mock->shouldAllowMockingProtectedMethods();
        });

        self::$instances[$this->action]->makePartial();

        return self::$instances[$this->action];
    }

    public function shouldReceive(string $method): ExpectationInterface|Expectation|HigherOrderMessage
    {
        if (empty(self::$instances[$this->action]) || !(self::$instances[$this->action] instanceof MockInterface)) {
            self::$instances[$this->action] = Mockery::mock('stdClass', function ($mock) {
                $mock->shouldAllowMockingProtectedMethods();
            });
        }

        return self::$instances[$this->action]->shouldReceive($method);
    }

    public function assertNotCalled(): void
    {
        PHPUnit::assertFalse(isset(self::$actions[$this->action]), "ActionType [{$this->action}] was called.");
    }

    public function assertCalled(): void
    {
        $this->assertCalledTimes(1);
    }

    public function assertCalledWith(array $arguments = []): void
    {
        PHPUnit::assertTrue(
            array_key_exists($this->action, self::$actions) && self::$actions[$this->action] === $arguments,
            "The expected [{$this->action}] action was not called."
        );
    }

    public function assertCalledTimes(int $times = 1): void
    {
        PHPUnit::assertTrue(
            array_key_exists($this->action, self::$actionTimes) && self::$actionTimes[$this->action] === $times,
            "The expected [{$this->action}] action was not called {$times} times."
        );
    }

    public function assertCalledWithClosure(Closure $callback): void
    {
        PHPUnit::assertTrue(
            array_key_exists($this->action, self::$actions) && $callback(...self::$actions[$this->action]),
            "The expected [{$this->action}] action was not called."
        );
    }
}
