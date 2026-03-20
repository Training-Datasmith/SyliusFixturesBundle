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

use Sylius\Bundle\Fixtures_Bundle\Suite\Suite_Interface;
final readonly class Suite_Event
{
    public function __construct(private Suite_Interface $suite)
    {
    }
    public function suite(): Suite_Interface
    {
        return $this->suite;
    }
}