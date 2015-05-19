<?php

namespace Darkroom\AppBundle\Tests\Controller\Chemistry;

use Darkroom\AppBundle\Tests\AbstractDoctrineWebTestCase;

/**
 * Class UnitCategoryControllerTest
 * @package Darkroom\AppBundle\Tests\Controller\Chemistry
 */
class UnitCategoryControllerTest extends AbstractDoctrineWebTestCase
{

    public function setUp(){
        parent::setUp();

        $this->entityName = 'DarkroomModelBundle:Chemistry\UnitCategory';
        $this->baseRoute = '/chemistry/unit-category/';
        $this->insertValue = 'test category';
        $this->updateValue = 'updated '. $this->insertValue;
        $this->postData = array(
            'darkroom_modelbundle_unitCategory[name]' => $this->insertValue,
        );
        $this->updateData = array(
            'darkroom_modelbundle_unitCategory[name]' => $this->updateValue,
        );
    }
}