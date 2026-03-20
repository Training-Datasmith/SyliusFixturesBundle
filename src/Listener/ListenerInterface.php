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

use Symfony\Component\Config\Definition\Configuration_Interface;
interface Listener_Interface extends Configuration_Interface
{
    public function get_name(): string;
}