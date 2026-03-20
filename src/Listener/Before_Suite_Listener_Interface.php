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

interface Before_Suite_Listener_Interface extends Listener_Interface
{
    /** @param array<mixed> $options */
    public function before_suite(Suite_Event $suite_event, array $options): void;
}