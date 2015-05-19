<?php

namespace Darkroom\AppBundle\Tests\Controller\Chemistry;


use Darkroom\AppBundle\Tests\AbstractDoctrineWebTestCase;

/**
 * Class RecipeCategoryControllerTest
 * @package Darkroom\AppBundle\Tests\Controller\Chemistry
 */
class RecipeCategoryControllerTest extends AbstractDoctrineWebTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->entityName = 'DarkroomModelBundle:Chemistry\RecipeCategory';
        $this->baseRoute = '/chemistry/recipe-category/';
        $this->insertValue = 'test category';
        $this->updateValue = 'updated ' . $this->insertValue;
        $this->postData = array (
            'darkroom_modelbundle_recipecategory[name]' => $this->insertValue,
        );
        $this->updateData = array (
            'darkroom_modelbundle_recipecategory[name]' => $this->updateValue,
        );
    }
}
