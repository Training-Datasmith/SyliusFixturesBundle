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

interface Suite_Factory_Interface
{
    /** @param array<string, array<mixed>> $configuration */
    public function create_suite(string $name, array $configuration): Suite_Interface;
}