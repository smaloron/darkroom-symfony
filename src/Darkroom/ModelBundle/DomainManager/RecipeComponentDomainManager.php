<?php

namespace Darkroom\ModelBundle\DomainManager;


use Darkroom\ModelBundle\Entity\DarkroomEntityInterface;

class RecipeComponentDomainManager extends DefaultDomainManager
{
    /**
     * @param DarkroomEntityInterface $recipe
     */
    public function removeOldComponents(DarkroomEntityInterface $recipe)
    {
        $originalComponents = $this->getRepository()->findByRecipe($recipe);
        foreach ($originalComponents as $item) {
            if (!$recipe->getComponents()->contains($item)) {
                $this->delete($item);
            }
        }
        $this->flush();
    }
}