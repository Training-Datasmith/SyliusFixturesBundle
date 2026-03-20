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

interface After_Fixture_Listener_Interface extends Listener_Interface
{
    /** @param array<mixed> $options */
    public function after_fixture(Fixture_Event $fixture_event, array $options): void;
}