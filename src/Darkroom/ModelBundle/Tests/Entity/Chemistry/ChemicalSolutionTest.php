<?php
/**
 * Created by PhpStorm.
 * User: seb
 * Date: 15/05/2015
 * Time: 09:03
 */

namespace Darkroom\ModelBundle\Tests\Entity\Chemistry;

use Doctrine\Common\Collections\ArrayCollection;
use Darkroom\ModelBundle\Entity\Chemistry\ChemicalSolution;
use Darkroom\ModelBundle\Entity\Chemistry\SolutionComponent;
use Darkroom\ModelBundle\Entity\Chemistry\SolutionContainer;
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
        $component->setVolume(400);
        $solutionComponent->add($component);

        $stockSolution->setDependantSolutions($solutionComponent);

        $solution = new ChemicalSolution();
        $solution->setName('Fixer working solution');
        $solution->setComponents($solutionComponent);
        $solution->setContainer(new SolutionContainer());
        $solution->getContainer()->setVolumeCapacity(1000);
        $solution->setWaterVolume(600);

        $this->solution = $solution;
    }

    public function testValidate(){
        $validator = Validation::createValidatorBuilder()->getValidator();
        $errors = $validator->validate($this->solution);
        $this->assertEquals(0, count($errors), 'The ChemicalSolution validation returns 0 errors');
    }

    public function testSolutionTotalVolume(){
        $computedVolume = $this->solution->getTotalVolume();
        $this->assertEquals(1000,$computedVolume, 'The solution volume is equal to 1000');
    }

    public function testContainerCapacity(){
        $capacity = $this->solution->getContainer()->getVolumeCapacity();
        $this->assertEquals($capacity,$this->solution->getTotalVolume(),'The solution volume matches the container capacity');
    }

    public function testStockSolutionVolumeLeft(){
        $stockSolution = $this->solution->getComponents()->get(0)->getComponent();
        $volumeLeft = $stockSolution->getVolumeLeft();
        $this->assertEquals(600,$volumeLeft,'The volume left of the stock solution is 600');
    }

    public function testValidationFails(){
        $this->solution->getComponents()->get(0)->setVolume(700);
        $validator = Validation::createValidatorBuilder()->getValidator();
        $errors = $validator->validate($this->solution);
        $this->assertEquals(0, count($errors), 'The ChemicalSolution validation returns 1 error');
    }

}
