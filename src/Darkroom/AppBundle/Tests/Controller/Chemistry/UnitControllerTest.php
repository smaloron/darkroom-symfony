<?php

namespace Darkroom\AppBundle\Tests\Controller\Chemistry;

use Darkroom\AppBundle\Tests\AbstractDoctrineWebTestCase;
use Darkroom\ModelBundle\Entity\Chemistry\UnitCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Response;

class UnitControllerTest extends AbstractDoctrineWebTestCase
{


    public function setUp(){
        parent::setUp();

        $this->entityName = 'DarkroomModelBundle:Chemistry\Unit';
        $this->baseRoute = '/chemistry/unit/';
        $this->insertValue = 'test unit';
        $this->updateValue = 'updated '. $this->insertValue;

        $categoryId = $this->getUnitCategory('weight')->getId();

        $this->postData = array(
            'darkroom_modelbundle_unit[name]' => $this->insertValue,
            'darkroom_modelbundle_unit[abbrev]' => 'custom abbrev',
            'darkroom_modelbundle_unit[conversionRate]' => 100,
            'darkroom_modelbundle_unit[unitCategory]' => $categoryId,
        );
        $this->updateData = array(
            'darkroom_modelbundle_unit[name]' => $this->updateValue,
            'darkroom_modelbundle_unit[abbrev]' => 'custom abbrev',
            'darkroom_modelbundle_unit[conversionRate]' => 100,
            'darkroom_modelbundle_unit[unitCategory]' => $categoryId,
        );
    }

    /**
     * @param $categoryName
     * @return UnitCategory
     */
    private function getUnitCategory($categoryName){
        $repository = $this->em->getRepository('DarkroomModelBundle:Chemistry\UnitCategory');
        $unitCategory = $repository->findOneByName($categoryName);
        return $unitCategory;
    }
}
