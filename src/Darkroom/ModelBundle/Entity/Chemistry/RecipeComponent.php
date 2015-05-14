<?php

namespace Smaloron\Darkroom\ModelBundle\Entity\Chemistry;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RecipeComponent
 *
 * @ORM\Table(name="recipe_components", indexes={@ORM\Index(name="recipe_component_unit", columns={"unit_id"}), @ORM\Index(name="recipe_component_to_chemical_product", columns={"chemical_id"}), @ORM\Index(name="recipe_component_to_recipe", columns={"recipe_id"})})
 * @ORM\Entity
 */
class RecipeComponent
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
     * @ORM\Column(name="quantity", type="float", precision=10, scale=0, nullable=false)
     */
    private $quantity;

    /**
     * @var \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalProduct
     *
     * @ORM\ManyToOne(targetEntity="ChemicalProduct", inversedBy="recipes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chemical_id", referencedColumnName="id")
     * })
     */
    private $chemical;

    /**
     * @var \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalRecipe
     *
     * @ORM\ManyToOne(targetEntity="ChemicalRecipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     * })
     */
    private $recipe;

    /**
     * @var \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\Unit
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
     * @return \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalProduct
     */
    public function getChemical()
    {
        return $this->chemical;
    }

    /**
     * Set chemical
     *
     * @param \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalProduct $chemical
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
     * @return \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalRecipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set recipe
     *
     * @param \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\ChemicalRecipe $recipe
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
     * @return \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set unit
     *
     * @param \Smaloron\Darkroom\ModelBundle\Entity\Chemistry\Unit $unit
     * @return RecipeComponent
     */
    public function setUnit(Unit $unit = null)
    {
        $this->unit = $unit;

        return $this;
    }
}
