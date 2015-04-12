<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 01.03.15
 * Time: 16:05
 */

namespace Slev\LtreeExtensionBundle\Traits;


use Slev\LtreeExtensionBundle\Annotation\LtreePath;
use Doctrine\ORM\Mapping\Column;

trait LtreePathTrait
{
    /**
     * @var array
     *
     * @Column(type="ltree")
     * @LtreePath()
     */
    protected $ltreePath=null;

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

    /**
     * Level number
     *
     * @return int
     */
    public function getLevelNumber()
    {
        return count($this->getLtreePath());
    }
}