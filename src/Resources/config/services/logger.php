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

use Monolog\Logger;
use Symfony\Bridge\Monolog\Formatter\Console_Formatter;
use Symfony\Bridge\Monolog\Handler\Console_Handler;
return static function (Container_Configurator $container): void {
    $services = $container->services();
    $services->defaults()->public();
    $services->set('sylius_fixtures.logger', Logger::class)->args(['sylius_fixtures', [service('sylius_fixtures.logger.handler.console')]]);
    $services->set('sylius_fixtures.logger.handler.console', Console_Handler::class)->args([null, true, ['32' => Logger::NOTICE, '64' => Logger::INFO]])->tag('kernel.event_subscriber')->call('setFormatter', [service('sylius_fixtures.logger.formatter.console')]);
    $services->set('sylius_fixtures.logger.formatter.console', Console_Formatter::class)->args([['format' => '%%message%% %%context%% %%extra%%
']]);
};