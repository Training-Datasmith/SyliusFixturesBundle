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

use Psr\Log\Logger_Interface;
final class Logger_Listener extends Abstract_Listener implements Before_Suite_Listener_Interface, Before_Fixture_Listener_Interface
{
    public function __construct(private readonly Logger_Interface $logger)
    {
    }
    /** @param array<mixed> $options */
    public function before_suite(Suite_Event $suite_event, array $options): void
    {
        $this->logger->notice(sprintf('Running suite "%s"...', $suite_event->suite()->get_name()));
    }
    /** @param array<mixed> $options */
    public function before_fixture(Fixture_Event $fixture_event, array $options): void
    {
        $this->logger->notice(sprintf('Running fixture "%s"...', $fixture_event->fixture()->get_name()));
    }
    public function get_name(): string
    {
        return 'logger';
    }
}