<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 01.03.15
 * Time: 16:10
 */

namespace Slev\LtreeExtensionBundle\Repository;


use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Slev\LtreeExtensionBundle\Annotation\Driver\AnnotationDriverInterface;
use Slev\LtreeExtensionBundle\TreeBuilder\TreeBuilderInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

interface LtreeEntityRepositoryInterface
{
    /**
     * @param TreeBuilderInterface $treeBuilder
     */
    public function setTreeBuilder(TreeBuilderInterface $treeBuilder);

    /**
     * @param PropertyAccessorInterface $propertyAccessor
     */
    public function setPropertyAccessor(PropertyAccessorInterface $propertyAccessor);

    /**
     * @param AnnotationDriverInterface $annotationDriver
     */
    public function setAnnotationDriver(AnnotationDriverInterface $annotationDriver);

    /**
     * @param object $entity object entity
     * @return QueryBuilder
     */
    public function getAllParentQueryBuilder($entity);

    /**
     * @param object $entity object entity
     * @param int $hydrate Doctrine processing mode to be used during hydration process.
     *                               One of the Query::HYDRATE_* constants.
     * @return array with parents for $entity. The root node is last
     */
    public function getAllParent($entity, $hydrate=Query::HYDRATE_OBJECT);

    /**
     * @param object $entity object entity
     * @return QueryBuilder
     */
    public function getAllChildrenQueryBuilder($entity);

    /**
     * @param object $entity object entity
     * @param bool $treeMode This flag set how result will be presented
     * @param int $hydrate Doctrine processing mode to be used during hydration process.
     *                               One of the Query::HYDRATE_* constants.
     * @return array If $treeMode is true, result will be grouped to tree.
     *                  If hydrate is object, children placed in childs property.
     *                  If hydrate is array, children placed in __childs key.
     *               If $treeMode is false, result will be in one level array
     */
    public function getAllChildren($entity, $treeMode=false, $hydrate=Query::HYDRATE_OBJECT);

    /**
     * @param object $entity object entity
     * @param object|array $to object or path array
     * @return void
     */
    public function moveNode($entity, $to);
}