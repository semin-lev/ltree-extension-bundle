<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 14.03.15
 * Time: 17:27
 */

namespace Slev\LtreeExtensionBundle\TreeBuilder;


class TreeBuilder implements TreeBuilderInterface
{
    /** @var  TreeBuilderInterface */
    protected $arrayBuilder;

    /** @var  TreeBuilderInterface */
    protected $objectBuilder;

    function __construct(TreeBuilderInterface $arrayBuilder, TreeBuilderInterface $objectBuilder)
    {
        $this->arrayBuilder = $arrayBuilder;
        $this->objectBuilder = $objectBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function buildTree($list, $pathName, $parentPath = null, $parentName = null, $childrenName = null)
    {
        $element = null;
        foreach ($list as $item){
            $element = $item;
            break;
        }
        if (is_array($element)){
            return $this->arrayBuilder->buildTree($list, $pathName, $parentPath, $parentName, $childrenName);
        }
        if (is_object($element)){
            return $this->objectBuilder->buildTree($list, $pathName, $parentPath, $parentName, $childrenName);
        }
        throw new \LogicException("Unable to find builder");
    }
}