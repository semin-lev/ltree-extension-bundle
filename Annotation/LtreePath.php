<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 01.03.15
 * Time: 16:03
 */

namespace Slev\LtreeExtensionBundle\Annotation;

/**
 * Class LtreePath
 * @package Slev\LtreeExtensionBundle\Annotation
 *
 * @Annotation
 * @Target("PROPERTY")
 */
class LtreePath
{
    /**
     * @var array
     *
     * @ORM\Column(type="ltree")
     */
    protected $ltreePath=array();

    /**
     * @return array
     */
    public function getLtreePath()
    {
        return $this->ltreePath;
    }

    /**
     * @param array $ltreePath
     */
    public function setLtreePath(array $ltreePath)
    {
        $this->ltreePath = $ltreePath;
    }
}