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

use Symfony\Component\Config\Definition\Builder\Array_Node_Definition;
use Symfony\Component\Config\Definition\Builder\Tree_Builder;
use Symfony\Component\Config\Definition\Configuration_Interface;
final class Configuration implements Configuration_Interface
{
    public function get_config_tree_builder(): Tree_Builder
    {
        $tree_builder = new Tree_Builder('sylius_fixtures');
        /** @var ArrayNodeDefinition $rootNode */
        $root_node = $tree_builder->get_root_node();
        $this->build_suites_node($root_node);
        return $tree_builder;
    }
    private function build_suites_node(Array_Node_Definition $root_node): void
    {
        /** @var ArrayNodeDefinition $suitesNode */
        $suites_node = $root_node->children()->array_node('suites')->use_attribute_as_key('name')->array_prototype();
        $suites_node->validate()->if_array()->then(static function (array $value): array {
            if (!isset($value['fixtures'])) {
                return $value;
            }
            foreach ($value['fixtures'] as $fixture_key => &$fixture_value) {
                if (!isset($fixture_value['name'])) {
                    $fixture_value['name'] = $fixture_key;
                }
            }
            return $value;
        });
        $this->build_fixtures_node($suites_node);
        $this->build_listeners_node($suites_node);
    }
    private function build_fixtures_node(Array_Node_Definition $suites_node): void
    {
        /** @var ArrayNodeDefinition $fixturesNode */
        $fixtures_node = $suites_node->children()->array_node('fixtures')->use_attribute_as_key('alias')->array_prototype();
        $fixtures_node->children()->scalar_node('name')->cannot_be_empty();
        $this->build_attributes_node($fixtures_node);
    }
    private function build_listeners_node(Array_Node_Definition $suites_node): void
    {
        /** @var ArrayNodeDefinition $listenersNode */
        $listeners_node = $suites_node->children()->array_node('listeners')->use_attribute_as_key('name')->array_prototype();
        $this->build_attributes_node($listeners_node);
    }
    private function build_attributes_node(Array_Node_Definition $node): void
    {
        $attributes_node_builder = $node->can_be_unset()->children();
        $attributes_node_builder->integer_node('priority')->default_value(0);
        /** @var ArrayNodeDefinition $optionsNode */
        $options_node = $attributes_node_builder->array_node('options');
        $options_node->add_default_children_if_none_set();
        $options_node->validate()->if_true(static function (array $values): bool {
            foreach ($values as $value) {
                if (!is_array($value)) {
                    return true;
                }
            }
            return false;
        })->then_invalid('Options have to be an array!');
        $options_node->before_normalization()->always(
            /** @param mixed $value */
            static fn($value): array => [$value]
        );
        $options_node->variable_prototype()->cannot_be_empty()->default_value([]);
    }
}