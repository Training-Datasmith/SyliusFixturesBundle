<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace Sylius\Bundle\Fixtures_Bundle\Suite;

use Sylius\Bundle\Fixtures_Bundle\Fixture\Fixture_Interface;
use Sylius\Bundle\Fixtures_Bundle\Listener\Listener_Interface;
final readonly class Suite implements Suite_Interface
{
    private Priority_Queue $fixtures;
    private Priority_Queue $listeners;
    public function __construct(private string $name)
    {
        $this->fixtures = new Priority_Queue();
        $this->listeners = new Priority_Queue();
    }
    /** @param array<mixed> $options */
    public function add_fixture(Fixture_Interface $fixture, array $options, int $priority = 0): void
    {
        $this->fixtures->insert(['fixture' => $fixture, 'options' => $options], $priority);
    }
    /** @param array<mixed> $options */
    public function add_listener(Listener_Interface $listener, array $options, int $priority = 0): void
    {
        $this->listeners->insert(['listener' => $listener, 'options' => $options], $priority);
    }
    public function get_name(): string
    {
        return $this->name;
    }
    public function get_fixtures(): iterable
    {
        foreach ($this->fixtures as $fixture) {
            yield $fixture['fixture'] => $fixture['options'];
        }
    }
    public function get_listeners(): iterable
    {
        foreach ($this->listeners as $listener) {
            yield $listener['listener'] => $listener['options'];
        }
    }
}