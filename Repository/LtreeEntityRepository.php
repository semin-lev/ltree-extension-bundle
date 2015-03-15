<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 01.03.15
 * Time: 16:09
 */

namespace Slev\LtreeExtensionBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Query;
use Gedmo\Mapping\Annotation\Tree;
use Slev\LtreeExtensionBundle\Annotation\Driver\AnnotationDriverInterface;
use Slev\LtreeExtensionBundle\TreeBuilder\TreeBuilderInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class LtreeEntityRepository extends EntityRepository implements LtreeEntityRepositoryInterface
{
    /**
     * @var AnnotationDriverInterface
     */
    private $annotationDriver=null;

    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor=null;

    /**
     * @var TreeBuilderInterface
     */
    private $treeBuilder=null;

    /**
     * @return TreeBuilderInterface
     */
    public function getTreeBuilder()
    {
        if ($this->treeBuilder===null){
            throw new \LogicException("Repository must inject property accessor service itself");
        }

        return $this->treeBuilder;
    }

    /**
     * @param TreeBuilderInterface $treeBuilder
     */
    public function setTreeBuilder(TreeBuilderInterface $treeBuilder)
    {
        $this->treeBuilder = $treeBuilder;
    }

    /**
     * @return PropertyAccessorInterface
     */
    public function getPropertyAccessor()
    {
        if ($this->propertyAccessor===null){
            throw new \LogicException("Repository must inject property accessor service itself");
        }
        return $this->propertyAccessor;
    }

    /**
     * @param PropertyAccessorInterface $propertyAccessor
     */
    public function setPropertyAccessor(PropertyAccessorInterface $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * @return AnnotationDriverInterface
     */
    public function getAnnotationDriver()
    {
        if ($this->annotationDriver===null){
            throw new \LogicException("Repository must inject annotation driver service itself");
        }
        return $this->annotationDriver;
    }

    /**
     * @param AnnotationDriverInterface $annotationDriver
     */
    public function setAnnotationDriver(AnnotationDriverInterface $annotationDriver)
    {
        $this->annotationDriver = $annotationDriver;
    }

    protected function checkClass($entity)
    {
        if (!is_a($entity, $this->getClassName())){
            throw new \InvalidArgumentException(sprintf('Entity must be instance of %s', $this->getClassName()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllParentQueryBuilder($entity)
    {
        $this->checkClass($entity);
        $aliasName = 'ltree_entity';
        $pathName = $this->getAnnotationDriver()->getPathProperty($entity)->getName();
        $pathValue = $this->getPropertyAccessor()->getValue($entity, $pathName);

        $qb = $this->createQueryBuilder($aliasName);
        $qb->where(sprintf("%s.%s@>:self_path", $aliasName, $pathName));
        $qb->andWhere(sprintf("%s.%s<>:self_path", $aliasName, $pathName));
        $qb->orderBy(sprintf("%s.%s", $aliasName, $pathName), 'DESC');
        $qb->setParameter('self_path', $pathValue);

        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllChildrenQueryBuilder($entity)
    {
        $this->checkClass($entity);
        $aliasName = 'ltree_entity';
        $pathName = $this->getAnnotationDriver()->getPathProperty($entity)->getName();
        $pathValue = $this->getPropertyAccessor()->getValue($entity, $pathName);
        $orderFieldName = 'parent_paths_for_order';

        $qb = $this->createQueryBuilder($aliasName);
        $qb->addSelect(sprintf("subpath(%s.%s, 0, -1) as HIDDEN %s", $aliasName, $pathName, $orderFieldName));
        $qb->where(sprintf("%s.%s<@:self_path", $aliasName, $pathName));
        $qb->andWhere(sprintf("%s.%s<>:self_path", $aliasName, $pathName));
        $qb->orderBy($orderFieldName);
        $qb->setParameter('self_path', $pathValue);

        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllParent($entity, $hydrate = Query::HYDRATE_OBJECT)
    {
        return $this->getAllParentQueryBuilder($entity)->getQuery()->getResult($hydrate);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllChildren($entity, $treeMode = false, $hydrate = Query::HYDRATE_OBJECT)
    {
        $this->checkClass($entity);
        $result = $this->getAllChildrenQueryBuilder($entity)->getQuery()->getResult($hydrate);
        if ($treeMode && $hydrate!=Query::HYDRATE_OBJECT && $hydrate!=Query::HYDRATE_ARRAY){
            throw new \LogicException("If treeMode is true, hydration mode must be object or array");
        }
        if (!$treeMode) return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function moveNode($entity, $to)
    {
        $this->checkClass($entity);
    }
}