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
final class Fixture_Loader implements Fixture_Loader_Interface
{
    public function load(Suite_Interface $suite, Fixture_Interface $fixture, array $options): void
    {
        $fixture->load($options);
    }
}