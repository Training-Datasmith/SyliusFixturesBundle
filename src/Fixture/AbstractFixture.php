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

use Symfony\Component\Config\Definition\Builder\Array_Node_Definition;
use Symfony\Component\Config\Definition\Builder\Tree_Builder;
abstract class Abstract_Fixture implements Fixture_Interface
{
    final public function get_config_tree_builder(): Tree_Builder
    {
        $tree_builder = new Tree_Builder($this->get_name());
        /** @var ArrayNodeDefinition $optionsNode */
        $options_node = $tree_builder->get_root_node();
        $this->configure_options_node($options_node);
        return $tree_builder;
    }
    protected function configure_options_node(Array_Node_Definition $options_node): void
    {
        // empty
    }
}