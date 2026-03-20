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
namespace Sylius\Bundle\Fixtures_Bundle\Dependency_Injection\Compiler;

use Symfony\Component\Dependency_Injection\Compiler\Compiler_Pass_Interface;
use Symfony\Component\Dependency_Injection\Container_Builder;
use Symfony\Component\Dependency_Injection\Reference;
final class Fixture_Registry_Pass implements Compiler_Pass_Interface
{
    public const FIXTURE_SERVICE_TAG = 'sylius_fixtures.fixture';
    public function process(Container_Builder $container): void
    {
        if (!$container->has('sylius_fixtures.fixture_registry')) {
            return;
        }
        $fixture_registry = $container->find_definition('sylius_fixtures.fixture_registry');
        $tagged_services = $container->find_tagged_service_ids(self::FIXTURE_SERVICE_TAG);
        foreach (array_keys($tagged_services) as $id) {
            $fixture_registry->add_method_call('addFixture', [new Reference($id)]);
        }
    }
}