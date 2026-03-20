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
namespace Sylius\Bundle\Fixtures_Bundle\Fixture;

use Webmozart\Assert\Assert;
/**
 * In-memory registry of all registered fixture classes.
 *
 * Fixtures are registered by the DI compiler pass and accessed by name during
 * suite loading. Duplicate names are rejected immediately at registration time
 * to catch misconfiguration early.
 */
final class Fixture_Registry implements Fixture_Registry_Interface
{
    /** @var array<string, Fixture_Interface> Map of fixture name => fixture instance */
    private array $fixtures = [];

    /**
     * Registers a fixture in the registry under its declared name.
     *
     * @param Fixture_Interface $fixture The fixture to register
     *
     * @return void
     *
     * @throws \InvalidArgumentException If a fixture with the same name is already registered
     */
    public function add_fixture(Fixture_Interface $fixture): void
    {
        Assert::key_not_exists($this->fixtures, $fixture->get_name(), 'Fixture with name "%s" is already registered.');
        $this->fixtures[$fixture->get_name()] = $fixture;
    }

    /**
     * Returns a fixture by its registered name.
     *
     * @param string $name The fixture name as returned by Fixture_Interface::get_name()
     *
     * @return Fixture_Interface The registered fixture instance
     *
     * @throws Fixture_Not_Found_Exception If no fixture is registered under $name
     */
    public function get_fixture(string $name): Fixture_Interface
    {
        if (!isset($this->fixtures[$name])) {
            throw new Fixture_Not_Found_Exception($name);
        }
        return $this->fixtures[$name];
    }

    /**
     * Returns all registered fixtures keyed by their name.
     *
     * @return array<string, Fixture_Interface> All registered fixtures
     */
    public function get_fixtures(): array
    {
        return $this->fixtures;
    }
}