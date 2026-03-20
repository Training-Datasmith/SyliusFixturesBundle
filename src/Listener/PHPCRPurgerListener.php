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

use Doctrine\Common\Data_Fixtures\Purger\Phpcr_Purger;
use Doctrine\ODM\PHPCR\Document_Manager_Interface;
use Doctrine\Persistence\Manager_Registry;
use Symfony\Component\Config\Definition\Builder\Array_Node_Definition;
final class Phpcr_Purger_Listener extends Abstract_Listener implements Before_Suite_Listener_Interface
{
    public function __construct(private readonly Manager_Registry $manager_registry)
    {
    }
    /** @param array{managers: string[]} $options */
    public function before_suite(Suite_Event $suite_event, array $options): void
    {
        foreach ($options['managers'] as $manager_name) {
            /** @var DocumentManagerInterface $manager */
            $manager = $this->manager_registry->get_manager($manager_name);
            $purger = new Phpcr_Purger($manager);
            $purger->purge();
        }
    }
    public function get_name(): string
    {
        return 'phpcr_purger';
    }
    protected function configure_options_node(Array_Node_Definition $options_node): void
    {
        $options_node->children()->array_node('managers')->default_value([null])->scalar_prototype();
    }
}