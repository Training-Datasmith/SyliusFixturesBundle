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

use Sylius\Bundle\Fixtures_Bundle\Loader\Suite_Loader_Interface;
use Sylius\Bundle\Fixtures_Bundle\Suite\Suite_Registry_Interface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Question_Helper;
use Symfony\Component\Console\Input\Input_Argument;
use Symfony\Component\Console\Input\Input_Interface;
use Symfony\Component\Console\Output\Output_Interface;
use Symfony\Component\Console\Question\Confirmation_Question;
final class Fixtures_Load_Command extends Command
{
    public function __construct(private readonly Suite_Registry_Interface $suite_registry, private readonly Suite_Loader_Interface $suite_loader, private readonly string $environment)
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this->set_name('sylius:fixtures:load')->set_description('Loads fixtures from given suite')->add_argument('suite', Input_Argument::OPTIONAL, 'Suite name', 'default');
    }
    protected function execute(Input_Interface $input, Output_Interface $output): int
    {
        if ($input->is_interactive()) {
            /** @var QuestionHelper $questionHelper */
            $question_helper = $this->get_helper('question');
            $output->writeln(sprintf("\n<error>Warning! Loading fixtures may purge your database for the %s environment (if `orm_purger` is used in your suite).</error>\n", $this->environment));
            if (!$question_helper->ask($input, $output, new Confirmation_Question('Continue? (y/N) ', false))) {
                return 1;
            }
        }
        $this->load_suites($input);
        return 0;
    }
    private function load_suites(Input_Interface $input): void
    {
        $suite_name = $input->get_argument('suite');
        assert(is_string($suite_name));
        $suite = $this->suite_registry->get_suite($suite_name);
        $this->suite_loader->load($suite);
    }
}