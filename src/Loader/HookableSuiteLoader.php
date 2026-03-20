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

use Sylius\Bundle\Fixtures_Bundle\Listener\After_Suite_Listener_Interface;
use Sylius\Bundle\Fixtures_Bundle\Listener\Before_Suite_Listener_Interface;
use Sylius\Bundle\Fixtures_Bundle\Listener\Suite_Event;
use Sylius\Bundle\Fixtures_Bundle\Suite\Suite_Interface;
final readonly class Hookable_Suite_Loader implements Suite_Loader_Interface
{
    public function __construct(private Suite_Loader_Interface $decorated_suite_loader)
    {
    }
    public function load(Suite_Interface $suite): void
    {
        $suite_event = new Suite_Event($suite);
        $this->execute_before_suite_listeners($suite, $suite_event);
        $this->decorated_suite_loader->load($suite);
        $this->execute_after_suite_listeners($suite, $suite_event);
    }
    private function execute_before_suite_listeners(Suite_Interface $suite, Suite_Event $suite_event): void
    {
        foreach ($suite->get_listeners() as $listener => $listener_options) {
            if (!$listener instanceof Before_Suite_Listener_Interface) {
                continue;
            }
            $listener->before_suite($suite_event, $listener_options);
        }
    }
    private function execute_after_suite_listeners(Suite_Interface $suite, Suite_Event $suite_event): void
    {
        foreach ($suite->get_listeners() as $listener => $listener_options) {
            if (!$listener instanceof After_Suite_Listener_Interface) {
                continue;
            }
            $listener->after_suite($suite_event, $listener_options);
        }
    }
}