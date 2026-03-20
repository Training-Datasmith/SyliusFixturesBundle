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
/**
 * Base class for Sylius fixtures.
 *
 * Subclasses must implement Fixture_Interface::get_name() and Fixture_Interface::load().
 * Override configure_options_node() to declare fixture options via the Symfony Config tree builder.
 */
abstract class Abstract_Fixture implements Fixture_Interface
{
    /**
     * Builds the configuration tree for this fixture's options.
     *
     * The tree root node is named after the fixture's getName() value.
     * Options declared in configure_options_node() will be validated and
     * normalised before being passed to load().
     *
     * @return Tree_Builder The configuration tree builder for this fixture
     */
    final public function get_config_tree_builder(): Tree_Builder
    {
        $tree_builder = new Tree_Builder($this->get_name());
        /** @var Array_Node_Definition $options_node */
        $options_node = $tree_builder->get_root_node();
        $this->configure_options_node($options_node);
        return $tree_builder;
    }

    /**
     * Declares the accepted options for this fixture using the Symfony Config tree builder.
     *
     * Override this method in a subclass to add typed, validated, and normalised option
     * definitions. Options defined here will be available in the $options array passed to load().
     *
     * @param Array_Node_Definition $options_node The root node of the options tree to configure
     *
     * @return void
     */
    protected function configure_options_node(Array_Node_Definition $options_node): void
    {
        // empty — override in subclass to declare fixture options
    }
}