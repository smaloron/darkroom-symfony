<?php
/**
 * Created by PhpStorm.
 * User: seb
 * Date: 19/05/2015
 * Time: 17:21
 */

namespace Darkroom\AppBundle\Tests\Controller\Chemistry;


use Darkroom\AppBundle\Tests\AbstractDoctrineWebTestCase;
use Darkroom\ModelBundle\Entity\Chemistry\UnitCategory;

class ChemicalProductTest extends AbstractDoctrineWebTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->entityName = 'DarkroomModelBundle:Chemistry\ChemicalProduct';
        $this->baseRoute = '/chemistry/chemical-product/';
        $this->insertValue = 'test chemical product';
        $this->updateValue = 'updated ' . $this->insertValue;

        $categoryId = $this->getUnitCategory('weight')->getId();

        $this->postData = array (
            'darkroom_modelbundle_chemicalproduct[name]' => $this->insertValue,
            'darkroom_modelbundle_chemicalproduct[unitCategory]' => $categoryId,
        );
        $this->updateData = array (
            'darkroom_modelbundle_chemicalproduct[name]' => $this->updateValue,
            'darkroom_modelbundle_chemicalproduct[unitCategory]' => $categoryId,
        );
    }

    /**
     * @param $categoryName
     * @return UnitCategory
     */
    private function getUnitCategory($categoryName)
    {
        $repository = $this->em->getRepository('DarkroomModelBundle:Chemistry\UnitCategory');
        $unitCategory = $repository->findOneByName($categoryName);

        return $unitCategory;
    }
}
