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
namespace Symfony\Component\Dependency_Injection\Loader\Configurator;

use Sylius\Bundle\Fixtures_Bundle\Loader\Fixture_Loader;
use Sylius\Bundle\Fixtures_Bundle\Loader\Fixture_Loader_Interface;
use Sylius\Bundle\Fixtures_Bundle\Loader\Hookable_Fixture_Loader;
use Sylius\Bundle\Fixtures_Bundle\Loader\Hookable_Suite_Loader;
use Sylius\Bundle\Fixtures_Bundle\Loader\Suite_Loader;
use Sylius\Bundle\Fixtures_Bundle\Loader\Suite_Loader_Interface;
return static function (Container_Configurator $container): void {
    $services = $container->services();
    $services->defaults()->public();
    $services->set('sylius_fixtures.fixture_loader', Hookable_Fixture_Loader::class)->args([inline_service(Fixture_Loader::class)]);
    $services->alias(Fixture_Loader_Interface::class, 'sylius_fixtures.fixture_loader');
    $services->set('sylius_fixtures.suite_loader', Hookable_Suite_Loader::class)->args([inline_service(Suite_Loader::class)->args([service('sylius_fixtures.fixture_loader')])]);
    $services->alias(Suite_Loader_Interface::class, 'sylius_fixtures.suite_loader');
};