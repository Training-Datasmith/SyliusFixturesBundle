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
namespace Sylius\Bundle\Fixtures_Bundle\Suite;

use Sylius\Bundle\Fixtures_Bundle\Fixture\Fixture_Registry_Interface;
use Sylius\Bundle\Fixtures_Bundle\Listener\Listener_Registry_Interface;
use Symfony\Component\Config\Definition\Processor;
use Webmozart\Assert\Assert;
final readonly class Suite_Factory implements Suite_Factory_Interface
{
    public function __construct(private Fixture_Registry_Interface $fixture_registry, private Listener_Registry_Interface $listener_registry, private Processor $options_processor)
    {
    }
    public function create_suite(string $name, array $configuration): Suite_Interface
    {
        Assert::key_exists($configuration, 'fixtures');
        Assert::key_exists($configuration, 'listeners');
        $suite = new Suite($name);
        foreach ($configuration['fixtures'] as $fixture_attributes) {
            $this->add_fixture_to_suite($suite, $fixture_attributes);
        }
        foreach ($configuration['listeners'] as $listener_name => $listener_attributes) {
            $this->add_listener_to_suite($suite, $listener_name, $listener_attributes);
        }
        return $suite;
    }
    /** @param array{name: string, options: array<mixed>, priority: ?int} $fixtureAttributes */
    private function add_fixture_to_suite(Suite $suite, array $fixture_attributes): void
    {
        Assert::key_exists($fixture_attributes, 'name');
        Assert::key_exists($fixture_attributes, 'options');
        $fixture = $this->fixture_registry->get_fixture($fixture_attributes['name']);
        $fixture_options = $this->options_processor->process_configuration($fixture, $fixture_attributes['options']);
        $fixture_priority = $fixture_attributes['priority'] ?? 0;
        $suite->add_fixture($fixture, $fixture_options, $fixture_priority);
    }
    /** @param array{name: string, options: array<mixed>, priority: ?int} $listenerAttributes */
    private function add_listener_to_suite(Suite $suite, string $listener_name, array $listener_attributes): void
    {
        Assert::key_exists($listener_attributes, 'options');
        $listener = $this->listener_registry->get_listener($listener_name);
        $listener_options = $this->options_processor->process_configuration($listener, $listener_attributes['options']);
        $listener_priority = $listener_attributes['priority'] ?? 0;
        $suite->add_listener($listener, $listener_options, $listener_priority);
    }
}