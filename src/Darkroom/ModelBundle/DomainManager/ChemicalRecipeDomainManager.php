<?php

namespace Darkroom\ModelBundle\DomainManager;

use Darkroom\ModelBundle\Entity\DarkroomEntityInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class ChemicalRecipeDomainManager
 * @package Darkroom\ModelBundle\DomainManager
 */
class ChemicalRecipeDomainManager extends DefaultDomainManager
{

    /**
     * @var RecipeComponentDomainManager
     */
    protected $componentManager;

    public function __construct(
        EntityManager $entityManager,
        RecipeComponentDomainManager $componentManager,
        $entityName
    ) {
        $this->entityManager = $entityManager;
        $this->entityName = $entityName;
        $this->repository = $this->entityManager->getRepository($this->entityName);
        $this->componentManager = $componentManager;
    }

    /**
     * @param DarkroomEntityInterface $recipe
     * @param array $components
     */
    public function persist(DarkroomEntityInterface $recipe, $components = null)
    {
        if ($recipe->getId() != null) {
            $this->componentManager->removeOldComponents($recipe);
        }

        //Remove the components
        $recipe->getComponents()->clear();

        //Persist the recipe in order to set the primary key
        $this->entityManager->persist($recipe);
        $this->flush();

        //Add the components
        foreach ($components as $item) {
            $item->setRecipe($recipe);
            $this->entityManager->persist($item);
        }
        $this->flush();
    }
}