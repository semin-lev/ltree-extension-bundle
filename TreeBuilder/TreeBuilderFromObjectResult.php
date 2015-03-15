<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 14.03.15
 * Time: 17:03
 */

namespace Slev\LtreeExtensionBundle\TreeBuilder;


use Slev\LtreeExtensionBundle\TreeBuilder\Exceptions\NotImplementException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class TreeBuilderFromObjectResult implements TreeBuilderInterface
{
    /**
     * @var PropertyAccessorInterface
     */
    protected $propertyAccessor;

    function __construct(PropertyAccessorInterface $propertyAccessor)
    {
        $this->propertyAccessor = $propertyAccessor;
    }


    /**
     * {@inheritdoc}
     */
    public function buildTree($list, $pathName, $parentPath = null, $parentName = null, $childrenName = null)
    {
        throw new NotImplementException("Build tree from object not implement yet");
    }
}