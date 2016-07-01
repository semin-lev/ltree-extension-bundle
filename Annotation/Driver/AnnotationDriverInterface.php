<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 14.03.15
 * Time: 11:04
 */

namespace Slev\LtreeExtensionBundle\Annotation\Driver;


interface AnnotationDriverInterface
{
    const ENTITY_ANNOTATION = '\\Slev\\LtreeExtensionBundle\\Annotation\\LtreeEntity';
    const CHILDS_ANNOTATION = '\\Slev\\LtreeExtensionBundle\\Annotation\\LtreeChilds';
    const PARENT_ANNOTATION = '\\Slev\\LtreeExtensionBundle\\Annotation\\LtreeParent';
    const PATH_ANNOTATION = '\\Slev\\LtreeExtensionBundle\\Annotation\\LtreePath';

    /**
     * Check that ltree entity annotation is in the $object
     *
     * @param $object
     * @return bool
     */
    public function entityIsLtree($object);

    /**
     * Check that ltree entity annotation is in the $className
     *
     * @param $className
     * @return bool
     */
    public function classIsLtree($className);

    /**
     * Return childs property reflection object
     *
     * @param $object
     * @return \ReflectionProperty
     * @throws PropertyNotFoundException
     */
    public function getChildsProperty($object);

    /**
     * Return parent property reflection object
     *
     * @param $object
     * @return \ReflectionProperty
     * @throws PropertyNotFoundException
     */
    public function getParentProperty($object);

    /**
     * Return path property reflection object
     *
     * @param $object
     * @return \ReflectionProperty
     * @throws PropertyNotFoundException
     */
    public function getPathProperty($object);
}