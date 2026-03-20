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

use Sylius\Bundle\Fixtures_Bundle\Suite\Lazy_Suite_Registry;
use Sylius\Bundle\Fixtures_Bundle\Suite\Suite_Factory;
use Sylius\Bundle\Fixtures_Bundle\Suite\Suite_Factory_Interface;
use Sylius\Bundle\Fixtures_Bundle\Suite\Suite_Registry_Interface;
use Symfony\Component\Config\Definition\Processor;
return static function (Container_Configurator $container): void {
    $services = $container->services();
    $services->defaults()->public();
    $services->set('sylius_fixtures.suite_factory', Suite_Factory::class)->private()->args([service('sylius_fixtures.fixture_registry'), service('sylius_fixtures.listener_registry'), inline_service(Processor::class)]);
    $services->alias(Suite_Factory_Interface::class, 'sylius_fixtures.suite_factory');
    $services->set('sylius_fixtures.suite_registry', Lazy_Suite_Registry::class)->args([service('sylius_fixtures.suite_factory')]);
    $services->alias(Suite_Registry_Interface::class, 'sylius_fixtures.suite_registry');
};