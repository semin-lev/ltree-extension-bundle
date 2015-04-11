<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 24.03.15
 * Time: 7:55
 */

namespace Slev\LtreeExtensionBundle\Command;


use Doctrine\ORM\Query;
use Slev\LtreeExtensionBundle\Entity\TestEntity;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('test_command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getChildren();
    }

    protected function getChildren()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $child = $em->find("SlevLtreeExtensionBundle:TestEntity", 1552);

        var_dump($em->getRepository("SlevLtreeExtensionBundle:TestEntity")->getAllChildren($child, true, Query::HYDRATE_ARRAY));
    }

    protected function getParent()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $child = $em->find("SlevLtreeExtensionBundle:TestEntity", 1548);

        var_dump($em->getRepository("SlevLtreeExtensionBundle:TestEntity")->getAllParent($child, Query::HYDRATE_ARRAY));
    }

    protected function moveNode()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $root = $em->find("SlevLtreeExtensionBundle:TestEntity", 1547);
        $child = $em->find("SlevLtreeExtensionBundle:TestEntity", 1548);

        $root->addChild($child);

        $em->flush();
    }

    protected function createEntities()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $createChilds = function(TestEntity $root){
            $count=rand(1,5);
            for ($i=0; $i<$count; $i++){
                $child = new TestEntity();
                $root->addChild($child);
                $childCount = rand(1,5);
                for ($j=0; $j<$childCount; $j++){
                    $child->addChild(new TestEntity());
                }
            }
            return $root;
        };

        $em->persist($createChilds(new TestEntity()));
        $em->persist($createChilds(new TestEntity()));
        $em->persist($createChilds(new TestEntity()));

        $em->flush();
    }
}