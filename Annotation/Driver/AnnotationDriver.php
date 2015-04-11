<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 14.03.15
 * Time: 11:12
 */

namespace Slev\LtreeExtensionBundle\Annotation\Driver;


use Doctrine\Common\Annotations\Reader;

class AnnotationDriver implements AnnotationDriverInterface
{
    /** @var  Reader */
    private $reader;

    function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * {@inheritdoc}
     */
    public function entityIsLtree($object)
    {
        return (bool)$this->getReader()->getClassAnnotation(new \ReflectionObject($object), self::ENTITY_ANNOTATION);
    }

    /**
     * {@inheritdoc}
     */
    public function getChildsProperty($object)
    {
        return $this->findAnnotation($object, self::CHILDS_ANNOTATION);
    }

    /**
     * {@inheritdoc}
     */
    public function getParentProperty($object)
    {
        return $this->findAnnotation($object, self::PARENT_ANNOTATION);
    }

    /**
     * {@inheritdoc}
     */
    public function getPathProperty($object)
    {
        return $this->findAnnotation($object, self::PATH_ANNOTATION);
    }

    /**
     * @return Reader
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @param $object
     * @param $annotationName
     * @return \ReflectionProperty
     * @throws PropertyNotFoundException
     */
    protected function findAnnotation($object, $annotationName)
    {
        $reflObject = new \ReflectionObject($object);
        foreach($reflObject->getProperties() as $property){
            $result = $this->getReader()->getPropertyAnnotation($property, $annotationName);
            if ($result) return $property;
        }
        throw new PropertyNotFoundException($object, $annotationName);
    }
}