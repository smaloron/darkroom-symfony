<?php

namespace Darkroom\ModelBundle\DomainManager;

use Darkroom\ModelBundle\Entity\DarkroomEntityInterface;


class SolutionComponentDomainManager extends DefaultDomainManager
{
    /**
     * @param DarkroomEntityInterface $solution
     */
    public function removeOldComponents(DarkroomEntityInterface $solution)
    {
        $originalComponents = $this->getRepository()->findBySolution($solution);
        foreach ($originalComponents as $item) {
            if (!$solution->getComponents()->contains($item)) {
                $this->delete($item);
            }
        }
        $this->flush();
    }
}