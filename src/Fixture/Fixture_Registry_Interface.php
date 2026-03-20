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
namespace Sylius\Bundle\Fixtures_Bundle\Fixture;

interface Fixture_Registry_Interface
{
    /**
     * @throws FixtureNotFoundException
     */
    public function get_fixture(string $name): Fixture_Interface;
    /**
     * @return array|FixtureInterface[] Name indexed
     */
    public function get_fixtures(): array;
}