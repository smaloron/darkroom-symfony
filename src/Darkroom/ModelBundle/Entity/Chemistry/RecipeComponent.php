<?php

namespace Darkroom\ModelBundle\Entity\Chemistry;

use Darkroom\ModelBundle\Entity\DarkroomEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RecipeComponent
 *
 * @ORM\Table(name="recipe_components", indexes={@ORM\Index(name="recipe_component_unit", columns={"unit_id"}), @ORM\Index(name="recipe_component_to_chemical_product", columns={"chemical_id"}), @ORM\Index(name="recipe_component_to_recipe", columns={"recipe_id"})})
 * @ORM\Entity
 */
class RecipeComponent implements DarkroomEntityInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @Assert\NotBlank(message="the quantity cannot be empty")
     * @Assert\GreaterThan(value=0, message="the quantity must be greater than 0")
     *
     * @ORM\Column(name="quantity", type="float", precision=10, scale=0, nullable=false)
     */
    private $quantity;

    /**
     * @var ChemicalProduct
     *
     * @Assert\NotBlank(message="you must choose a chemical product")
     *
     * @ORM\ManyToOne(targetEntity="ChemicalProduct", inversedBy="recipes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chemical_id", referencedColumnName="id")
     * })
     */
    private $chemical;

    /**
     * @var ChemicalRecipe
     *
     * @ORM\ManyToOne(targetEntity="ChemicalRecipe", inversedBy="components")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     * })
     */
    private $recipe;

    /**
     * @var Unit
     *
     * @Assert\NotBlank(message="You must choose a unit")
     *
     * @ORM\ManyToOne(targetEntity="Unit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     * })
     */
    private $unit;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     * @return RecipeComponent
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get chemical
     *
     * @return ChemicalProduct
     */
    public function getChemical()
    {
        return $this->chemical;
    }

    /**
     * Set chemical
     *
     * @param ChemicalProduct $chemical
     * @return RecipeComponent
     */
    public function setChemical(ChemicalProduct $chemical = null)
    {
        $this->chemical = $chemical;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return ChemicalRecipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set recipe
     *
     * @param ChemicalRecipe $recipe
     * @return RecipeComponent
     */
    public function setRecipe(ChemicalRecipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get unit
     *
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set unit
     *
     * @param Unit $unit
     * @return RecipeComponent
     */
    public function setUnit(Unit $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Check if the unit category of the choosen unit matches
     * with the unit category of the chemical product
     * @Assert\True(message="This unit is not allowed for this chemical product")
     * @return bool
     */
    public function isUnitCategoryValid(){
        $chemicalUnitCategory = $this->getChemical()->getUnitCategory()->getId();
        $componentUnitCategory = $this->getUnit()->getUnitCategory()->getId();

        return $chemicalUnitCategory == $componentUnitCategory;
    }
}
