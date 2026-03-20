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

final class Lazy_Suite_Registry implements Suite_Registry_Interface
{
    /** @var array<string, array<mixed>> */
    private array $suite_definitions = [];
    /** @var array<string, SuiteInterface> */
    private array $suites = [];
    public function __construct(private readonly Suite_Factory_Interface $suite_factory)
    {
    }
    /** @param array<mixed> $configuration */
    public function add_suite(string $name, array $configuration): void
    {
        $this->suite_definitions[$name] = $configuration;
    }
    public function get_suite(string $name): Suite_Interface
    {
        if (isset($this->suites[$name])) {
            return $this->suites[$name];
        }
        if (!isset($this->suite_definitions[$name])) {
            throw new Suite_Not_Found_Exception($name);
        }
        return $this->suites[$name] = $this->suite_factory->create_suite($name, $this->suite_definitions[$name]);
    }
    public function get_suites(): array
    {
        $suites = [];
        foreach (array_keys($this->suite_definitions) as $name) {
            $suites[$name] = $this->get_suite($name);
        }
        return $suites;
    }
}