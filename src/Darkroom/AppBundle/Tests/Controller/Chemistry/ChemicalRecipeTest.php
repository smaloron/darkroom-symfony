<?php

namespace Darkroom\AppBundle\Tests\Controller\Chemistry;

use Darkroom\AppBundle\Tests\AbstractDoctrineWebTestCase;
use Darkroom\ModelBundle\Entity\Chemistry\RecipeCategory;
use Darkroom\ModelBundle\Entity\Chemistry\UnitCategory;
use Darkroom\ModelBundle\Entity\Chemistry\Manufacturer;
use Darkroom\ModelBundle\Entity\Chemistry\ChemicalProduct;
use Darkroom\ModelBundle\Entity\Chemistry\Unit;

class ChemicalRecipeTest extends AbstractDoctrineWebTestCase {

    public function setUp()
    {
        parent::setUp();

        $this->entityName = 'DarkroomModelBundle:Chemistry\ChemicalRecipe';
        $this->baseRoute = '/chemistry/chemical-recipe/';
        $this->insertValue = 'test chemical recipe';
        $this->updateValue = 'updated ' . $this->insertValue;


        $recipeCategory = $this->getReferenceEntity('Fixer', 'RecipeCategory');
        $manufacturer = $this->getReferenceEntity('Ilford', 'Manufacturer');

        $this->postData = array (
            'darkroom_modelbundle_chemicalrecipe[name]' => $this->insertValue,
            'darkroom_modelbundle_chemicalrecipe[recipeCategory]' => $recipeCategory->getId(),
            'darkroom_modelbundle_chemicalrecipe[manufacturer]' => $manufacturer->getId(),
        );
        $this->updateData = array (
            'darkroom_modelbundle_chemicalrecipe[name]' => $this->updateValue,
            'darkroom_modelbundle_chemicalrecipe[recipeCategory]' => $recipeCategory->getId(),
            'darkroom_modelbundle_chemicalrecipe[manufacturer]' => $manufacturer->getId(),
        );
    }

    private function getReferenceEntity($name, $className){
        $repository = $this->em->getRepository('DarkroomModelBundle:Chemistry\\'.$className);
        $entity = $repository->findOneByName($name);

        return $entity;
    }


}
