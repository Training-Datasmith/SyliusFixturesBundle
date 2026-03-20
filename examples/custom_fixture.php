<?php

declare(strict_types=1);

/**
 * SyliusFixturesBundle — custom fixture example.
 *
 * Shows how to create a fixture class, configure it in a suite, and load it.
 *
 * --- Step 1: Create a fixture class ---
 *
 * use Sylius\Bundle\FixturesBundle\Fixture\Abstract_Fixture;
 * use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
 *
 * final class ProductFixture extends Abstract_Fixture
 * {
 *     public function __construct(private EntityManagerInterface $em) {}
 *
 *     public function load(array $options): void
 *     {
 *         for ($i = 1; $i <= $options['amount']; $i++) {
 *             $product = new Product();
 *             $product->setName($options['name_prefix'] . ' ' . $i);
 *             $this->em->persist($product);
 *         }
 *         $this->em->flush();
 *     }
 *
 *     public function getName(): string
 *     {
 *         return 'product';
 *     }
 *
 *     protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
 *     {
 *         $optionsNode
 *             ->children()
 *                 ->integerNode('amount')->defaultValue(10)->end()
 *                 ->scalarNode('name_prefix')->defaultValue('Product')->end()
 *             ->end()
 *         ;
 *     }
 * }
 *
 * --- Step 2: Tag the fixture service ---
 *
 * # services.yaml
 * App\Fixture\ProductFixture:
 *     tags:
 *         - { name: sylius_fixtures.fixture }
 *
 * --- Step 3: Configure a suite ---
 *
 * # config/packages/sylius_fixtures.yaml
 * sylius_fixtures:
 *     suites:
 *         default:
 *             fixtures:
 *                 product:
 *                     options:
 *                         amount: 50
 *                         name_prefix: 'Demo Product'
 *
 * --- Step 4: Load the suite ---
 *
 * bin/console sylius:fixtures:load default
 */

echo 'SyliusFixturesBundle requires a Symfony kernel.' . PHP_EOL;
echo 'See the docblock above for fixture implementation patterns.' . PHP_EOL;
