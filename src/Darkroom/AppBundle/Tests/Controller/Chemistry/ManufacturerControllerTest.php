<?php

namespace Darkroom\AppBundle\Tests\Controller\Chemistry;

use Darkroom\AppBundle\Tests\AbstractDoctrineWebTestCase;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ManufacturerControllerTest
 * @package Darkroom\AppBundle\Tests\Controller\Chemistry
 */
class ManufacturerControllerTest extends AbstractDoctrineWebTestCase
{

    public function setUp(){
        parent::setUp();

        $this->entityName = 'DarkroomModelBundle:Chemistry\Manufacturer';
        $this->baseRoute = '/chemistry/manufacturer/';
        $this->insertValue = 'test manufacturer';
        $this->updateValue = 'updated '. $this->insertValue;
        $this->postData = array(
            'darkroom_modelbundle_manufacturer[name]' => $this->insertValue,
        );
        $this->updateData = array(
            'darkroom_modelbundle_manufacturer[name]' => $this->updateValue,
        );
    }
}
