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
namespace Sylius\Bundle\Fixtures_Bundle\Listener;

use Webmozart\Assert\Assert;
final class Listener_Registry implements Listener_Registry_Interface
{
    /** @var array<string, ListenerInterface> */
    private array $listeners = [];
    public function add_listener(Listener_Interface $listener): void
    {
        Assert::key_not_exists($this->listeners, $listener->get_name(), 'Listener with name "%s" is already registered.');
        $this->listeners[$listener->get_name()] = $listener;
    }
    public function get_listener(string $name): Listener_Interface
    {
        if (!isset($this->listeners[$name])) {
            throw new Listener_Not_Found_Exception($name);
        }
        return $this->listeners[$name];
    }
    public function get_listeners(): array
    {
        return $this->listeners;
    }
}