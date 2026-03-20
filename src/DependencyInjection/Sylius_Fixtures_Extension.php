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
namespace Sylius\Bundle\Fixtures_Bundle\Dependency_Injection;

use Sylius\Bundle\Fixtures_Bundle\Dependency_Injection\Compiler\Fixture_Registry_Pass;
use Sylius\Bundle\Fixtures_Bundle\Dependency_Injection\Compiler\Listener_Registry_Pass;
use Sylius\Bundle\Fixtures_Bundle\Fixture\Fixture_Interface;
use Sylius\Bundle\Fixtures_Bundle\Listener\Listener_Interface;
use Symfony\Component\Config\Definition\Configuration_Interface;
use Symfony\Component\Config\File_Locator;
use Symfony\Component\Dependency_Injection\Container_Builder;
use Symfony\Component\Dependency_Injection\Extension\Prepend_Extension_Interface;
use Symfony\Component\Dependency_Injection\Loader\Php_File_Loader;
use Symfony\Component\Http_Kernel\Dependency_Injection\Extension;
final class Sylius_Fixtures_Extension extends Extension implements Prepend_Extension_Interface
{
    /** @param array<mixed> $config */
    public function get_configuration(array $config, Container_Builder $container): Configuration_Interface
    {
        return new Configuration();
    }
    /** @param array<array<mixed>> $configs */
    public function load(array $configs, Container_Builder $container): void
    {
        $config = $this->process_configuration($this->get_configuration([], $container), $configs);
        $loader = new Php_File_Loader($container, new File_Locator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');
        $this->register_suites($config, $container);
        $container->register_for_autoconfiguration(Fixture_Interface::class)->add_tag(Fixture_Registry_Pass::FIXTURE_SERVICE_TAG);
        $container->register_for_autoconfiguration(Listener_Interface::class)->add_tag(Listener_Registry_Pass::LISTENER_SERVICE_TAG);
    }
    public function prepend(Container_Builder $container): void
    {
        $loader = new Php_File_Loader($container, new File_Locator(__DIR__ . '/../Resources/config'));
        $extensions_names_to_configuration_files = ['doctrine' => 'doctrine/orm.php', 'doctrine_mongodb' => 'doctrine/mongodb-odm.php', 'doctrine_phpcr' => 'doctrine/phpcr-odm.php'];
        foreach ($extensions_names_to_configuration_files as $extension_name => $configuration_file) {
            if (!$container->has_extension($extension_name)) {
                continue;
            }
            $loader->load('services/integrations/' . $configuration_file);
        }
    }
    /** @param array{suites: array<string, array<mixed>>} $config */
    private function register_suites(array $config, Container_Builder $container): void
    {
        $suite_registry = $container->find_definition('sylius_fixtures.suite_registry');
        foreach ($config['suites'] as $suite_name => $suite_configuration) {
            $suite_registry->add_method_call('addSuite', [$suite_name, $suite_configuration]);
        }
    }
}