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
final readonly class Suite_Loader implements Suite_Loader_Interface
{
    public function __construct(private Fixture_Loader_Interface $fixture_loader)
    {
    }
    public function load(Suite_Interface $suite): void
    {
        /** @var FixtureInterface $fixture */
        foreach ($suite->get_fixtures() as $fixture => $fixture_options) {
            $this->fixture_loader->load($suite, $fixture, $fixture_options);
        }
    }
}