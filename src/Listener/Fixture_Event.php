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

use Sylius\Bundle\Fixtures_Bundle\Fixture\Fixture_Interface;
use Sylius\Bundle\Fixtures_Bundle\Suite\Suite_Interface;
final readonly class Fixture_Event
{
    /** @param array<mixed> $fixtureOptions */
    public function __construct(private Suite_Interface $suite, private Fixture_Interface $fixture, private array $fixture_options)
    {
    }
    public function suite(): Suite_Interface
    {
        return $this->suite;
    }
    public function fixture(): Fixture_Interface
    {
        return $this->fixture;
    }
    /** @return array<mixed> */
    public function fixture_options(): array
    {
        return $this->fixture_options;
    }
}