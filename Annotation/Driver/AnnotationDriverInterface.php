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
    const CHILDS_ANNOTATION = '\\Slev\\LtreeExtensionBundle\\Annotation\\LtreeChilds';
    const PARENT_ANNOTATION = '\\Slev\\LtreeExtensionBundle\\Annotation\\LtreeParent';
    const PATH_ANNOTATION = '\\Slev\\LtreeExtensionBundle\\Annotation\\LtreePath';

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