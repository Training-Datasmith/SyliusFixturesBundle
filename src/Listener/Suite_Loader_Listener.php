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
namespace Sylius\Bundle\Fixtures_Bundle\Listener;

use Sylius\Bundle\Fixtures_Bundle\Loader\Suite_Loader_Interface;
use Sylius\Bundle\Fixtures_Bundle\Suite\Suite_Registry_Interface;
use Symfony\Component\Config\Definition\Builder\Array_Node_Definition;
final class Suite_Loader_Listener extends Abstract_Listener implements Before_Suite_Listener_Interface
{
    public function __construct(private readonly Suite_Registry_Interface $suite_registry, private readonly Suite_Loader_Interface $suite_loader)
    {
    }
    public function get_name(): string
    {
        return 'suite_loader';
    }
    /** @param array{suites: string[]} $options */
    public function before_suite(Suite_Event $suite_event, array $options): void
    {
        foreach ($options['suites'] as $suite_name) {
            $suite = $this->suite_registry->get_suite($suite_name);
            $this->suite_loader->load($suite);
        }
    }
    protected function configure_options_node(Array_Node_Definition $options_node): void
    {
        $options_node->children()->array_node('suites')->requires_at_least_one_element()->perform_no_deep_merging()->prototype('scalar')->end();
    }
}