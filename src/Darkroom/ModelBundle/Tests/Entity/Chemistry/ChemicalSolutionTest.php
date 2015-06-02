<?php

namespace Darkroom\ModelBundle\Tests\Entity\Chemistry;

use Darkroom\ModelBundle\Entity\Chemistry\ChemicalSolution;
use Darkroom\ModelBundle\Entity\Chemistry\SolutionComponent;
use Darkroom\ModelBundle\Entity\Chemistry\SolutionContainer;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Validation;

class ChemicalSolutionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ChemicalSolution
     */
    private $solution;

    public function setUp(){

        $workingSolution = new ChemicalSolution();
        $workingSolution->setName('Fixer working solution');

        $stockSolution = new ChemicalSolution();
        $stockSolution->setName('Fixer stock solution');
        $stockSolution->setInitialVolume(1000);
        $stockSolution->setVolumeLeft(1000);
        $stockSolution->setWaterVolume(1000);


        $solutionComponent = new ArrayCollection();
        $component = new SolutionComponent();
        $component->setComponent($stockSolution);
        $component->setSolution($workingSolution);
        $component->setVolume(100);
        $solutionComponent->add($component);

        $stockSolution->setDependantSolutions($solutionComponent);


        $workingSolution->setComponents($solutionComponent);
        $workingSolution->setContainer(new SolutionContainer());
        $workingSolution->getContainer()->setVolumeCapacity(1000);
        $workingSolution->setInitialVolume(1000);

        $this->solution = $workingSolution;
    }

    public function testValidate(){
        $validator = Validation::createValidatorBuilder()->getValidator();
        $errors = $validator->validate($this->solution);
        $this->assertEquals(0, count($errors), 'The ChemicalSolution validation returns 0 errors');
    }

    public function testSolutionTotalVolume(){
        $computedVolume = $this->solution->getWaterVolume();
        $this->assertEquals(900, $computedVolume, 'The solution water volume is equal to 900');
    }

    public function testContainerCapacity(){
        $capacity = $this->solution->getContainer()->getVolumeCapacity();
        $this->assertEquals($capacity,$this->solution->getTotalVolume(),'The solution volume matches the container capacity');
    }

    public function testStockSolutionVolumeLeft(){
        $stockSolution = $this->solution->getComponents()->get(0)->getComponent();
        $volumeLeft = $stockSolution->getVolumeLeft();
        $this->assertEquals(900, $volumeLeft, 'The volume left of the stock solution is 900');
    }

    public function testValidationFails(){
        $this->solution->getComponents()->get(0)->setVolume(700);
        $validator = Validation::createValidatorBuilder()->getValidator();
        $errors = $validator->validate($this->solution);
        $this->assertEquals(0, count($errors), 'The ChemicalSolution validation returns 1 error');
    }

    public function testDilutionString()
    {
        $this->solution->calculateDilution();
        $this->assertEquals('1+9', $this->solution->getDilution(), 'The dilution is not 1+9');
    }

}
