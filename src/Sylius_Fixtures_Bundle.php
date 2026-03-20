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
namespace Sylius\Bundle\Fixtures_Bundle;

use Sylius\Bundle\Fixtures_Bundle\Dependency_Injection\Compiler\Fixture_Registry_Pass;
use Sylius\Bundle\Fixtures_Bundle\Dependency_Injection\Compiler\Listener_Registry_Pass;
use Symfony\Component\Dependency_Injection\Container_Builder;
use Symfony\Component\Http_Kernel\Bundle\Bundle;
final class Sylius_Fixtures_Bundle extends Bundle
{
    public function build(Container_Builder $container): void
    {
        parent::build($container);
        $container->add_compiler_pass(new Fixture_Registry_Pass());
        $container->add_compiler_pass(new Listener_Registry_Pass());
    }
}