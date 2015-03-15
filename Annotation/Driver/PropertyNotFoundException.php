<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 14.03.15
 * Time: 11:07
 */

namespace Slev\LtreeExtensionBundle\Annotation\Driver;


class PropertyNotFoundException extends \Exception
{
    private $className;

    private $annotationClassName;

    /**
     * @param object $object
     * @param string $annotationClassName
     */
    function __construct($object, $annotationClassName)
    {
        $this->className = get_class($object);
        $this->annotationClassName = $annotationClassName;

        parent::__construct(sprintf("Class %s does not exist property annotated by %s",
            $this->getClassName(), $this->getAnnotationClassName()));
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getAnnotationClassName()
    {
        return $this->annotationClassName;
    }
}