<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 23.03.15
 * Time: 21:58
 */

namespace Slev\LtreeExtensionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Slev\LtreeExtensionBundle\Annotation\LtreeChilds;
use Slev\LtreeExtensionBundle\Annotation\LtreeEntity;
use Slev\LtreeExtensionBundle\Annotation\LtreeParent;
use Slev\LtreeExtensionBundle\Traits\LtreePathTrait;

/**
 * Class TestEntity
 * @package Slev\LtreeExtensionBundle
 *
 * @Entity(repositoryClass="Slev\LtreeExtensionBundle\Entity\TestRepository")
 * @LtreeEntity()
 */
class TestEntity
{
    use LtreePathTrait;

    /**
     * @var int
     * @Id()
     * @GeneratedValue(strategy="AUTO")
     * @Column()
     */
    protected $id;

    /**
     * @var TestEntity
     *
     * @ManyToOne(targetEntity="TestEntity", inversedBy="child")
     * @LtreeParent()
     */
    protected $parent;

    /**
     * @var ArrayCollection|TestEntity[]
     *
     * @OneToMany(targetEntity="TestEntity", mappedBy="parent", cascade={"all"}, orphanRemoval=true)
     * @JoinColumn(onDelete="CASCADE")
     * @LtreeChilds()
     */
    protected $child;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->child = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set parent
     *
     * @param TestEntity $parent
     * @return TestEntity
     */
    public function setParent(TestEntity $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return TestEntity
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param TestEntity $child
     * @return TestEntity
     */
    public function addChild(TestEntity $child)
    {
        $this->child[] = $child;
        $child->setParent($this);

        return $this;
    }

    /**
     * Remove child
     *
     * @param TestEntity $child
     */
    public function removeChild(TestEntity $child)
    {
        $this->child->removeElement($child);
    }

    /**
     * Get child
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChild()
    {
        return $this->child;
    }
}
