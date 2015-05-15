<?php

namespace Darkroom\ModelBundle\Tests\Entity\Chemistry;

use Darkroom\ModelBundle\Entity\Chemistry\ChemicalRecipe;
use Darkroom\ModelBundle\Entity\Chemistry\Manufacturer;
use Darkroom\ModelBundle\Entity\Chemistry\ChemicalProduct;
use Darkroom\ModelBundle\Entity\Chemistry\RecipeCategory;
use Darkroom\ModelBundle\Entity\Chemistry\RecipeComponent;
use Darkroom\ModelBundle\Entity\Chemistry\UnitCategory;
use Darkroom\ModelBundle\Entity\Chemistry\Unit;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Validation;

class ChemicalRecipeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ChemicalRecipe
     */
    private $recipe;


    /**
     * Setting up a chemical recipe
     */
    public function setUp(){
        $manufacturer = new Manufacturer();
        $manufacturer->setName('ILFORD');

        $recipeCategory = new RecipeCategory();
        $recipeCategory->setName('FIXER');

        $unitCategoryWeight = new UnitCategory();
        $unitCategoryWeight->setName('weight');

        $unitCategoryLiquid = new UnitCategory();
        $unitCategoryLiquid->setName('liquid');

        $unitGram = new Unit();
        $unitGram->setUnitCategory($unitCategoryWeight);
        $unitGram->setName('gram');
        $unitGram->setAbbrev('g');

        $recipe = new ChemicalRecipe();

        $components = new ArrayCollection();
        $component = new RecipeComponent();
        $component->setQuantity(160);
        $component->setUnit($unitGram);
        $component->setChemical(new ChemicalProduct());
        $component->getChemical()->setName('sodium thiosulfate');
        $component->getChemical()->setUnitCategory($unitCategoryWeight);
        $component->setRecipe($recipe);
        $components->add($component);

        $component = new RecipeComponent();
        $component->setQuantity(60);
        $component->setUnit($unitGram);
        $component->setChemical(new ChemicalProduct());
        $component->getChemical()->setName('sodium sulfite');
        $component->getChemical()->setUnitCategory($unitCategoryWeight);
        $component->setRecipe($recipe);
        $components->add($component);

        $component = new RecipeComponent();
        $component->setQuantity(1000);
        $component->setUnit(new Unit());
        $component->getUnit()->setName('liter');
        $component->getUnit()->setUnitCategory($unitCategoryLiquid);
        $component->setChemical(new ChemicalProduct());
        $component->getChemical()->setName('water');
        $component->getChemical()->setUnitCategory($unitCategoryLiquid);
        $component->setRecipe($recipe);
        $components->add($component);

        $recipe = new ChemicalRecipe();
        $recipe->setManufacturer($manufacturer);
        $recipe->setRecipeCategory($recipeCategory);
        $recipe->setComponents($components);

        $this->recipe = $recipe;
    }

    /**
     * The entity should validate
     */
    public function testValidationPasses(){
        $validator = Validation::createValidatorBuilder()->getValidator();
        $errors = $validator->validate($this->recipe);
        $this->assertEquals(0, count($errors), 'The ChemicalRecipe validation returns 0 errors');
    }

    /**
     * Unit category mismatch should return a validation error
     */
    public function testValidationFails(){
        $recipe = $this->recipe;
        $unit = new Unit();
        $unit->setUnitCategory(new UnitCategory());
        $unit->getUnitCategory()->setName('length');
        $recipe->getComponents()->get(0)->setUnit($unit);

        $validator = Validation::createValidatorBuilder()->getValidator();

        $errors = $validator->validate($recipe);
        $this->assertEquals(0, count($errors), 'The ChemicalRecipe validation returns 1 error');
    }

}
