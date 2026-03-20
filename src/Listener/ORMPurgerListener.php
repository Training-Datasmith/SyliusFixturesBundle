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

use Doctrine\Common\Data_Fixtures\Purger\Orm_Purger;
use Doctrine\ORM\Entity_Manager_Interface;
use Doctrine\Persistence\Manager_Registry;
use Symfony\Component\Config\Definition\Builder\Array_Node_Definition;
final class Orm_Purger_Listener extends Abstract_Listener implements Before_Suite_Listener_Interface
{
    /** @var array<string, int> */
    private static array $purge_modes = ['delete' => Orm_Purger::PURGE_MODE_DELETE, 'truncate' => Orm_Purger::PURGE_MODE_TRUNCATE];
    public function __construct(private readonly Manager_Registry $manager_registry)
    {
    }
    /** @param array{managers: string[], exclude: array<int|string>, mode: string} $options */
    public function before_suite(Suite_Event $suite_event, array $options): void
    {
        foreach ($options['managers'] as $manager_name) {
            /** @var EntityManagerInterface $manager */
            $manager = $this->manager_registry->get_manager($manager_name);
            $purger = new Orm_Purger($manager, $options['exclude']);
            $purger->set_purge_mode(self::$purge_modes[$options['mode']]);
            $purger->purge();
        }
    }
    public function get_name(): string
    {
        return 'orm_purger';
    }
    protected function configure_options_node(Array_Node_Definition $options_node): void
    {
        $options_node_builder = $options_node->children();
        $options_node_builder->enum_node('mode')->values(['delete', 'truncate'])->default_value('delete');
        $options_node_builder->array_node('managers')->default_value([null])->scalar_prototype();
        $options_node_builder->array_node('exclude')->default_value([])->scalar_prototype();
    }
}