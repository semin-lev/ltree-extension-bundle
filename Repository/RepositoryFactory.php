<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 15.03.15
 * Time: 9:15
 */

namespace Slev\LtreeExtensionBundle\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\DefaultRepositoryFactory;
use Slev\LtreeExtensionBundle\Annotation\Driver\AnnotationDriverInterface;
use Slev\LtreeExtensionBundle\TreeBuilder\TreeBuilderInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class RepositoryFactory extends DefaultRepositoryFactory
{
    /**
     * @var AnnotationDriverInterface
     */
    protected $annotationDriver;

    /**
     * @var PropertyAccessorInterface
     */
    protected $propertyAccessor;

    /**
     * @var TreeBuilderInterface
     */
    protected $treeBuilder;

    function __construct(AnnotationDriverInterface $annotationDriver, PropertyAccessorInterface $propertyAccessor,
                         TreeBuilderInterface $treeBuilder)
    {
        $this->annotationDriver = $annotationDriver;
        $this->propertyAccessor = $propertyAccessor;
        $this->treeBuilder = $treeBuilder;
    }


    protected function createRepository(EntityManagerInterface $entityManager, $entityName)
    {
        $repo = parent::createRepository($entityManager, $entityName);
        if ($repo instanceof LtreeEntityRepositoryInterface){
            $repo->setAnnotationDriver($this->annotationDriver);
            $repo->setPropertyAccessor($this->propertyAccessor);
            $repo->setTreeBuilder($this->treeBuilder);
        }
        return $repo;
    }
}