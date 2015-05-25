<?php

namespace Darkroom\ModelBundle\DomainManager;


use Darkroom\ModelBundle\Entity\DarkroomEntityInterface;
use Doctrine\ORM\EntityManager;

class ChemicalSolutionDomainManager extends DefaultDomainManager
{

    protected $componentManager;

    /**
     * @param EntityManager $entityManager
     * @param DomainManagerInterface $componentManager
     * @param $entityName
     */
    public function __construct(EntityManager $entityManager, DomainManagerInterface $componentManager, $entityName)
    {
        $this->entityManager = $entityManager;
        $this->entityName = $entityName;
        $this->repository = $this->entityManager->getRepository($this->entityName);
        $this->componentManager = $componentManager;
    }

    /**
     * @param DarkroomEntityInterface $solution
     * @param array $components
     */
    public function persist(DarkroomEntityInterface $solution, $components = null)
    {

        if ($solution->getId() != null) {
            $this->componentManager->removeOldComponents($solution);
        }

        //Remove the components
        $solution->getComponents()->clear();

        //Persist the recipe in order to set the primary key
        $this->entityManager->persist($solution);
        $this->flush();

        //Add the components
        foreach ($components as $item) {
            $item->setSolution($solution);
            $solution->addComponent($item);
            $this->entityManager->persist($item);
        }
        $this->flush();

        $id = $solution->getId();
    }


}