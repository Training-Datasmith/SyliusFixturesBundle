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
namespace Sylius\Bundle\Fixtures_Bundle\Command;

use Sylius\Bundle\Fixtures_Bundle\Fixture\Fixture_Registry_Interface;
use Sylius\Bundle\Fixtures_Bundle\Suite\Suite_Registry_Interface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\Input_Interface;
use Symfony\Component\Console\Output\Output_Interface;
final class Fixtures_List_Command extends Command
{
    public function __construct(private readonly Suite_Registry_Interface $suite_registry, private readonly Fixture_Registry_Interface $fixture_registry)
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this->set_name('sylius:fixtures:list')->set_description('Lists available fixtures');
    }
    protected function execute(Input_Interface $input, Output_Interface $output): int
    {
        $this->list_suites($output);
        $this->list_fixtures($output);
        return 0;
    }
    private function list_suites(Output_Interface $output): void
    {
        $suites = $this->suite_registry->get_suites();
        $output->writeln('Available suites:');
        foreach ($suites as $suite) {
            $output->writeln(' - ' . $suite->get_name());
        }
    }
    private function list_fixtures(Output_Interface $output): void
    {
        $fixtures = $this->fixture_registry->get_fixtures();
        $output->writeln('Available fixtures:');
        foreach ($fixtures as $name => $fixture) {
            $output->writeln(' - ' . $name);
        }
    }
}