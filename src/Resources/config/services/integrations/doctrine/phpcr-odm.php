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

use Sylius\Bundle\Fixtures_Bundle\Listener\Phpcr_Purger_Listener;
return static function (Container_Configurator $container): void {
    $services = $container->services();
    $services->defaults()->public();
    $services->set('sylius_fixtures.listener.phpcr_purger', Phpcr_Purger_Listener::class)->private()->args([service('doctrine_phpcr')])->tag('sylius_fixtures.listener');
};