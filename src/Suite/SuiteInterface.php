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
interface Suite_Interface
{
    public function get_name(): string;
    /**
     * @return iterable<FixtureInterface, array<mixed>> Fixtures as keys, options as values
     */
    public function get_fixtures(): iterable;
    /**
     * @see \Sylius\Bundle\FixturesBundle\Listener\ListenerInterface
     *
     * @return iterable<ListenerInterface, array<mixed>> Listeners as keys, options as values
     */
    public function get_listeners(): iterable;
}