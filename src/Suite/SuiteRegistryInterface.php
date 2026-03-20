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

interface Suite_Registry_Interface
{
    /**
     * @throws SuiteNotFoundException
     */
    public function get_suite(string $name): Suite_Interface;
    /**
     * @return array|SuiteInterface[]
     */
    public function get_suites(): array;
}