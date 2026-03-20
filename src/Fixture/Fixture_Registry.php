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
final class Fixture_Registry implements Fixture_Registry_Interface
{
    /** @var array<string, FixtureInterface> */
    private array $fixtures = [];
    public function add_fixture(Fixture_Interface $fixture): void
    {
        Assert::key_not_exists($this->fixtures, $fixture->get_name(), 'Fixture with name "%s" is already registered.');
        $this->fixtures[$fixture->get_name()] = $fixture;
    }
    public function get_fixture(string $name): Fixture_Interface
    {
        if (!isset($this->fixtures[$name])) {
            throw new Fixture_Not_Found_Exception($name);
        }
        return $this->fixtures[$name];
    }
    public function get_fixtures(): array
    {
        return $this->fixtures;
    }
}