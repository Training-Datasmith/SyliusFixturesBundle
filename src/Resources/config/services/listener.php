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

use Sylius\Bundle\Fixtures_Bundle\Listener\Listener_Registry;
use Sylius\Bundle\Fixtures_Bundle\Listener\Listener_Registry_Interface;
use Sylius\Bundle\Fixtures_Bundle\Listener\Logger_Listener;
use Sylius\Bundle\Fixtures_Bundle\Listener\Suite_Loader_Listener;
return static function (Container_Configurator $container): void {
    $services = $container->services();
    $parameters = $container->parameters();
    $services->defaults()->public();
    $services->set('sylius_fixtures.listener_registry', Listener_Registry::class)->private();
    $services->alias(Listener_Registry_Interface::class, 'sylius_fixtures.listener_registry');
    $services->set('sylius_fixtures.listener.suite_loader_listener', Suite_Loader_Listener::class)->args([service('sylius_fixtures.suite_registry'), service('sylius_fixtures.suite_loader')])->tag('sylius_fixtures.listener');
    $services->set('sylius_fixtures.listener.logger', Logger_Listener::class)->private()->args([service('sylius_fixtures.logger')])->tag('sylius_fixtures.listener');
};