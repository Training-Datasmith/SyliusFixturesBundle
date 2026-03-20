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
namespace Sylius\Bundle\Fixtures_Bundle\Loader;

use Sylius\Bundle\Fixtures_Bundle\Fixture\Fixture_Interface;
use Sylius\Bundle\Fixtures_Bundle\Listener\After_Fixture_Listener_Interface;
use Sylius\Bundle\Fixtures_Bundle\Listener\Before_Fixture_Listener_Interface;
use Sylius\Bundle\Fixtures_Bundle\Listener\Fixture_Event;
use Sylius\Bundle\Fixtures_Bundle\Suite\Suite_Interface;
final readonly class Hookable_Fixture_Loader implements Fixture_Loader_Interface
{
    public function __construct(private Fixture_Loader_Interface $decorated_fixture_loader)
    {
    }
    public function load(Suite_Interface $suite, Fixture_Interface $fixture, array $options): void
    {
        $fixture_event = new Fixture_Event($suite, $fixture, $options);
        $this->execute_before_fixture_listeners($suite, $fixture_event);
        $this->decorated_fixture_loader->load($suite, $fixture, $options);
        $this->execute_after_fixture_listeners($suite, $fixture_event);
    }
    private function execute_before_fixture_listeners(Suite_Interface $suite, Fixture_Event $fixture_event): void
    {
        foreach ($suite->get_listeners() as $listener => $listener_options) {
            if (!$listener instanceof Before_Fixture_Listener_Interface) {
                continue;
            }
            $listener->before_fixture($fixture_event, $listener_options);
        }
    }
    private function execute_after_fixture_listeners(Suite_Interface $suite, Fixture_Event $fixture_event): void
    {
        foreach ($suite->get_listeners() as $listener => $listener_options) {
            if (!$listener instanceof After_Fixture_Listener_Interface) {
                continue;
            }
            $listener->after_fixture($fixture_event, $listener_options);
        }
    }
}