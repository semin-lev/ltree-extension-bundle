<?php

namespace Slev\LtreeExtensionBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SlevLtreeExtensionExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        $dbalConfig = [
            'dbal' => [
                'types' => [
                    'ltree' => 'Slev\LtreeExtensionBundle\Types\LTreeType'
                ],
                'mapping_types' => [
                    'ltree' => 'ltree'
                ],
            ],
            'orm' => [
                'repository_factory'=>'slev_ltreeextensionbundle.repository_factory',
                'dql' => [
                    'string_functions' => [
                        'ltree_concat' => 'Slev\LtreeExtensionBundle\DqlFunction\LtreeConcatFunction',
                        'ltree_subpath' => 'Slev\LtreeExtensionBundle\DqlFunction\LtreeSubpathFunction'
                    ],
                    'numeric_functions' => [
                        'ltree_nlevel' => 'Slev\LtreeExtensionBundle\DqlFunction\LtreeNlevelFunction',
                        'ltree_operator' => 'Slev\LtreeExtensionBundle\DqlFunction\LtreeOperatorFunction'
                    ]
                ]
            ]
        ];

        $container->prependExtensionConfig('doctrine', $dbalConfig);
    }


    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
