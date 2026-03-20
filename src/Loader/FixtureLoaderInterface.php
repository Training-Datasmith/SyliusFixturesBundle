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
use Sylius\Bundle\Fixtures_Bundle\Suite\Suite_Interface;
interface Fixture_Loader_Interface
{
    /** @param array<mixed> $options */
    public function load(Suite_Interface $suite, Fixture_Interface $fixture, array $options): void;
}